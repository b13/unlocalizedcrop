<?php
defined('TYPO3_MODE') or die();

// only show the cropping field for records that have no localization parent
$GLOBALS['TCA']['sys_file_reference']['columns']['crop']['l10n_mode'] = 'exclude';
