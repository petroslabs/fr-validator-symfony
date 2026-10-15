# Contributing

Thanks for considering a contribution.

## Setup

```bash
composer install
```

PHP 8.2+ is required. If you use [mise](https://mise.jdx.dev), the pinned
version is picked up automatically from `.mise.toml`.

This package depends on `petroslabs/fr-validator` via a VCS repository
entry in `composer.json` (pointing at its GitHub repo) rather than
Packagist, until that package is published there too — see its own
CONTRIBUTING.md for context.

## Before opening a PR

```bash
composer check   # runs tests, PHPStan (level max) and the code style check
```

Or individually: `composer test`, `composer stan`, `composer cs` (check only)
/ `composer cs-fix` (auto-fix).

## Adding a new constraint

Each constraint pairs a `Constraint` class (public `message` property,
`#[HasNamedArguments]` constructor, implements `FrConstraintInterface`) with
a `ConstraintValidator` extending `AbstractFrConstraintValidator` — look at
`Nir`/`NirValidator` as the template. Do **not** duplicate the null/empty
short-circuit, type check, or violation-building logic found in
`AbstractFrConstraintValidator`; only `coreValidator()` should differ per
constraint.

This package should stay a thin translation layer: the validation logic,
its sources, and its documented limitations belong in
[`petroslabs/fr-validator`](https://github.com/petroslabs/fr-validator), not
here.

## Commit messages

[Conventional Commits](https://www.conventionalcommits.org/), imperative,
English: `feat:`, `fix:`, `refactor:`, `docs:`, `test:`, `chore:`.

## Code of conduct

This project follows the [Code of Conduct](CODE_OF_CONDUCT.md).
