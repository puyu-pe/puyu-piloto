<?php

use Symplify\EasyCodingStandard\Config\ECSConfig;
use Symplify\EasyCodingStandard\ValueObject\Set\SetList;

return static function (ECSConfig $ecsConfig): void {
    // Allow to ECS run in X parallel threads where X is number of your threads.
    // E.g. with laptop with AMD Ryzen 4750U it is 16.
    $ecsConfig->parallel();

    //A. Full sets
    $ecsConfig->sets([SetList::PSR_12]);

    // B. Standalone rule
    // $ecsConfig->rule(ArraySyntaxFixer::class);

    // alternative to CLI arguments, easier to maintain and extend
    $ecsConfig->paths([
        __DIR__ . '/src',
    ]);

    // bear in mind that this will override SetList skips if one was previously imported
    // this is result of design decision in symfony https://github.com/symfony/symfony/issues/26713
    $ecsConfig->skip([
        __DIR__ . '/src/Migrations',
        __DIR__ . '/src/security',
        __DIR__ . '/tests'
    ]);
};