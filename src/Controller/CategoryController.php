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

use App\Entity\Category;
use App\Form\CategoryType;
use App\Service\CategoryServiceInterface;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use App\Repository\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;
use Knp\Component\Pager\PaginatorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * Class CategoryController.
 */
#[Route('/category')]
class CategoryController extends AbstractController
{
    /**
     * Category service.
     */
    private $categoryServiceInterface;

    /**
     * Translator.
     */
    private TranslatorInterface $translator;

    /**
     * Constructor.
     *
     * @param CategoryServiceInterface $categoryServiceInterface Category Service
     * @param TranslatorInterface      $translator               Translator
     */
    public function __construct(CategoryServiceInterface $categoryServiceInterface, TranslatorInterface $translator)
    {
        $this->categoryServiceInterface = $categoryServiceInterface;
        $this->translator = $translator;
    }

    /**
     * Index action.
     *
     * @param Request                  $request                  HTTP Request
     * @param PaginatorInterface       $paginator                Paginator
     * @param CategoryServiceInterface $categoryServiceInterface Category Service
     *
     * @return Response HTTP response
     */
    #[Route('/', name: 'app_category_index', methods: ['GET'])]
    public function index(Request $request, PaginatorInterface $paginator, CategoryServiceInterface $categoryServiceInterface): Response
    {
        $pagination = $paginator->paginate(
            $categoryServiceInterface->queryAll(),
            $request->query->getInt('page', 1),
            CategoryRepository::PAGINATOR_ITEMS_PER_PAGE
        );

        return $this->render('category/index.html.twig', [
            'pagination' => $pagination,
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
    #[Route('/new', name: 'app_category_new', methods: ['GET', 'POST'])]
    public function new(Request $request): Response
    {
        $category = new Category();
        $form = $this->createForm(CategoryType::class, $category, [
            'action' => $this->generateUrl('app_category_new', ['id' => $category->getId()]),
        ]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->categoryServiceInterface->add($category);

            return $this->redirectToRoute('app_category_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('category/new.html.twig', [
            'category' => $category,
            'form' => $form,
        ]);
    }

    /**
     * Show action.
     *
     * @param Category $category Category
     *
     * @return Response HTTP response
     */
    #[Route('/{id}', name: 'app_category_show', methods: ['GET'])]
    public function show(Category $category): Response
    {
        return $this->render('category/show.html.twig', [
            'category' => $category,
        ]);
    }

    /**
     * Edit action.
     *
     * @param Request  $request  HTTP request
     * @param Category $category Category
     *
     * @return Response HTTP response
     */
    #[IsGranted('ROLE_ADMIN')]
    #[Route('/{id}/edit', name: 'app_category_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Category $category): Response
    {
        $form = $this->createForm(CategoryType::class, $category, [
            'action' => $this->generateUrl('app_category_edit', ['id' => $category->getId()]),
        ]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->categoryServiceInterface->add($category);

            return $this->redirectToRoute('app_category_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('category/edit.html.twig', [
            'category' => $category,
            'form' => $form,
        ]);
    }

    /**
     * Delete action.
     *
     * @param Request  $request  HTTP request
     * @param Category $category Category entity
     *
     * @return Response HTTP response
     */
    #[Route('/{id}/delete', name: 'category_delete', requirements: ['id' => '[1-9]\d*'], methods: 'GET|DELETE')]
    public function delete(Request $request, Category $category): Response
    {
        if (!$this->categoryServiceInterface->canBeDeleted($category)) {
            $this->addFlash(
                'warning',
                $this->translator->trans('category.warning')
            );

            return $this->redirectToRoute('app_category_index');
        }

        $form = $this->createForm(FormType::class, $category, [
            'method' => 'DELETE',
            'action' => $this->generateUrl('category_delete', ['id' => $category->getId()]),
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->categoryServiceInterface->delete($category);

            $this->addFlash(
                'success',
                $this->translator->trans('category.deleted')
            );

            return $this->redirectToRoute('app_category_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render(
            'category/delete.html.twig',
            [
                'form' => $form->createView(),
                'category' => $category,
            ]
        );
    }
}
