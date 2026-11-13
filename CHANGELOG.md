# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.1.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [Unreleased]

### Fixed

- `Reaper::forget()` documentation example was unsetting the wrong variable (`$b` instead of `$a`), so the doctest wasn't actually verifying that forgetting prevents the callback from firing.

### Changed

- `composer.json` now declares `"php": "^8.1"` (readonly properties + constructor promotion require it).
- CI test matrix now includes PHP 8.5.

### Added

- `CHANGELOG.md` (this file).
- README sections for detaching callbacks and registering multiple callbacks.
