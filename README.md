# fr-validator-symfony

[![CI](https://github.com/petroslabs/fr-validator-symfony/actions/workflows/ci.yml/badge.svg)](https://github.com/petroslabs/fr-validator-symfony/actions/workflows/ci.yml)
[![Mutation testing badge](https://img.shields.io/endpoint?style=flat&url=https%3A%2F%2Fbadge-api.stryker-mutator.io%2Fgithub.com%2Fpetroslabs%2Ffr-validator-symfony%2Fmain)](https://dashboard.stryker-mutator.io/reports/github.com/petroslabs/fr-validator-symfony/main)
[![Packagist](https://img.shields.io/packagist/v/petroslabs/fr-validator-symfony)](https://packagist.org/packages/petroslabs/fr-validator-symfony)
[![License](https://img.shields.io/badge/license-MIT-blue)](LICENSE)

Symfony Validator constraints for [`petroslabs/fr-validator`](https://github.com/petroslabs/fr-validator):
NIR, RIB, SIREN, SIRET, IBAN, BIC, VAT number, NAF/APE and phone number, as
`#[Constraint]` attributes.

## Why a separate package

The core library has zero framework dependency on purpose — most consumers
just want to check a string. This package exists only to translate that
into Symfony's Validator component, with its own release cycle and test
matrix across supported Symfony versions. If you don't use Symfony, you
don't need this package at all.

## Installation

```bash
composer require petroslabs/fr-validator-symfony
```

## Usage

```php
use PetrosLabs\FrValidatorSymfony\Constraints as Assert;

final class CompanyProfile
{
    #[Assert\Siret]
    public string $siret;

    #[Assert\Iban]
    public string $iban;

    #[Assert\Vat(message: 'This VAT number looks wrong: {{ reason }}')]
    public string $vatNumber;

    #[Assert\Naf(additionalCodes: ['9999Z'])]
    public string $nafCode;
}
```

Each constraint short-circuits on `null`/`''` (combine with `NotBlank` if
emptiness itself should be rejected), and on failure exposes the core
library's typed failure reason — not just a generic "invalid" message — as
both the `{{ reason }}` message parameter and the violation code:

```php
$violations = $validator->validate($companyProfile);

foreach ($violations as $violation) {
    $violation->getCode(); // e.g. "invalid_checksum", "unknown_code"
}
```

## Constraints

| Constraint | Wraps |
|---|---|
| `Nir` | NIR (social security number) |
| `Rib` | RIB key |
| `Siren` | SIREN |
| `Siret` | SIRET |
| `Iban` | French IBAN |
| `Bic` | BIC/SWIFT (general format) |
| `Vat` | French VAT number |
| `Naf` | NAF/APE activity code (accepts `additionalCodes`, see the core package) |
| `Phone` | French phone number |

Scope and known limitations for each one are documented in the core
package's [README](https://github.com/petroslabs/fr-validator#readme) —
this bridge doesn't change or repeat them.

## Known v1 simplification

Messages ship with an English default and no pre-built translations —
override them like any other Symfony constraint (per-constraint `message`
option, or your app's own `translations/validators.*.yaml` since no custom
translation domain is set). A French-first package not shipping French
translations by default is a real gap; it's just not solved yet.

## Development

```bash
composer install
composer check  # tests + PHPStan (level max) + code style check
```

See [CONTRIBUTING.md](CONTRIBUTING.md).

## Security

See [SECURITY.md](SECURITY.md) to report a vulnerability.

## License

MIT — see [LICENSE](LICENSE).
