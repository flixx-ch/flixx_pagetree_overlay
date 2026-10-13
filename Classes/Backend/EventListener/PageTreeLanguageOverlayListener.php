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

use FLIXX\FlixxPagetreeOverlay\Service\PageTreeLanguageService;
use TYPO3\CMS\Backend\Tree\Repository\AfterRawPageRowPreparedEvent;
use TYPO3\CMS\Core\Attribute\AsEventListener;
use TYPO3\CMS\Core\Database\Connection;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Database\Query\Restriction\WorkspaceRestriction;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * Event listener that overlays page tree titles with their translations
 * based on the currently selected backend language (stored in session).
 */
#[AsEventListener(
    identifier: 'flixx-pagetree-overlay/overlay-titles'
)]
final readonly class PageTreeLanguageOverlayListener
{
    public function __construct(
        private ConnectionPool $connectionPool,
        private PageTreeLanguageService $pageTreeLanguageService,
    ) {}

    /**
     * Modifies the page tree titles to reflect the selected backend language.
     *
     * When a backend language (navTreeLanguage) is selected by the user, this method:
     * - Checks if the current page is in the default language (sys_language_uid = 0).
     * - Queries for a translated title of the page based on the selected language UID.
     * - Updates the page title in the page tree, if a translation exists.
     *
     * @param AfterRawPageRowPreparedEvent $event Event containing page data after initial processing.
     */
    public function __invoke(AfterRawPageRowPreparedEvent $event): void
    {
        // Get currently selected language UID (session data or User TSconfig)
        $langUid = $this->pageTreeLanguageService->getSelectedLanguage();

        // Proceed only if a language other than default is selected
        if ($langUid <= 0) {
            return;
        }

        // Retrieve the current raw page record, skip the virtual root node (uid 0)
        $rawPage = $event->getRawPage();
        $pageId = (int)($rawPage['uid'] ?? 0);
        if ($pageId === 0 || (int)($rawPage['sys_language_uid'] ?? 0) !== 0) {
            return;
        }

        // Build and execute the query to fetch the translated page title
        $qb = $this->connectionPool->getQueryBuilderForTable('pages');
        $qb->getRestrictions()->add(
            GeneralUtility::makeInstance(WorkspaceRestriction::class, $event->getWorkspaceId())
        );
        $translatedTitle = $qb
            ->select('title')
            ->from('pages')
            ->where(
                $qb->expr()->eq('sys_language_uid', $qb->createNamedParameter($langUid, Connection::PARAM_INT)),
                $qb->expr()->eq('l10n_parent', $qb->createNamedParameter($pageId, Connection::PARAM_INT)),
            )
            ->setMaxResults(1)
            ->executeQuery()
            ->fetchOne();

        // If translation exists, update the page title in the page tree
        if ($translatedTitle !== false) {
            $rawPage['title'] = 'L' . $langUid . '] ' . $translatedTitle;
            $event->setRawPage($rawPage);
        }
    }
}
