<?php
/*
 * Copyright (c) 2025 - flixx.ch
 *
 * Digital- & TYPO3-Agency
 *
 * hello@flixx.ch | www.flixx.ch
 */

$EM_CONF['flixx_pagetree_overlay'] = [
    'title' => 'FLIXX PageTree Language Overlay with Dropdown',
    'description' => 'TYPO3 backend extension to dynamically switch page tree languages via dropdown with immediate refresh.',
    'category' => 'backend',
    'author' => 'Christoph Kratz',
    'author_email' => 'hello@flixx.ch',
    'author_company' => 'flixx.ch - Digital- & TYPO3 Agentur',
    'state' => 'stable',
    'version' => '2.0.2',
    'constraints' => [
        'depends' => ['typo3' => '14.3.0-14.99.99'],
    ],
];
