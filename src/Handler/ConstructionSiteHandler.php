<?php

namespace App\Handler;

use App\Entity\ConstructionSite;

class ConstructionSiteHandler extends AbstractHandler
{

    public function delete(ConstructionSite $constructionSite)
    {
        foreach ($constructionSite->getCheckIns() as $checkIn) {
            $this->em->remove($checkIn);
        }
        $this->em->remove($constructionSite);
        $this->em->flush();
    }

    public function save(ConstructionSite $constructionSite)
    {
        if($constructionSite->getId() === null) {
            $constructionSite->setCreatedAt(new \DateTimeImmutable);
        }
        $this->em->persist($constructionSite);
        $this->em->flush();
    }

}