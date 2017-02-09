# eclipxe/engineworks-progress-status - PHP Progress Status Library (using Subject-Observer)

[![Source Code][badge-source]][source]
[![Latest Version][badge-release]][release]
[![Software License][badge-license]][license]
[![Build Status][badge-build]][build]
[![Scrutinizer][badge-quality]][quality]
[![SensioLabsInsight][badge-sensiolabs]][sensiolabs]
[![Coverage Status][badge-coverage]][coverage]
[![Total Downloads][badge-downloads]][downloads]

Use this library to track progress on long tasks. This library uses the SPL clasess for Subject Observer pattern.
The subject is the Progress object, the observer get notified when the status change.

# Instalation

Use composer to install this library `composer require eclipxe/engineworks-progress-status`

# Basic use

```php
<?php namespace EngineWorks\ProgressStatus;

/* @var \SplObserver $observer */

// Create a new progress with the status of 10 total steps and the current message 'Starting...' 
$pg = new Progress(Status::make(10, 'Starting...'), [$observer]);

/* @var \SplObserver $otherObserver */
// add other observer to the progress
$pg->attach($otherObserver);

// This will fire the method update on $observer and $otherObserver with $pg as subject
$pg->increase('Step 1 done');
```

## EngineWorks\ProgressStatus\Status

This is an immutable class that stores:
- start: DateTime object when the complete progress starts
- current: DateTime object to set the current (last updated) time
- total: count of expected tasks
- value: current value of the progress
- message: current (last updated) status message

## EngineWorks\ProgressStatus\ProgressInterface

This is the contract for a progress class. it contains a few methods to be implemented:
- `getStatus`: Retrieve the current status of the progress 
- `increase`: Change the message and add a value to the current status  
- `update`: Change the full status 
- `shouldNotifyChange`: Compare two status to know when should notify the observers 

## EngineWorks\ProgressStatus\Progress

This is a basic implementation of the `ProgressInterface`interface ready to use. It will notify to all the
observer on any change.

You can use this class as a template to set different ways to notify, just override the shouldNotifyChange method
according to your specific needs. 

## EngineWorks\ProgressStatus\ProgressByRatio

This is an specialized progress (extending `Progress` class) that notify only when the radio (value vs total)
is modified, With a ratio of 0.01 it will no update more than 100 times.
If you want to notify every 5% set the ratio to 0.05. 

## Contributing

Contributions are welcome! Please read [CONTRIBUTING][] for details
and don't forget to take a look in the [TODO][] and [CHANGELOG][] files.

## Copyright and License

The EngineWorks\Templates library is copyright © [Carlos C Soto](https://eclipxe.com.mx/)
and licensed for use under the MIT License (MIT). Please see [LICENSE][] for more information.



[contributing]: https://github.com/eclipxe13/engineworks-progress-status/blob/master/CONTRIBUTING.md
[todo]: https://github.com/eclipxe13/engineworks-progress-status/blob/master/TODO.md
[changelog]: https://github.com/eclipxe13/engineworks-progress-status/blob/master/CHANGELOG.md

[source]: https://github.com/eclipxe13/engineworks-progress-status
[release]: https://github.com/eclipxe13/engineworks-progress-status/releases
[license]: https://github.com/eclipxe13/engineworks-progress-status/blob/master/LICENSE
[build]: https://travis-ci.org/eclipxe13/engineworks-progress-status
[quality]: https://scrutinizer-ci.com/g/eclipxe13/engineworks-progress-status/
[sensiolabs]: https://insight.sensiolabs.com/projects/84b34ced-1d35-4531-86dc-4044532540cd
[coverage]: https://scrutinizer-ci.com/g/eclipxe13/engineworks-progress-status/?branch=master
[downloads]: https://packagist.org/packages/eclipxe/engineworks-progress-status

[badge-source]: http://img.shields.io/badge/source-eclipxe13/engineworks--templates-blue.svg?style=flat-square
[badge-release]: https://img.shields.io/github/release/eclipxe13/engineworks-progress-status.svg?style=flat-square
[badge-license]: https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square
[badge-build]: https://img.shields.io/travis/eclipxe13/engineworks-progress-status.svg?style=flat-square
[badge-quality]: https://img.shields.io/scrutinizer/g/eclipxe13/engineworks-progress-status/master.svg?style=flat-square
[badge-sensiolabs]: https://img.shields.io/sensiolabs/i/84b34ced-1d35-4531-86dc-4044532540cd.svg?style=flat-square
[badge-coverage]: https://img.shields.io/scrutinizer/coverage/g/eclipxe13/engineworks-progress-status/master.svg?style=flat-square
[badge-downloads]: https://img.shields.io/packagist/dt/eclipxe/engineworks-progress-status.svg?style=flat-square
