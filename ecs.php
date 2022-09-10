<?php

use PhpCsFixer\Fixer\ArrayNotation\ArraySyntaxFixer;
use Symplify\EasyCodingStandard\Config\ECSConfig;

return static function (ECSConfig $ecsConfig): void {
//     $ecsConfig->sets([SetList::PSR_12]);
    $ecsConfig->ruleWithConfiguration(ArraySyntaxFixer::class, [
        'syntax' => 'short',
    ]);

    // alternative to CLI arguments, easier to maintain and extend
    $ecsConfig->paths([__DIR__ . '/src', __DIR__ . '/tests']);

    // bear in mind that this will override SetList skips if one was previously imported
    // this is result of design decision in symfony https://github.com/symfony/symfony/issues/26713
    $ecsConfig->skip([
        // skip paths with legacy code
        __DIR__ . '/src/Migrations',
        // __DIR__ . '/src/security',
        __DIR__ . '/tests'
    ]);

    // scan other file extendsions; [default: [php]]
    $ecsConfig->fileExtensions(['php', 'phpt']);

    // configure cache paths & namespace - useful for Gitlab CI caching, where getcwd() produces always different path
    // [default: sys_get_temp_dir() . '/_changed_files_detector_tests']
    $ecsConfig->cacheDirectory('.ecs_cache');

    // [default: \Nette\Utils\Strings::webalize(getcwd())']
    $ecsConfig->cacheNamespace('app');

    // indent and tabs/spaces
    // [default: spaces]
    $ecsConfig->indentation('tab');

    // [default: PHP_EOL]; other options: "\n"
    $ecsConfig->lineEnding("\r\n");
};