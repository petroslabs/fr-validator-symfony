<?php

declare(strict_types=1);

namespace PetrosLabs\FrValidatorSymfony\Tests\Constraints;

use PetrosLabs\FrValidatorSymfony\Constraints\Naf;
use PetrosLabs\FrValidatorSymfony\Constraints\NafValidator;
use PHPUnit\Framework\Attributes\Test;
use Symfony\Component\Validator\ConstraintValidatorInterface;
use Symfony\Component\Validator\Exception\UnexpectedValueException;
use Symfony\Component\Validator\Test\ConstraintValidatorTestCase;

/**
 * @extends ConstraintValidatorTestCase<NafValidator>
 */
final class NafValidatorTest extends ConstraintValidatorTestCase
{
    protected function createValidator(): ConstraintValidatorInterface
    {
        return new NafValidator();
    }

    #[Test]
    public function null_is_valid(): void
    {
        $this->validator->validate(null, new Naf());

        $this->assertNoViolation();
    }

    #[Test]
    public function empty_string_is_valid(): void
    {
        $this->validator->validate('', new Naf());

        $this->assertNoViolation();
    }

    #[Test]
    public function a_valid_naf_code_raises_no_violation(): void
    {
        $this->validator->validate('62.01Z', new Naf());

        $this->assertNoViolation();
    }

    #[Test]
    public function an_unknown_code_passed_as_additional_raises_no_violation(): void
    {
        $this->validator->validate('0000A', new Naf(additionalCodes: ['0000A']));

        $this->assertNoViolation();
    }

    #[Test]
    public function an_invalid_naf_code_raises_a_violation_carrying_the_failure_reason(): void
    {
        $constraint = new Naf();

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

        $this->validator->validate(12345, new Naf());
    }
}
