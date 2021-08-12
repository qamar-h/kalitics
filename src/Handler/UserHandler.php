<?php

namespace App\Handler;

use App\Entity\User;

class UserHandler extends AbstractHandler
{

    public function delete(User $user)
    {
        foreach ($user->getCheckIns() as $checkIn) {
            $this->em->remove($checkIn);
        }
        $this->em->remove($user);
        $this->em->flush();
    }

    public function save(User $user)
    {
        if($user->getId() === null) {
            $user->setCreatedAt(new \DateTimeImmutable);
        }
        $this->em->persist($user);
        $this->em->flush();
    }


}