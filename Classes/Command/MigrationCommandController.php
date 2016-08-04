<?php
namespace CMSExperts\Unlocalizedcrop\Command;

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

use TYPO3\CMS\Core\Database\DatabaseConnection;
use TYPO3\CMS\Extbase\Mvc\Controller\CommandController;

/**
 * A Command Controller which provides a migration for existing sys_file_reference values with crops
 */
class MigrationCommandController extends CommandController
{

    /**
     * Migrates existing sys_file_reference records
     * with a crop parameter to distribute the cropping settings to all translations
     */
    public function migrateCommand()
    {
        // Fetch all original records (no translations)
        $originalRecordsWithCroppingInformation = $this->getDatabaseConnection()->exec_SELECTgetRows(
            'uid, crop',
            'sys_file_reference',
            'crop != "" AND l10n_parent=0'
        );

        $this->outputLine('Found ' . count($originalRecordsWithCroppingInformation) . ' records with crop information');

        // Loop over all references and update their translations
        foreach ($originalRecordsWithCroppingInformation as $record) {
            $this->getDatabaseConnection()->exec_UPDATEquery(
                'sys_file_reference',
                'l10n_parent=' . (int)$record['uid'],
                ['crop' => $record['crop']]
            );
            $this->outputLine('Finished migrating translations of sys_file_reference:' . $record['uid']);
        }

        $this->outputLine('All done');
    }

    /**
     * Fetches the current database connection
     *
     * @return DatabaseConnection
     */
    protected function getDatabaseConnection()
    {
        return $GLOBALS['TYPO3_DB'];
    }
}
