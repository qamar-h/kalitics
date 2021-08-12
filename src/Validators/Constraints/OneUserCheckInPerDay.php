<?php

namespace App\Validators\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class OneUserCheckInPerDay extends Constraint
{
    public $message = 'L\'utilisateur "{{ string }}" à dèja pointé sur ce chantier pour le "{{ date }}".';
}