<?php
$EM_CONF[$_EXTKEY] = [
    'title' => 'Disable cropping for localized sys_file_reference records',
    'description' => 'Cropping of localized records are automatically taken from the original language.',
    'category' => 'be',
    'state' => 'stable',
    'clearCacheOnLoad' => 0,
    'author' => 'Benni Mack',
    'author_email' => 'typo3@b13.com',
    'author_company' => 'b13 GmbH',
    'version' => '2.0.0',
    'constraints' => [
        'depends' => [
            'typo3' => '8.7.0-10.4.99',
        ]
    ],
];
