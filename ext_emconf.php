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
    'version' => '1.0.0',
    'constraints' => [
        'depends' => ['typo3' => '13.4.8-13.99.99'],
    ],
];
