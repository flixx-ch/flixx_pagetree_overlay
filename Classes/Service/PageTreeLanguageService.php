<?php
/*
 * Copyright (c) 2025 - flixx.ch
 *
 * Digital- & TYPO3-Agency
 *
 * hello@flixx.ch | www.flixx.ch
 */

declare(strict_types=1);

namespace FLIXX\FlixxPagetreeOverlay\Service;

use TYPO3\CMS\Core\Authentication\BackendUserAuthentication;

/**
 * Reads and stores the language selected for the page tree of the current backend user.
 */
final readonly class PageTreeLanguageService
{
    private const SESSION_KEY = 'navTreeLanguage';

    /**
     * Returns the selected language: session data first, then User TSconfig, otherwise 0.
     *
     * Example User TSconfig:
     * plugin.tx_flixxpagetreeoverlay.defaultNavTreeLanguage = 2
     */
    public function getSelectedLanguage(): int
    {
        // Without a backend user (page tree loaded in frontend or CLI context) keep the default language
        $backendUser = $this->getBackendUser();
        if ($backendUser === null) {
            return 0;
        }

        // Language explicitly set in backend user session (overrides TSconfig)
        $sessionLanguage = $backendUser->getSessionData(self::SESSION_KEY);
        if ($sessionLanguage !== null) {
            return (int)$sessionLanguage;
        }

        // Fall back to User TSconfig (if configured)
        $userTsConfig = $backendUser->getTSConfig();
        return (int)($userTsConfig['plugin.']['tx_flixxpagetreeoverlay.']['defaultNavTreeLanguage'] ?? 0);
    }

    public function setSelectedLanguage(int $language): void
    {
        $this->getBackendUser()?->setAndSaveSessionData(self::SESSION_KEY, $language);
    }

    private function getBackendUser(): ?BackendUserAuthentication
    {
        $backendUser = $GLOBALS['BE_USER'] ?? null;
        return $backendUser instanceof BackendUserAuthentication ? $backendUser : null;
    }
}
