<?php

declare(strict_types=1);

namespace PetrosLabs\FrValidatorSymfony\Constraints;

use PetrosLabs\FrValidator\Phone\PhoneValidator as CorePhoneValidator;
use PetrosLabs\FrValidator\ValidatorInterface;
use Symfony\Component\Validator\Constraint;

final class PhoneValidator extends AbstractFrConstraintValidator
{
    protected function coreValidator(Constraint $constraint): ValidatorInterface
    {
        return new CorePhoneValidator();
    }
}
