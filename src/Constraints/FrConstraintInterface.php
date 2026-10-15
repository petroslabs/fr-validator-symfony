<?php

declare(strict_types=1);

namespace PetrosLabs\FrValidatorSymfony\Constraints;

/**
 * Implemented by every Constraint in this package so
 * AbstractFrConstraintValidator can read the configured message without
 * knowing the concrete Constraint class.
 */
interface FrConstraintInterface
{
    public function getMessage(): string;
}
