<?php

$config = \TYPO3\CodingStandards\CsFixerConfig::create();
$config->getFinder()->in(__DIR__)->exclude(['public', 'vendor']);
return $config;
