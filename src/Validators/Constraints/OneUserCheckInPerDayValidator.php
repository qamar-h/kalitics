<?php

namespace App\Validators\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;

class OneUserCheckInPerDayValidator extends AbstractCheckInValidator
{
    public function validate($value, Constraint $constraint)
    {
        if (!$constraint instanceof OneUserCheckInPerDay) {
            throw new UnexpectedTypeException($constraint, OneUserCheckInPerDay::class);
        }

        if (!$this->support($value)) {
            return;
        }

        $checkIn = $this->context->getObject();

        $userIsAlReadyCheckInToday = $this->checkInRepository
            ->userAlReadyRegisteredForDay($value, $checkIn->getConstructionSite(), $checkIn->getDateOfCheckIn());

        if (!empty($userIsAlReadyCheckInToday)) {
            $this->context->buildViolation($constraint->message)
                ->setParameter('{{ string }}', $value->getFirstname() . ' ' . $value->getLastname())
                ->setParameter('{{ date }}', $checkIn->getDateOfCheckIn()->format('d/m/Y'))
                ->addViolation();
        }

    }

    protected function support($value): bool
    {
        return $this->contextInstanceOfCheckIn()
            && $this->context->getObject()->getId() === null
            && $this->hasConstructionSite()
            && $this->instanceOfUser($value);
    }

}