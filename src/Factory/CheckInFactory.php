<?php

namespace App\Factory;

use App\Entity\CheckIn;
use App\Repository\ConstructionSiteRepository;
use App\Repository\UserRepository;

class CheckInFactory
{

    private $constructionSiteRepository;
    private $userRepository;

    public function __construct(ConstructionSiteRepository $constructionSiteRepository, UserRepository $userRepository)
    {
        $this->constructionSiteRepository = $constructionSiteRepository;
        $this->userRepository = $userRepository;
    }

    public function createFromArray(array $data): CheckIn
    {
        $checkIn = new CheckIn;

        $this->setConstructionSiteFromArray($checkIn, $data);

        $this->setUserFromArray($checkIn, $data);

        $this->setDateOfCheckInFromArray($checkIn, $data);

        if(isset($data['duration']) && !empty($data['duration'])) {
            $checkIn->setDuration(intval($data['duration']));
        }

        return $checkIn;
    }

    private function setConstructionSiteFromArray(CheckIn $checkIn, array $data): void
    {
        if(
            isset($data['constructionSite'])
            && !empty($data['constructionSite'])
            && null !== $constructionSite = $this->constructionSiteRepository->find(intval($data['constructionSite']))
        ) {
            $checkIn->setConstructionSite($constructionSite);
        }
    }

    private function setUserFromArray(CheckIn $checkIn, array $data): void
    {
        if(
            isset($data['user'])
            && !empty($data['user'])
            && null !== $user = $this->userRepository->find(intval($data['user']))
        ) {
            $checkIn->setUser($user);
        }

    }

    private function setDateOfCheckInFromArray(CheckIn $checkIn, array $data): void
    {
        if(
            isset($data['dateOfCheckIn'])
            && !empty($data['dateOfCheckIn'])
            && preg_match('/^([0-9]{4})-([0-9]{2})-([0-9]{2})/', $data['dateOfCheckIn'])
        ) {
            $checkIn->setDateOfCheckIn(new \DateTime($data['dateOfCheckIn']));
        }
    }
}