<?php

/** @noinspection PhpFullyQualifiedNameUsageInspection */

declare(strict_types=1);

use Rector\Core\Configuration\Option;
use Rector\Set\ValueObject\SetList;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

return static function (ContainerConfigurator $containerConfigurator): void {
    // get parameters
    $parameters = $containerConfigurator->parameters();

    // Define what rule sets will be applied
    $containerConfigurator->import(SetList::PHP_70);
    $containerConfigurator->import(SetList::PHP_71);
    $containerConfigurator->import(SetList::PHP_72);
    $containerConfigurator->import(SetList::PHP_73);
    $containerConfigurator->import(\Rector\PHPUnit\Set\PHPUnitSetList::PHPUNIT_50);
    $containerConfigurator->import(\Rector\PHPUnit\Set\PHPUnitSetList::PHPUNIT_60);
    $containerConfigurator->import(\Rector\PHPUnit\Set\PHPUnitSetList::PHPUNIT_70);
    $containerConfigurator->import(\Rector\PHPUnit\Set\PHPUnitSetList::PHPUNIT_75);
    $containerConfigurator->import(\Rector\PHPUnit\Set\PHPUnitSetList::PHPUNIT_80);
    $containerConfigurator->import(\Rector\PHPUnit\Set\PHPUnitSetList::PHPUNIT_90);
    $containerConfigurator->import(\Rector\PHPUnit\Set\PHPUnitSetList::PHPUNIT_91);
    $containerConfigurator->import(SetList::TYPE_DECLARATION);
    $containerConfigurator->import(SetList::TYPE_DECLARATION_STRICT);

    // Skip
    $parameters->set(Option::SKIP, [
        \Rector\TypeDeclaration\Rector\ClassMethod\AddArrayReturnDocTypeRector::class,
    ]);

    // get services (needed for register a single rule)
    // $services = $containerConfigurator->services();

    // register a single rule
    // $services->set(\Rector\Php74\Rector\Property\TypedPropertyRector::class);
};
