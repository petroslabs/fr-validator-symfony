<?php

declare(strict_types=1);

namespace PetrosLabs\FrValidatorSymfony\Tests\Constraints;

use PetrosLabs\FrValidatorSymfony\Constraints\Nir;
use PetrosLabs\FrValidatorSymfony\Constraints\NirValidator;
use PHPUnit\Framework\Attributes\Test;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidatorInterface;
use Symfony\Component\Validator\Exception\UnexpectedValueException;
use Symfony\Component\Validator\Test\ConstraintValidatorTestCase;

/**
 * @extends ConstraintValidatorTestCase<NirValidator>
 */
final class NirValidatorTest extends ConstraintValidatorTestCase
{
    protected function createValidator(): ConstraintValidatorInterface
    {
        return new NirValidator();
    }

    #[Test]
    public function null_is_valid(): void
    {
        $this->validator->validate(null, new Nir());

        $this->assertNoViolation();
    }

    #[Test]
    public function empty_string_is_valid(): void
    {
        $this->validator->validate('', new Nir());

        $this->assertNoViolation();
    }

    #[Test]
    public function it_defaults_to_the_default_validation_group(): void
    {
        $constraint = new Nir();

        self::assertSame([Constraint::DEFAULT_GROUP], $constraint->groups);
    }

    #[Test]
    public function a_custom_message_is_used_in_the_violation(): void
    {
        $this->validator->validate('invalid', new Nir(message: 'Custom message: {{ reason }}'));

        $this->buildViolation('Custom message: {{ reason }}')
            ->setParameter('{{ value }}', '"invalid"')
            ->setParameter('{{ reason }}', 'invalid_length')
            ->setCode('invalid_length')
            ->assertRaised();
    }

    #[Test]
    public function a_valid_nir_raises_no_violation(): void
    {
        $this->validator->validate('1 85 03 75 116 012 16', new Nir());

        $this->assertNoViolation();
    }

    #[Test]
    public function an_invalid_nir_raises_a_violation_carrying_the_failure_reason(): void
    {
        $constraint = new Nir();

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

        $this->validator->validate(12345, new Nir());
    }
}
