<?php

declare(strict_types=1);

namespace PetrosLabs\FrValidatorSymfony\Constraints;

use Symfony\Component\Validator\Attribute\HasNamedArguments;
use Symfony\Component\Validator\Constraint;

#[\Attribute(\Attribute::TARGET_PROPERTY | \Attribute::TARGET_METHOD)]
final class Rib extends Constraint implements FrConstraintInterface
{
    public string $message = 'This value is not a valid French bank account number (RIB): {{ reason }}';

    #[HasNamedArguments]
    public function __construct(?string $message = null, ?array $groups = null, mixed $payload = null)
    {
        parent::__construct(null, $groups, $payload);

        $this->message = $message ?? $this->message;
    }

    public function getMessage(): string
    {
        return $this->message;
    }
}
