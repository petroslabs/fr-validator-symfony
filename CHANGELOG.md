# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.1.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [Unreleased]

### Added

- Symfony Validator constraints wrapping every validator in
  `petroslabs/fr-validator`: NIR, RIB, SIREN, SIRET, IBAN, BIC, VAT number,
  NAF/APE, phone number.
- Mutation testing (Infection) in CI, same `--min-msi=100` bar as the core
  package.
