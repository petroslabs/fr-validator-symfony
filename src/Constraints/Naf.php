<?php

declare(strict_types=1);

namespace PetrosLabs\FrValidatorSymfony\Constraints;

use Symfony\Component\Validator\Attribute\HasNamedArguments;
use Symfony\Component\Validator\Constraint;

#[\Attribute(\Attribute::TARGET_PROPERTY | \Attribute::TARGET_METHOD)]
final class Naf extends Constraint implements FrConstraintInterface
{
    public string $message = 'This value is not a valid French NAF/APE activity code: {{ reason }}';

    /**
     * Extra codes to accept on top of the embedded nomenclature snapshot —
     * see petroslabs/fr-validator's NafValidator for why this exists.
     *
     * @var list<string>
     */
    public array $additionalCodes = [];

    /**
     * @param list<string>|null $additionalCodes
     */
    #[HasNamedArguments]
    public function __construct(?string $message = null, ?array $additionalCodes = null, ?array $groups = null, mixed $payload = null)
    {
        parent::__construct(null, $groups, $payload);

        $this->message = $message ?? $this->message;
        $this->additionalCodes = $additionalCodes ?? $this->additionalCodes;
    }

    public function getMessage(): string
    {
        return $this->message;
    }
}
