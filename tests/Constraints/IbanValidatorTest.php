<?php

declare(strict_types=1);

namespace PetrosLabs\FrValidatorSymfony\Tests\Constraints;

use PetrosLabs\FrValidatorSymfony\Constraints\Iban;
use PetrosLabs\FrValidatorSymfony\Constraints\IbanValidator;
use PHPUnit\Framework\Attributes\Test;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidatorInterface;
use Symfony\Component\Validator\Exception\UnexpectedValueException;
use Symfony\Component\Validator\Test\ConstraintValidatorTestCase;

/**
 * @extends ConstraintValidatorTestCase<IbanValidator>
 */
final class IbanValidatorTest extends ConstraintValidatorTestCase
{
    protected function createValidator(): ConstraintValidatorInterface
    {
        return new IbanValidator();
    }

    #[Test]
    public function null_is_valid(): void
    {
        $this->validator->validate(null, new Iban());

        $this->assertNoViolation();
    }

    #[Test]
    public function empty_string_is_valid(): void
    {
        $this->validator->validate('', new Iban());

        $this->assertNoViolation();
    }

    #[Test]
    public function it_defaults_to_the_default_validation_group(): void
    {
        $constraint = new Iban();

        self::assertSame([Constraint::DEFAULT_GROUP], $constraint->groups);
    }

    #[Test]
    public function a_custom_message_is_used_in_the_violation(): void
    {
        $this->validator->validate('invalid', new Iban(message: 'Custom message: {{ reason }}'));

        $this->buildViolation('Custom message: {{ reason }}')
            ->setParameter('{{ value }}', '"invalid"')
            ->setParameter('{{ reason }}', 'invalid_length')
            ->setCode('invalid_length')
            ->assertRaised();
    }

    #[Test]
    public function a_valid_iban_raises_no_violation(): void
    {
        $this->validator->validate('FR76 3000 3018 9000 0375 5348 521', new Iban());

        $this->assertNoViolation();
    }

    #[Test]
    public function an_invalid_iban_raises_a_violation_carrying_the_failure_reason(): void
    {
        $constraint = new Iban();

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

        $this->validator->validate(12345, new Iban());
    }
}
