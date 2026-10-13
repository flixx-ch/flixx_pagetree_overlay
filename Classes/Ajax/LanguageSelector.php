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

use FLIXX\FlixxPagetreeOverlay\Service\PageTreeLanguageService;
use Psr\Http\Message\ServerRequestInterface;
use TYPO3\CMS\Backend\Attribute\AsController;
use TYPO3\CMS\Core\Http\JsonResponse;
use TYPO3\CMS\Core\Site\SiteFinder;

#[AsController]
final readonly class LanguageSelector
{
    public function __construct(
        private SiteFinder $siteFinder,
        private PageTreeLanguageService $pageTreeLanguageService,
    ) {}

    /**
     * Handles AJAX request to set the backend user's language selection into session.
     *
     * @param ServerRequestInterface $request HTTP request containing the language selection in JSON format.
     * @return JsonResponse Response indicating success and the language set.
     */
    public function setLanguage(ServerRequestInterface $request): JsonResponse
    {
        $parsedJson = json_decode((string)$request->getBody(), true);
        $language = (int)($parsedJson['language'] ?? 0);
        $this->pageTreeLanguageService->setSelectedLanguage($language);

        return new JsonResponse(['success' => true, 'languageSet' => $language]);
    }

    /**
     * Retrieves the currently selected language, considering user TSconfig and session data.
     *
     * @param ServerRequestInterface $request The incoming HTTP request.
     * @return JsonResponse Response containing the currently active language ID.
     */
    public function getLanguage(ServerRequestInterface $request): JsonResponse
    {
        return new JsonResponse(['language' => $this->pageTreeLanguageService->getSelectedLanguage()]);
    }

    /**
     * Retrieves available languages from the TYPO3 site configuration (config.yaml).
     *
     * @param ServerRequestInterface $request The incoming HTTP request.
     * @return JsonResponse Response containing an array of available languages with their IDs and titles.
     */
    public function getAvailableLanguages(ServerRequestInterface $request): JsonResponse
    {
        $languages = [];

        // Iterate over languages from the first site (adjust for multi-site setups if needed)
        foreach ($this->siteFinder->getAllSites() as $site) {
            foreach ($site->getLanguages() as $language) {
                $languages[] = [
                    'uid' => $language->getLanguageId(),
                    'title' => $language->getTitle(),
                ];
            }
            break; // For simplicity, only first site's languages are used
        }

        return new JsonResponse(['languages' => $languages]);
    }
}
