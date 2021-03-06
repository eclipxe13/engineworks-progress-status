# Changelog

## v2.0.0 2021-06-24 22:47

Behavior differences with `v1.0.4`:

- Bug fix: `Status::getEstimatedTimeOfEnd()` have incorrect results.
- `Status::getEstimatedTimeOfEnd()` will return null when speed is lower than 1 step per day.
- Class `AbstractSplSubject` has been removed, use `SplSubjectWithObserversTrait` instead.

Additional changes included on this release:

- Bump PHP version to 7.3.
- Upgrade to PHPUnit 9.5.
- README: Improve usage example and rewording.
- README: Add PHP Support section.
- LICENSE: Update license year to 2021.
- CI: Migrate CI from Travis-CI to GitHub Actions
- CI: Uses `phpcs`, `php-cs-fixer`, `phpunit`, `phpstan`, `psalm` and `infection`.
- Internal: Move source files and tests to standard locations.
- Development: Add development tools and composer scripts.

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
