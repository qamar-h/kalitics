<?php

namespace App\Validators\Constraints;

use App\Entity\CheckIn;
use App\Service\Duration;
use App\Service\WeekDetails;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;

class DurationOfUserMaxPerWeekValidator extends AbstractCheckInValidator
{

    public function validate($value, Constraint $constraint)
    {
        if (!$constraint instanceof DurationOfUserMaxPerWeek) {
            throw new UnexpectedTypeException($constraint, DurationOfUserMaxPerWeek::class);
        }

        if (!$this->support($value)) {
            return;
        }

        $checkIn = $this->context->getObject();
        $user = $checkIn->getUser();
        $weekDetails = new WeekDetails($checkIn->getDateOfCheckIn()->format('W'));

        $userDuraction = $this->checkInRepository->userDurationBetweenDates(
            $user,
            $checkIn->getConstructionSite(),
            $weekDetails->getStartDate(),
            $weekDetails->getEndDate()
        );

        $time = (intval($userDuraction) + intval($value));
        $hours = Duration::getHours($time);
        $minutes = Duration::getMinutes($time);

        if(($time / 60) > CheckIn::DURATION_HOUR_LIMIT_PER_WEEK ) {
            $this->context->buildViolation($constraint->message)
                ->setParameter('{{ string }}', $user->getFirstname() . ' ' . $user->getLastname())
                ->setParameter('{{ hour }}', sprintf('%02d heure(s) %02d minute(s)', $hours, $minutes))
                ->addViolation();
        }

    }

    protected function support($value): bool
    {
        return $this->contextInstanceOfCheckIn()
            && $this->hasConstructionSite()
            && null !== $value && $value != '';
    }

}