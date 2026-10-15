<?php

declare(strict_types=1);

namespace PetrosLabs\FrValidatorSymfony\Constraints;

use PetrosLabs\FrValidator\Bic\BicValidator as CoreBicValidator;
use PetrosLabs\FrValidator\ValidatorInterface;
use Symfony\Component\Validator\Constraint;

final class BicValidator extends AbstractFrConstraintValidator
{
    protected function coreValidator(Constraint $constraint): ValidatorInterface
    {
        return new CoreBicValidator();
    }
}
