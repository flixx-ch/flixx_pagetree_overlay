<?php
/*
 * Copyright (c) 2025 - flixx.ch
 *
 * Digital- & TYPO3-Agency
 *
 * hello@flixx.ch | www.flixx.ch
 */

return [
    'flixx_pagetree_overlay_setLanguage' => [
        'path' => '/flixx/pagetree-overlay/set-language',
        'methods' => ['POST'],
        'target' => \FLIXX\FlixxPagetreeOverlay\Ajax\LanguageSelector::class . '::setLanguage'
    ],
    'flixx_pagetree_overlay_getLanguage' => [
        'path' => '/flixx/pagetree-overlay/get-language',
        'methods' => ['GET'],
        'target' => \FLIXX\FlixxPagetreeOverlay\Ajax\LanguageSelector::class . '::getLanguage'
    ],
    'flixx_pagetree_overlay_getAvailableLanguages' => [
        'path' => '/flixx/pagetree-overlay/get-available-language',
        'methods' => ['GET'],
        'target' => \FLIXX\FlixxPagetreeOverlay\Ajax\LanguageSelector::class . '::getAvailableLanguages'
    ],
];
