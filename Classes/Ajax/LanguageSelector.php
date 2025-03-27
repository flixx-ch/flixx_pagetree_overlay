<?php
/*
 * Copyright (c) 2025 - flixx.ch
 *
 * Digital- & TYPO3 Agency
 *
 * hello@flixx.ch | www.flixx.ch
 */

declare(strict_types=1);

namespace FLIXX\FlixxPagetreeOverlay\Ajax;

use Psr\Http\Message\ServerRequestInterface;
use TYPO3\CMS\Core\Http\JsonResponse;
use TYPO3\CMS\Core\Site\SiteFinder;
use TYPO3\CMS\Core\Utility\GeneralUtility;

class LanguageSelector
{
    /**
     * Handles AJAX request to set the backend user's language selection into session.
     *
     * @param ServerRequestInterface $request HTTP request containing the language selection in JSON format.
     * @return JsonResponse Response indicating success and the language set.
     */
    public function setLanguage(ServerRequestInterface $request): JsonResponse
    {
        $parsedJson = json_decode($request->getBody()->getContents(), true);
        $language = (int)($parsedJson['language'] ?? 0);
        $GLOBALS['BE_USER']->setAndSaveSessionData('navTreeLanguage', $language);

        return new JsonResponse(['success' => true, 'languageSet' => $language]);
    }

    /**
     * Retrieves the currently selected language, considering user TSconfig and session data.
     *
     * Example User TSconfig:
     * plugin.tx_flixxpagetreeoverlay.defaultNavTreeLanguage = 2
     *
     * @param ServerRequestInterface $request The incoming HTTP request.
     * @return JsonResponse Response containing the currently active language ID.
     */
    public function getLanguage(ServerRequestInterface $request): JsonResponse
    {
        // Default language if nothing is set
        $language = 0;

        // Retrieve language setting from User TSconfig (if configured)
        $userTsConfig = $GLOBALS['BE_USER']->getTSConfig();
        if (isset($userTsConfig['plugin.']['tx_flixxpagetreeoverlay.']['defaultNavTreeLanguage'])) {
            $language = (int)$userTsConfig['plugin.']['tx_flixxpagetreeoverlay.']['defaultNavTreeLanguage'];
        }

        // Check if language is explicitly set in backend user session (overrides TSconfig)
        $sessionLanguage = $GLOBALS['BE_USER']->getSessionData('navTreeLanguage');
        if (isset($sessionLanguage)) {
            $language = (int)$sessionLanguage;
        }

        return new JsonResponse(['language' => $language]);
    }

    /**
     * Retrieves available languages from the TYPO3 site configuration (config.yaml).
     *
     * @param ServerRequestInterface $request The incoming HTTP request.
     * @return JsonResponse Response containing an array of available languages with their IDs and titles.
     */
    public function getAvailableLanguages(ServerRequestInterface $request): JsonResponse
    {
        $siteFinder = GeneralUtility::makeInstance(SiteFinder::class);
        $languages = [];

        // Retrieve all sites configured in TYPO3
        $sites = $siteFinder->getAllSites();

        // Iterate over languages from the first site (adjust for multi-site setups if needed)
        foreach ($sites as $site) {
            foreach ($site->getLanguages() as $language) {
                $languages[] = [
                    'uid' => $language->getLanguageId(),
                    'title' => $language->getTitle()
                ];
            }
            break; // For simplicity, only first site's languages are used
        }

        return new JsonResponse(['languages' => $languages]);
    }
}
