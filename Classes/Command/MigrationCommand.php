<?php

namespace B13\Unlocalizedcrop\Command;

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

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use TYPO3\CMS\Core\Database\Connection;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * Migrates existing sys_file_reference records
 * with a crop parameter to distribute the cropping settings to all translations.
 *
 * This also deals with deleted records.
 */
class MigrationCommand extends Command
{
    private const TABLE = 'sys_file_reference';

    public function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);
        $connection = $this->getConnection();
        // Fetch all original records (no translations)
        $queryBuilder = $connection->createQueryBuilder();
        $queryBuilder->getRestrictions()->removeAll();
        $originalRecordsWithCroppingInformation = $queryBuilder
            ->select('uid', 'crop')
            ->from(self::TABLE)
            ->where(
                $queryBuilder->expr()->neq('crop', $queryBuilder->createNamedParameter('""')),
                $queryBuilder->expr()->eq('l10n_parent', 0)
            )
            ->execute()
            ->fetchAll();

        $io->writeln('Found ' . count($originalRecordsWithCroppingInformation) . ' records with crop information');

        // Loop over all references and update their translations
        foreach ($originalRecordsWithCroppingInformation as $record) {
            $connection->update(
                self::TABLE,
                ['crop' => $record['crop']],
                ['l10n_parent' => (int)$record['uid']]
            );
            $io->writeln('Finished migrating translations of ' . self::TABLE . ':' . $record['uid']);
        }

        $io->success('All done');
        return 0;
    }

    protected function getConnection(): Connection
    {
        return GeneralUtility::makeInstance(ConnectionPool::class)->getConnectionForTable(self::TABLE);
    }
}
