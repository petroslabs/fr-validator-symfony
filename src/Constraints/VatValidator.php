<?php

declare(strict_types=1);

namespace PetrosLabs\FrValidatorSymfony\Constraints;

use PetrosLabs\FrValidator\ValidatorInterface;
use PetrosLabs\FrValidator\Vat\VatValidator as CoreVatValidator;
use Symfony\Component\Validator\Constraint;

final class VatValidator extends AbstractFrConstraintValidator
{
    protected function coreValidator(Constraint $constraint): ValidatorInterface
    {
        return new CoreVatValidator();
    }
}
