<?php

namespace App\Controller;

use App\Entity\CheckIn;
use App\Form\CheckInType;
use App\Repository\CheckInRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/check-in")
 */
class CheckInController extends AbstractController
{

    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * @Route("/", name="check_in_index", methods={"GET"})
     * @param CheckInRepository $checkInRepository
     * @return Response
     */
    public function index(CheckInRepository $checkInRepository): Response
    {
        return $this->render('check_in/index.html.twig', [
            'check_ins' => $checkInRepository->findBy([],['id' => 'desc']),
        ]);
    }

    /**
     * @Route("/new", name="check_in_new", methods={"GET","POST"})
     * @Route("/{id}/edit", name="check_in_edit", methods={"GET","POST"})
     * @param Request $request
     * @param CheckIn|null $checkIn
     * @return Response
     */
    public function form(Request $request, CheckIn $checkIn = null): Response
    {
        $checkIn = $checkIn === null ? new CheckIn : $checkIn;
        $form = $this->createForm(CheckInType::class, $checkIn);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            if($checkIn->getId() === null) {
                $checkIn->setCreatedAt(new \DateTimeImmutable);
            }

            $this->em->persist($checkIn);
            $this->em->flush();
            $this->addFlash('success','Pointage sauvegardé avec succès.');
            return $this->redirectToRoute('check_in_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('check_in/form.html.twig', [
            'check_in' => $checkIn,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="check_in_show", methods={"GET"})
     * @param CheckIn $checkIn
     * @return Response
     */
    public function show(CheckIn $checkIn): Response
    {
        return $this->render('check_in/show.html.twig', [
            'check_in' => $checkIn,
        ]);
    }

    /**
     * @Route("/{id}", name="check_in_delete", methods={"POST"})
     * @param Request $request
     * @param CheckIn $checkIn
     * @return Response
     */
    public function delete(Request $request, CheckIn $checkIn): Response
    {
        if ($this->isCsrfTokenValid('delete'.$checkIn->getId(), $request->request->get('_token'))) {
            $this->em->remove($checkIn);
            $this->em->flush();
            $this->addFlash('success','Pointage supprimé avec succès.');
        }

        return $this->redirectToRoute('check_in_index', [], Response::HTTP_SEE_OTHER);
    }
}
