<?php

return Symfony\CS\Config\Config::create()
    ->level(Symfony\CS\FixerInterface::SYMFONY_LEVEL)
    // and extra fixers:
    ->fixers(
        [
            '-psr0',
            '-phpdoc_no_empty_return',
            '-unalign_equals',
            'align_double_arrow',
            'align_equals',
            'multiline_spaces_before_semicolon',
            'ordered_use',
            'strict',
            'strict_param',
        ]
    )
    ->finder(
        Symfony\CS\Finder\DefaultFinder::create()->in([__DIR__ . '/src', __DIR__ . '/tests'])
    )
    ->setUsingCache(true);
