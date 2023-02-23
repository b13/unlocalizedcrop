<?php

defined('TYPO3_MODE') or defined('TYPO3') or die();

// Register a DataHandler hook to always set the crop value for all children when updating a parent
$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['t3lib/class.t3lib_tcemain.php']['processDatamapClass']['unlocalizedcrop'] = \B13\Unlocalizedcrop\Hooks\DataHandlerCropModifier::class;
