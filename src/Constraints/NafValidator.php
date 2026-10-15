<?php

declare(strict_types=1);

namespace PetrosLabs\FrValidatorSymfony\Constraints;

use PetrosLabs\FrValidator\Naf\NafValidator as CoreNafValidator;
use PetrosLabs\FrValidator\ValidatorInterface;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;

final class NafValidator extends AbstractFrConstraintValidator
{
    protected function coreValidator(Constraint $constraint): ValidatorInterface
    {
        if (!$constraint instanceof Naf) {
            throw new UnexpectedTypeException($constraint, Naf::class);
        }

        return new CoreNafValidator($constraint->additionalCodes);
    }
}
