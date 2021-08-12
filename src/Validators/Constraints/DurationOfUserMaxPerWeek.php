<?php

namespace App\Validators\Constraints;

use App\Entity\CheckIn;
use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class DurationOfUserMaxPerWeek extends Constraint
{
    public $message = 'L\'utilisateur "{{ string }}" est déjà à "{{ hour }}", la limite est de ' . CheckIn::DURATION_HOUR_LIMIT_PER_WEEK . 'h/semaine".';
}