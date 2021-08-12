<?php

namespace App\DataFixtures;

use App\Entity\CheckIn;
use App\Entity\ConstructionSite;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class DataFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        for ($i = 1; $i < 6; $i++) {
            $constructionSite = (new ConstructionSite)
                ->setName('Chantier ' . $i)
                ->setAddress($i .' rue de Paris')
                ->setPostalCode('9' . $i . '200')
                ->setCity('Paris')
                ->setStartDate((new \DateTime())->modify('+'.$i.' month')->modify('+' .$i. ' days'))
                ->setCreatedAt(new \DateTimeImmutable())
            ;

            $user = (new User)
                ->setFirstname('Utilisateur ' .$i)
                ->setLastname('NOM ' . $i)
                ->setRegistrationNumber('MAT' . $i)
                ->setCreatedAt(new \DateTimeImmutable);

            $checkIn = (new CheckIn)
                ->setDateOfCheckIn((new \DateTime())->modify('+' .$i. ' days'))
                ->setDuration(60 * $i)
                ->setUser($user)
                ->setConstructionSite($constructionSite)
                ->setCreatedAt(new \DateTimeImmutable);

            $manager->persist($constructionSite);
            $manager->persist($user);
            $manager->persist($checkIn);
        }

        $manager->flush();
    }

}
