<?php

namespace App\Handler;

use Doctrine\ORM\EntityManagerInterface;

abstract class AbstractHandler
{

    protected $em;
    protected $repository;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

}