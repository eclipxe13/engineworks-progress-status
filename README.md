# eclipxe/engineworks-progress-status - PHP Progress Status Library (using Subject-Observer)

[![Source Code][badge-source]][source]
[![Packagist PHP Version Support][badge-php-version]][php-version]
[![Latest Version][badge-release]][release]
[![Software License][badge-license]][license]
[![Build Status][badge-build]][build]
[![Total Downloads][badge-downloads]][downloads]

Use this library to track progress on long tasks. This library uses the SPL classes for Subject Observer pattern.
The subject is the Progress object, the observers get notified when the status changes.

## Installation

Use composer to install this library `composer require eclipxe/engineworks-progress-status`

## Basic use

```php
<?php declare(strict_types=1); 

// Create a new progress instance with the status of 10 total steps and the current message 'Starting...' 
use EngineWorks\ProgressStatus\Progress;
use EngineWorks\ProgressStatus\Status;

/* @var SplObserver $observer */

$pg = new Progress(Status::make(10, 'Starting...'), [$observer]);

/* @var SplObserver $otherObserver */
// add other observer to the progress
$pg->attach($otherObserver);

// This will fire the method update on $observer and $otherObserver with $pg as subject
$pg->increase('Step 1 done');

$status = $pg->getStatus();
echo sprintf(
    "Step %s of %s completed (%0.2f %%) ETA: %s\n",
    $status->getCurrent(),
    $status->getTotal(),
    $status->getRatio(),
    $status->getEstimatedTimeOfEnd() ? date('c', $status->getEstimatedTimeOfEnd()) : '--stalled--',
);
```

### EngineWorks\ProgressStatus\Status

This is an immutable class that stores:

- `start` - DateTime object when the complete progress starts.
- `current` - DateTime object to set the current (last updated) time.
- `total` - count of expected tasks.
- `value` - current value of the progress.
- `message` - current (last updated) status message.

### EngineWorks\ProgressStatus\ProgressInterface

This is the contract for a progress class. it contains a few methods to be implemented:

- `getStatus` - Retrieve the current status of the progress.
- `increase` - Change the message and add a value to the current status.
- `update` - Change the full status.
- `shouldNotifyChange` - Compare two status to know when should notify the observers.

### EngineWorks\ProgressStatus\Progress

This is a basic implementation of the `ProgressInterface` interface ready to use.
It will notify to all the observer on any change.

You can use this class as a template to set different ways to notify,
just override the `shouldNotifyChange` method according to your specific needs.

### EngineWorks\ProgressStatus\ProgressByRatio

This is a specialized progress (extending `Progress` class) that notify only
when the radio (`value` vs `total`) is modified.
With a ratio of 0.01 it will not update more than 100 times.
If you want to notify every 5%, set the ratio to 0.05.

## PHP Support

This library is compatible with at least the oldest [PHP Supported Version](https://php.net/supported-versions.php)
with **active** support. Please, try to use PHP full potential.

We adhere to [Semantic Versioning](https://semver.org/).
We will not introduce any compatibility backwards change on major versions.

Internal classes (using `@internal` annotation) are not part of this agreement
as they must only exist inside this project. Do not use them in your project.

### Library versions

- Version `1.x` is EOL. It will not receive any updates. It was compatible with PHP from 5.6 to PHP 8.0.

- Version `2.x` is current. It is compatible with PHP 7.3 and higher.

## Contributing

Contributions are welcome! Please read [CONTRIBUTING][] for details
and don't forget to take a look in the [TODO][] and [CHANGELOG][] files.

## Copyright and License

The `eclipxe/engineworks-progress-status` library is copyright © [Carlos C Soto](https://eclipxe.com.mx/)
and licensed for use under the MIT License (MIT). Please see [LICENSE][] for more information.

[contributing]: https://github.com/eclipxe13/engineworks-progress-status/blob/main/CONTRIBUTING.md
[todo]: https://github.com/eclipxe13/engineworks-progress-status/blob/main/TODO.md
[changelog]: https://github.com/eclipxe13/engineworks-progress-status/blob/main/CHANGELOG.md

[source]: https://github.com/eclipxe13/engineworks-progress-status
[php-version]: https://packagist.org/packages/eclipxe/engineworks-progress-status
[release]: https://github.com/eclipxe13/engineworks-progress-status/releases
[license]: https://github.com/eclipxe13/engineworks-progress-status/blob/main/LICENSE
[build]: https://github.com/eclipxe13/engineworks-progress-status/actions/workflows/build.yml?query=branch:main
[downloads]: https://packagist.org/packages/eclipxe/engineworks-progress-status

[badge-source]: https://img.shields.io/badge/source-eclipxe/engineworks--progress--status-blue.svg?style=flat-square
[badge-php-version]: https://img.shields.io/packagist/php-v/eclipxe/engineworks-progress-status?style=flat-square
[badge-release]: https://img.shields.io/github/release/eclipxe13/engineworks-progress-status.svg?style=flat-square
[badge-license]: https://img.shields.io/github/license/eclipxe13/engineworks-progress-status.svg?style=flat-square
[badge-build]: https://img.shields.io/github/actions/workflow/status/eclipxe13/engineworks-progress-status/build.yml?branch=main&style=flat-square
[badge-downloads]: https://img.shields.io/packagist/dt/eclipxe/engineworks-progress-status.svg?style=flat-square
