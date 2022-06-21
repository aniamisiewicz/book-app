<?php
/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Controller;

use App\Entity\Book;
use App\Entity\Comment;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use App\Form\BookType;
use App\Form\Category;
use App\Form\CommentType;
use App\Form\CommentTypeDelete;
use Symfony\Component\Security\Core\Security;
use App\Repository\BookRepository;
use App\Service\CommentServiceInterface;
use App\Service\BookServiceInterface;
use Symfony\Contracts\Translation\TranslatorInterface;
use App\Service\CategoryServiceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Knp\Component\Pager\PaginatorInterface;

/**
 * Class BookController.
 */
#[Route('/book')]
class BookController extends AbstractController
{
    /**
     * Translator.
     */
    private TranslatorInterface $translator;

    /**
     * Security.
     */
    private Security $security;

    /**
     * BookServiceInterface.
     */
    private BookServiceInterface $bookService;

    /**
     * CommentService.
     */
    private CommentServiceInterface $commentServiceInterface;

    /**
     * CategoryServiceInterface.
     */
    private CategoryServiceInterface $categoryServiceInterface;

    /**
     * Constructor.
     *
     * @param BookServiceInterface     $bookService              Book service
     * @param CommentServiceInterface  $commentServiceInterface  Comment service
     * @param CategoryServiceInterface $categoryServiceInterface Category Service
     * @param Security                 $security                 Security
     * @param TranslatorInterface      $translator               Translator
     */
    public function __construct(BookServiceInterface $bookService, CommentServiceInterface $commentServiceInterface, CategoryServiceInterface $categoryServiceInterface, Security $security, TranslatorInterface $translator)
    {
        $this->bookService = $bookService;
        $this->commentServiceInterface = $commentServiceInterface;
        $this->categoryServiceInterface = $categoryServiceInterface;
        $this->security = $security;
        $this->translator = $translator;
    }

    /**
     * Index action.
     *
     * @param Request              $request     HTTP Request
     * @param BookServiceInterface $bookService Book service
     * @param PaginatorInterface   $paginator   Paginator
     *
     * @return Response HTTP response
     */
    #[Route('/', name: 'app_book_index', methods: ['GET'])]
    public function index(Request $request, BookServiceInterface $bookService, PaginatorInterface $paginator): Response
    {
        $filters = $this->getFilters($request);
        $filters = $this->prepareFilters($filters);

        $pagination = $paginator->paginate(
            $bookService->queryAll($filters),
            $request->query->getInt('page', 1),
            BookRepository::PAGINATOR_ITEMS_PER_PAGE
        );

        return $this->render('book/index.html.twig', [
            'pagination' => $pagination,
        ]);
    }

    /**
     * Prepare filters for the tasks list.
     *
     * @param array<string, int> $filters Raw filters from request
     *
     * @return array<string, object> Result array of filters
     */
    public function prepareFilters(array $filters): array
    {
        $resultFilters = [];
        if (!empty($filters['category_id'])) {
            $category = $this->categoryServiceInterface->findOneById($filters['category_id']);
            if (null !== $category) {
                $resultFilters['category'] = $category;
            }
        }

        return $resultFilters;
    }

    /**
     * Get filters from request.
     *
     * @param Request $request HTTP request
     *
     * @return array<string, int> Array of filters
     *
     * @psalm-return array{category_id: int}
     */
    public function getFilters(Request $request): array
    {
        $filters = [];
        $filters['category_id'] = $request->query->getInt('filters_category_id');

        return $filters;
    }

    /**
     * Get pagination.
     *
     * @param mixed $page
     *
     * @return Response response
     */
    #[Route('/pagination/{page}', name: 'app_book_pagination', methods: ['GET'])]
    public function pagination($page): Response
    {
        $books = $this->bookService->findAll($page);
        $pageCount = $this->bookService->getPageCount();

        return $this->render('book/index.html.twig', [
            'books' => $books,
            'page' => $page,
            'pageCount' => $pageCount,
        ]);
    }

    /**
     * New action.
     *
     * @param Request $request HTTP request
     *
     * @return Response HTTP response
     */
    #[IsGranted('ROLE_ADMIN')]
    #[Route('/new', name: 'app_book_new', methods: ['GET', 'POST'])]
    public function new(Request $request): Response
    {
        $book = new Book();
        $user = $this->getUser();
        $book->setCreator($user);
        $form = $this->createForm(BookType::class, $book, [
            'action' => $this->generateUrl('app_book_new', ['id' => $book->getId()]),
        ]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->bookService->add($book);

            return $this->redirectToRoute('app_book_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('book/new.html.twig', [
            'book' => $book,
            'form' => $form,
        ]);
    }

    /**
     * Show action.
     *
     * @param Request $request HTTP request
     * @param Book    $book    Book
     *
     * @return Response HTTP response
     */
    #[Route('/show/{id}', name: 'app_book_show', methods: ['GET', 'POST'])]
    public function show(Request $request, Book $book): Response
    {
        $comment = new Comment();
        $comment->setBook($book);
        if (null !== $this->security->getUser()) {
            $comment->setEmail($this->security->getUser()->getEmail());
            $comment->setNick($this->security->getUser()->getName());
        }
        $form = $this->createForm(CommentType::class, $comment, [
            'action' => $this->generateUrl('app_book_show', ['id' => $book->getId()]),
        ]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->commentServiceInterface->add($comment);
        }

        return $this->renderForm('book/show.html.twig', [
            'book' => $book,
            'form' => $form,
            'comments' => $book->getComments(),
        ]);
    }

    /**
     * Edit action.
     *
     * @param Request $request HTTP request
     * @param Book    $book    Book
     *
     * @return Response HTTP response
     */
    #[IsGranted('ROLE_ADMIN')]
    #[Route('/edit/{id}', name: 'app_book_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Book $book): Response
    {
        $form = $this->createForm(BookType::class, $book, [
            'action' => $this->generateUrl('app_book_edit', ['id' => $book->getId()]),
        ]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->bookService->edit($book);

            return $this->redirectToRoute('app_book_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('book/edit.html.twig', [
            'book' => $book,
            'form' => $form,
        ]);
    }

    /**
     * Delete comment action.
     *
     * @param Request $request HTTP request
     * @param Comment $comment Comment entity
     *
     * @return Response HTTP response
     */
    #[Route('/comment/{id}', name: 'comment_delete', requirements: ['id' => '[1-9]\d*'], methods: 'GET|DELETE')]
    public function deleteComment(Request $request, Comment $comment): Response
    {
        $form = $this->createForm(CommentTypeDelete::class, $comment, [
            'method' => 'DELETE',
            'action' => $this->generateUrl('comment_delete', ['id' => $comment->getId()]),
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->commentServiceInterface->remove($comment);

            $this->addFlash(
                'success',
                $this->translator->trans('comment.deleted')
            );

            return $this->redirectToRoute('app_book_show', ['id' => $comment->getBook()->getId()], Response::HTTP_SEE_OTHER);
        }

        return $this->render(
            'comment/delete.html.twig',
            [
                'form' => $form->createView(),
                'comment' => $comment,
            ]
        );
    }

    /**
     * Delete action.
     *
     * @param Request $request HTTP request
     * @param Book    $book    Book entity
     *
     * @return Response HTTP response
     */
    #[Route('/{id}/delete', name: 'book_delete', requirements: ['id' => '[1-9]\d*'], methods: 'GET|DELETE')]
    public function delete(Request $request, Book $book): Response
    {
        $form = $this->createForm(FormType::class, $book, [
            'method' => 'DELETE',
            'action' => $this->generateUrl('book_delete', ['id' => $book->getId()]),
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $comments = $book->getComments();
            foreach ($comments as $comment) {
                $this->commentServiceInterface->remove($comment);
            }
            $this->bookService->delete($book);

            $this->addFlash(
                'success',
                $this->translator->trans('book.deleted')
            );

            return $this->redirectToRoute('app_book_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render(
            'book/delete.html.twig',
            [
                'form' => $form->createView(),
                'book' => $book,
            ]
        );
    }
}
