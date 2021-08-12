<?php

namespace App\Controller;

use App\Repository\CheckInRepository;
use App\Repository\ConstructionSiteRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     * @param UserRepository $userRepository
     * @param ConstructionSiteRepository $constructionSiteRepository
     * @param CheckInRepository $checkInRepository
     * @return Response
     */
    public function index(
        UserRepository $userRepository,
        ConstructionSiteRepository $constructionSiteRepository,
        CheckInRepository $checkInRepository
    ): Response {
        return $this->render('home/index.html.twig', [
            'userCount' => $userRepository->count([]),
            'constructionSiteCount' => $constructionSiteRepository->count([]),
            'checkInCount' => $checkInRepository->count([])
        ]);
    }
}
