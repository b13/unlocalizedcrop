<?php
$EM_CONF[$_EXTKEY] = array(
    'title' => 'Disable cropping for localized sys_file_reference records',
    'description' => 'Cropping of localized records are automatically taken from the original language.',
    'category' => 'be',
    'state' => 'stable',
    'clearCacheOnLoad' => 0,
    'author' => 'Benni Mack',
    'author_email' => 'benni@typo3.org',
    'author_company' => '',
    'version' => '1.0.0',
    'constraints' => array(
        'depends' => array(
            'typo3' => '7.6.0-8.9.99',
        )
    ),
);
