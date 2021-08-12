<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Handler\UserHandler;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/users")
 */
class UserController extends AbstractController
{

    private $handler;

    public function __construct(UserHandler $handler)
    {
        $this->handler = $handler;
    }

    /**
     * @Route("/", name="user_index", methods={"GET"})
     */
    public function index(UserRepository $userRepository): Response
    {
        return $this->render('user/index.html.twig', [
            'users' => $userRepository->findBy([],['id' => 'desc']),
        ]);
    }

    /**
     * @Route("/new", name="user_new", methods={"GET","POST"})
     * @Route("/{id}/edit", name="user_edit", methods={"GET","POST"})
     * @param Request $request
     * @param User|null $user
     * @return Response
     */
    public function form(Request $request, User $user = null): Response
    {
        $user = $user === null ? new User : $user;
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try{
                $this->handler->save($user);
                $this->addFlash('success', 'Utilisateur sauvegardé avec succès.');
            }
            catch (\Exception $e)
            {
                $this->addFlash('error', 'Une erreur est survenue lors de la sauvegarde.');
            }
            return $this->redirectToRoute('user_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('user/form.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="user_show", methods={"GET"})
     */
    public function show(User $user): Response
    {
        return $this->render('user/show.html.twig', [
            'user' => $user,
        ]);
    }

    /**
     * @Route("/{id}", name="user_delete", methods={"POST"})
     * @param Request $request
     * @param User $user
     * @return Response
     */
    public function delete(Request $request, User $user): Response
    {
        if ($this->isCsrfTokenValid('delete'.$user->getId(), $request->request->get('_token'))) {
            try{
                $this->handler->delete($user);
                $this->addFlash('success', "Utilisateur supprimé avec succès.");
            }
            catch(\Exception $e) {
                $this->addFlash('error', "Une erreur est survenue lors de la suppression.");
            }
        }
        return $this->redirectToRoute('user_index', [], Response::HTTP_SEE_OTHER);
    }

}
