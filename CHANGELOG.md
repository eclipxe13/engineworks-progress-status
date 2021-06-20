# Changelog

## v2.0.0 UNRELEASED

- Bump PHP version to 7.3.
- README: Fix usage example and rewording.
- LICENCE: Update license year to 2021.

## v1.0.4 2017-02-09 14:14

- Fix composer dependences remove require `slim/php-view`.
- Fix composer dependences remove require-dev `pds/skeleton`.

## v1.0.3 2017-02-09 12:32

- Implement Null Object on `ProgressInterface` as `NullProgress`.

## v1.0.2 2017-02-09  10:50

- Documentation changes.
- php-cs-fixer no_alias_functions is now risky, this changes the configuration file.
- Tell travis to run php-cs-fixer also.
- ProgressByRatio had a bad logic, fix to change based only on current and new status.

## v1.0.1 Initial Release

- Fix docblock in `Status::make`.

## v1.0.0 Initial Release

- Publish library.
