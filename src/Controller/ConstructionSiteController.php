<?php

namespace App\Controller;

use App\Entity\ConstructionSite;
use App\Form\ConstructionSiteType;
use App\Handler\ConstructionSiteHandler;
use App\Repository\CheckInRepository;
use App\Repository\ConstructionSiteRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/construction-site")
 */
class ConstructionSiteController extends AbstractController
{
    private $handler;

    public function __construct(ConstructionSiteHandler $handler)
    {
        $this->handler = $handler;
    }

    /**
     * @Route("/", name="construction_site_index", methods={"GET"})
     * @param ConstructionSiteRepository $constructionSiteRepository
     * @return Response
     */
    public function index(ConstructionSiteRepository $constructionSiteRepository): Response
    {
        return $this->render('construction_site/index.html.twig', [
            'construction_sites' => $constructionSiteRepository->findBy([],['id' => 'desc']),
        ]);
    }

    /**
     * @Route("/new", name="construction_site_new", methods={"GET","POST"})
     * @Route("/{id}/edit", name="construction_site_edit", methods={"GET","POST"})
     * @param Request $request
     * @param ConstructionSite|null $constructionSite
     * @return Response
     */
    public function form(Request $request, ConstructionSite $constructionSite = null): Response
    {
        $constructionSite = $constructionSite === null ? new ConstructionSite : $constructionSite;
        $form = $this->createForm(ConstructionSiteType::class, $constructionSite);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            try {
                $this->handler->save($constructionSite);
                $this->addFlash('success','Chantier sauvegardé avec succès.');
            }
            catch (\Exception $e) {
                $this->addFlash('error','Une erreur est survenue lors de la sauvegarde.');
            }

            return $this->redirectToRoute('construction_site_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('construction_site/form.html.twig', [
            'construction_site' => $constructionSite,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="construction_site_show", methods={"GET"})
     * @param ConstructionSite $constructionSite
     * @param CheckInRepository $checkInRepository
     * @return Response
     */
    public function show(ConstructionSite $constructionSite, CheckInRepository $checkInRepository): Response
    {
        $usersChecked = $checkInRepository->userCheckedOfConstructionSite($constructionSite,[
            'user.id',
            'user.lastname',
            'user.firstname',
            'user.registrationNumber',
            'SUM(c.duration) as duration'
        ]);
        return $this->render('construction_site/show.html.twig', [
            'construction_site' => $constructionSite,
            'users_checked' => $usersChecked
        ]);
    }

    /**
     * @Route("/{id}", name="construction_site_delete", methods={"POST"})
     * @param Request $request
     * @param ConstructionSite $constructionSite
     * @return Response
     */
    public function delete(Request $request, ConstructionSite $constructionSite): Response
    {
        if ($this->isCsrfTokenValid('delete'.$constructionSite->getId(), $request->request->get('_token'))) {
            try{
                $this->handler->delete($constructionSite);
                $this->addFlash('success', "Chantier supprimé avec succès.");
            }
            catch(\Exception $e) {
                $this->addFlash('error', "Une erreur est survenue lors de la suppression.");
            }
        }
        return $this->redirectToRoute('construction_site_index', [], Response::HTTP_SEE_OTHER);
    }
}
