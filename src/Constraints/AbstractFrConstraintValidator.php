<?php

declare(strict_types=1);

namespace PetrosLabs\FrValidatorSymfony\Constraints;

use PetrosLabs\FrValidator\ValidatorInterface;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;
use Symfony\Component\Validator\Exception\UnexpectedValueException;

/**
 * Shared glue between a core PetrosLabs\FrValidator validator and Symfony's
 * Validator component: short-circuits on null/empty (matching Symfony's
 * own constraints — use NotBlank separately if emptiness itself is an
 * error), type-checks the input, delegates to the core validator, and
 * turns a failed ValidationResult into a violation with the failure
 * reason exposed as both the `{{ reason }}` message parameter and the
 * violation code, so consuming apps can branch or translate on it without
 * parsing the message text.
 */
abstract class AbstractFrConstraintValidator extends ConstraintValidator
{
    public function validate(mixed $value, Constraint $constraint): void
    {
        if (!$constraint instanceof FrConstraintInterface) {
            throw new UnexpectedTypeException($constraint, FrConstraintInterface::class);
        }

        if (null === $value || '' === $value) {
            return;
        }

        if (!is_string($value)) {
            throw new UnexpectedValueException($value, 'string');
        }

        $result = $this->coreValidator($constraint)->validate($value);

        if ($result->isValid()) {
            return;
        }

        $failureReason = $result->failureReason();

        /**
         * Every concrete FailureReason enum in petroslabs/fr-validator is
         * string-backed, but the generic \BackedEnum contract it extends
         * allows int|string, so PHPStan can't narrow this from the marker
         * interface alone — hence the cast. $failureReason is only null
         * when $result is valid, which was already ruled out above.
         */
        $reason = null !== $failureReason ? (string) $failureReason->value : '';

        $this->context->buildViolation($constraint->getMessage())
            ->setParameter('{{ value }}', $this->formatValue($value))
            ->setParameter('{{ reason }}', $reason)
            ->setCode($reason)
            ->addViolation();
    }

    abstract protected function coreValidator(Constraint $constraint): ValidatorInterface;
}
