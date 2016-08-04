<?php
/*
 * This file is part of the TYPO3 CMS project.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * The TYPO3 project - inspiring people to share!
 */

/**
 * This file represents the configuration for Code Sniffing PSR-2-related
 * automatic checks of coding guidelines.
 *
 * Simply run
 *
 *  $ php-cs-fixer fix
 *
 * For more information read:
 * 	 http://www.php-fig.org/psr/psr-2/
 * 	 http://cs.sensiolabs.org
 */

if (PHP_SAPI !== 'cli') {
    die('This script supports command line usage only. Please check your command.');
}
// Define in which folders to search and which folders to exclude
$finder = Symfony\CS\Finder\DefaultFinder::create()
    ->in('.');

// Return a Code Sniffing configuration using
// all sniffers needed for PSR-2
// and additionally:
//  - Remove leading slashes in use clauses.
//  - PHP single-line arrays should not have trailing comma.
//  - Single-line whitespace before closing semicolon are prohibited.
//  - Remove unused use statements in the PHP source code
//  - Ensure Concatenation to have at least one whitespace around
//  - Remove trailing whitespace at the end of blank lines.
return Symfony\CS\Config\Config::create()
    ->level(Symfony\CS\FixerInterface::PSR2_LEVEL)
    ->fixers([
        'remove_leading_slash_use',
        'single_array_no_trailing_comma',
        'spaces_before_semicolon',
        'unused_use',
        'concat_with_spaces',
        'whitespacy_lines',
        'ordered_use',
        'single_quote',
        'duplicate_semicolon',
        'extra_empty_lines',
        'phpdoc_no_package',
        'phpdoc_scalar',
        'no_empty_lines_after_phpdocs'
    ])
    ->finder($finder);
