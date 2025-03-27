<?php
/*
 * Copyright (c) 2025 - flixx.ch
 *
 * Digital- & TYPO3-Agency
 *
 * hello@flixx.ch | www.flixx.ch
 */

declare(strict_types=1);

namespace FLIXX\FlixxPagetreeOverlay\Backend\EventListener;

use Doctrine\DBAL\Exception;
use Doctrine\DBAL\ParameterType;
use TYPO3\CMS\Backend\Tree\Repository\AfterRawPageRowPreparedEvent;
use TYPO3\CMS\Core\Attribute\AsEventListener;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * Event listener that overlays page tree titles with their translations
 * based on the currently selected backend language (stored in session).
 */
#[AsEventListener(
    identifier: 'site-language-tree/overlay-titles'
)]
final class PageTreeLanguageOverlayListener
{
    /**
     * Modifies the page tree titles to reflect the selected backend language.
     *
     * When a backend language (navTreeLanguage) is selected by the user, this method:
     * - Checks if the current page is in the default language (sys_language_uid = 0).
     * - Queries for a translated title of the page based on the selected language UID.
     * - Updates the page title in the page tree, if a translation exists.
     *
     * @param AfterRawPageRowPreparedEvent $event Event containing page data after initial processing.
     * @throws Exception
     */
    public function __invoke(AfterRawPageRowPreparedEvent $event): void
    {
        // Retrieve the current raw page record
        $rawPage = $event->getRawPage();
        $pageId  = (int)$rawPage['uid'];

        // Get currently selected language UID from backend user's session data
        $langUid = (int)$GLOBALS['BE_USER']->getSessionData('navTreeLanguage');

        // Proceed only if a language other than default is selected
        if ($langUid > 0) {
            // Check if the current page record is in default language
            if (($rawPage['sys_language_uid'] ?? 0) === 0) {
                // Establish a database connection to the "pages" table
                $connection = GeneralUtility::makeInstance(ConnectionPool::class)
                    ->getConnectionForTable('pages');

                // Build and execute the query to fetch the translated page title
                $qb = $connection->createQueryBuilder();
                $translation = $qb
                    ->select('title')
                    ->from('pages')
                    ->where(
                        $qb->expr()->eq('sys_language_uid', $langUid),
                        $qb->expr()->eq('l10n_parent', $qb->createNamedParameter($pageId, ParameterType::INTEGER)),
                        $qb->expr()->eq('deleted', 0),
                    )
                    ->setMaxResults(1)
                    ->executeQuery()
                    ->fetchAssociative();

                // If translation exists, update the page title in the page tree
                if ($translation) {
                    $rawPage['title'] = 'L' . $langUid . '] ' . $translation['title'];
                }
            }

            // Set the updated raw page data back into the event object
            $event->setRawPage($rawPage);
        }
    }
}