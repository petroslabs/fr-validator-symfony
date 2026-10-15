<?php

declare(strict_types=1);

namespace PetrosLabs\FrValidatorSymfony\Constraints;

use PetrosLabs\FrValidator\Nir\NirValidator as CoreNirValidator;
use PetrosLabs\FrValidator\ValidatorInterface;
use Symfony\Component\Validator\Constraint;

final class NirValidator extends AbstractFrConstraintValidator
{
    protected function coreValidator(Constraint $constraint): ValidatorInterface
    {
        return new CoreNirValidator();
    }
}
