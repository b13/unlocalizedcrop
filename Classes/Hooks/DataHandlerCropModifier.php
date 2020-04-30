<?php
namespace B13\Unlocalizedcrop\Hooks;

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

use TYPO3\CMS\Backend\Utility\BackendUtility;
use TYPO3\CMS\Core\Database\Connection;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\DataHandling\DataHandler;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * Hook for two things
 *
 * When updating a sys_file_reference record that is NOT a translation,
 * the "crop" field is distributed to all translations.
 *
 * When updating a sys_file_reference record that IS a translation,
 * remove the "crop" field so it is still the one from the original language.
 */
class DataHandlerCropModifier
{
    private const TABLE = 'sys_file_reference';

    /**
     * This hook is called before the data is saved to the database
     *
     * @param string $status
     * @param string $table
     * @param mixed $id
     * @param array $fieldArray
     * @param DataHandler $dataHandlerObject
     */
    public function processDatamap_postProcessFieldArray($status, $table, $id, &$fieldArray, $dataHandlerObject)
    {
        if ($table !== self::TABLE) {
            return;
        }

        // a new translation is created, unset the cropping, and use the one from the l10n_parent
        // when a new original language record is there, nothing needs to be done
        if ($status === 'new' && $fieldArray['l10n_parent'] > 0) {
            $fieldArray = $this->getCropValueFromRecord($fieldArray['l10n_parent'], $fieldArray);
        }

        if ($status === 'update') {
            $fullRecord = BackendUtility::getRecord(self::TABLE, $id);
            // It's a translation, use the crop data from the parent
            if ($fullRecord['l10n_parent'] > 0) {
                $fieldArray = $this->getCropValueFromRecord($fieldArray['l10n_parent'], $fieldArray);
                // it's a modification to the original language, distribute the change to all translations as well
                // but no change in the original language needed
            } elseif (isset($fieldArray['crop'])) {
                $this->getConnection()->update(
                    self::TABLE,
                    ['crop' => $fieldArray['crop']],
                    ['l10n_parent' => (int)$id, 'deleted' => 0]
                );
            }
        }
    }

    /**
     * Fetch the record and set the crop value if the record is available
     *
     * @param int $uid the ID of the record
     * @param array $fieldArray the field array to modify
     * @return array the modified field array
     */
    protected function getCropValueFromRecord($uid, $fieldArray)
    {
        $parent = BackendUtility::getRecord(self::TABLE, $uid);
        if (is_array($parent)) {
            $fieldArray['crop'] = $parent['crop'];
        }
        return $fieldArray;
    }

    protected function getConnection(): Connection
    {
        return GeneralUtility::makeInstance(ConnectionPool::class)->getConnectionForTable(self::TABLE);
    }
}
