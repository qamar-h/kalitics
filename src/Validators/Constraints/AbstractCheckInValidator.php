<?php

namespace App\Validators\Constraints;

use App\Entity\CheckIn;
use App\Entity\User;
use App\Repository\CheckInRepository;
use Symfony\Component\Validator\ConstraintValidator;

abstract class AbstractCheckInValidator extends ConstraintValidator
{
    protected $checkInRepository;

    public function __construct(CheckInRepository $checkInRepository)
    {
        $this->checkInRepository = $checkInRepository;
    }

    protected function support($value): bool
    {
        return $this->contextInstanceOfCheckIn()
            && $this->hasConstructionSite();
    }

    protected function hasConstructionSite(): bool
    {
        return $this->context->getObject()->getConstructionSite() !== null;
    }

    protected function instanceOfUser($value): bool
    {
        return $value instanceof User;
    }

    protected function contextInstanceOfCheckIn(): bool
    {
        return $this->context->getObject() instanceof CheckIn;
    }

}