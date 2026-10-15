<?php

declare(strict_types=1);

namespace PetrosLabs\FrValidatorSymfony\Tests\Constraints;

use PetrosLabs\FrValidatorSymfony\Constraints\Siret;
use PetrosLabs\FrValidatorSymfony\Constraints\SiretValidator;
use PHPUnit\Framework\Attributes\Test;
use Symfony\Component\Validator\ConstraintValidatorInterface;
use Symfony\Component\Validator\Exception\UnexpectedValueException;
use Symfony\Component\Validator\Test\ConstraintValidatorTestCase;

/**
 * @extends ConstraintValidatorTestCase<SiretValidator>
 */
final class SiretValidatorTest extends ConstraintValidatorTestCase
{
    protected function createValidator(): ConstraintValidatorInterface
    {
        return new SiretValidator();
    }

    #[Test]
    public function null_is_valid(): void
    {
        $this->validator->validate(null, new Siret());

        $this->assertNoViolation();
    }

    #[Test]
    public function empty_string_is_valid(): void
    {
        $this->validator->validate('', new Siret());

        $this->assertNoViolation();
    }

    #[Test]
    public function a_valid_siret_raises_no_violation(): void
    {
        $this->validator->validate('732 829 320 00074', new Siret());

        $this->assertNoViolation();
    }

    #[Test]
    public function an_invalid_siret_raises_a_violation_carrying_the_failure_reason(): void
    {
        $constraint = new Siret();

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

        $this->validator->validate(12345, new Siret());
    }
}
