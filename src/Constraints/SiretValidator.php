<?php

declare(strict_types=1);

namespace PetrosLabs\FrValidatorSymfony\Constraints;

use PetrosLabs\FrValidator\Siret\SiretValidator as CoreSiretValidator;
use PetrosLabs\FrValidator\ValidatorInterface;
use Symfony\Component\Validator\Constraint;

final class SiretValidator extends AbstractFrConstraintValidator
{
    protected function coreValidator(Constraint $constraint): ValidatorInterface
    {
        return new CoreSiretValidator();
    }
}
