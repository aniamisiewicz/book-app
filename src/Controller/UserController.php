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

use App\Entity\User;
use App\Form\UserType;
use App\Form\UserTypeEdit;
use App\Service\UserServiceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

/**
 * User Controller class.
 */
#[Route('/user')]
class UserController extends AbstractController
{
    /**
     * Password encoder.
     */
    private UserPasswordHasherInterface $passwordEncoder;

    /**
     * User Service.
     */
    private UserServiceInterface $userServiceInterface;

    /**
     * Constructor.
     *
     * @param UserServiceInterface        $userServiceInterface UserServiceInterface
     * @param UserPasswordHasherInterface $passwordEncoder      PasswordEncoder
     */
    public function __construct(UserServiceInterface $userServiceInterface, UserPasswordHasherInterface $passwordEncoder)
    {
        $this->userServiceInterface = $userServiceInterface;
        $this->passwordEncoder = $passwordEncoder;
    }

    /**
     * Index action.
     *
     * @param UserServiceInterface $userServiceInterface User Service
     *
     * @return Response HTTP response
     */
    #[IsGranted('ROLE_ADMIN')]
    #[Route('/', name: 'app_user_index', methods: ['GET'])]
    public function index(UserServiceInterface $userServiceInterface): Response
    {
        return $this->render('user/index.html.twig', [
            'users' => $userServiceInterface->findAll(),
        ]);
    }

    /**
     * New action.
     *
     * @param Request $request HTTP request
     *
     * @return Response HTTP response
     */
    #[Route('/new', name: 'app_user_new', methods: ['GET', 'POST'])]
    public function new(Request $request): Response
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user, [
            'action' => $this->generateUrl('app_user_new', ['id' => $user->getId()]),
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user->setPassword($this->passwordEncoder->hashPassword($user, $user->getPlainPassword()));
            $this->userServiceInterface->add($user);

            return $this->redirectToRoute('app_login', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('user/new.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }

    /**
     * Show action.
     *
     * @param User $user User
     *
     * @return Response HTTP response
     */
    #[Route('/{id}', name: 'app_user_show', methods: ['GET'])]
    public function show(User $user): Response
    {
        return $this->render('user/show.html.twig', [
            'user' => $user,
        ]);
    }

    /**
     * Edit action.
     *
     * @param Request $request HTTP request
     * @param User    $user    User
     *
     * @return Response HTTP response
     */
    #[Route('/{id}/edit', name: 'app_user_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, User $user): Response
    {
        $form = $this->createForm(UserTypeEdit::class, $user, [
            'action' => $this->generateUrl('app_user_edit', ['id' => $user->getId()]),
        ]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user->setPassword($this->passwordEncoder->hashPassword($user, $user->getPlainPassword()));
            $this->userServiceInterface->add($user);

            return $this->redirectToRoute('app_user_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('user/edit.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }

    /**
     * Delete action.
     *
     * @param Request $request HTTP request
     * @param User    $user    User
     *
     * @return Response HTTP response
     */
    #[Route('/{id}', name: 'app_user_delete', methods: ['POST'])]
    public function delete(Request $request, User $user): Response
    {
        if ($this->isCsrfTokenValid('delete'.$user->getId(), $request->request->get('_token'))) {
            $this->userServiceInterface->delete($user);
        }

        return $this->redirectToRoute('app_user_index', [], Response::HTTP_SEE_OTHER);
    }
}
