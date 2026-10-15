<?php

declare(strict_types=1);

namespace PetrosLabs\FrValidatorSymfony\Tests\Constraints;

use PetrosLabs\FrValidatorSymfony\Constraints\Phone;
use PetrosLabs\FrValidatorSymfony\Constraints\PhoneValidator;
use PHPUnit\Framework\Attributes\Test;
use Symfony\Component\Validator\ConstraintValidatorInterface;
use Symfony\Component\Validator\Exception\UnexpectedValueException;
use Symfony\Component\Validator\Test\ConstraintValidatorTestCase;

/**
 * @extends ConstraintValidatorTestCase<PhoneValidator>
 */
final class PhoneValidatorTest extends ConstraintValidatorTestCase
{
    protected function createValidator(): ConstraintValidatorInterface
    {
        return new PhoneValidator();
    }

    #[Test]
    public function null_is_valid(): void
    {
        $this->validator->validate(null, new Phone());

        $this->assertNoViolation();
    }

    #[Test]
    public function empty_string_is_valid(): void
    {
        $this->validator->validate('', new Phone());

        $this->assertNoViolation();
    }

    #[Test]
    public function a_valid_phone_number_raises_no_violation(): void
    {
        $this->validator->validate('06 12 34 56 78', new Phone());

        $this->assertNoViolation();
    }

    #[Test]
    public function an_invalid_phone_number_raises_a_violation_carrying_the_failure_reason(): void
    {
        $constraint = new Phone();

        $this->validator->validate('invalid', $constraint);

        $this->buildViolation($constraint->message)
            ->setParameter('{{ value }}', '"invalid"')
            ->setParameter('{{ reason }}', 'invalid_length')
            ->setCode('invalid_length')
            ->assertRaised();
    }

    #[Test]
    public function a_non_string_value_throws(): void
    {
        $this->expectException(UnexpectedValueException::class);

        $this->validator->validate(12345, new Phone());
    }
}
