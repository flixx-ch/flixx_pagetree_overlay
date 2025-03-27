/*
 * Copyright (c) 2025 - flixx.ch
 *
 * Digital- & TYPO3-Agency
 *
 * hello@flixx.ch | www.flixx.ch
 */

import $ from 'jquery';

$(function() {
    // Locate the header element where the language dropdown will be appended
    const header = $('body').find('.scaffold-content-navigation');

    // Exit if the target element does not exist
    if (!header.length) return;

    // Create the language selection dropdown and set default styling and options
    const select = $('<select/>', {
        id: 'pageTreeLanguageSelect',
        class: 'form-select form-select-sm',
        style: 'margin: 10px 52px 10px 18px; max-width: calc(100% - 70px);',
    });

    // Append the select dropdown to the header element in the TYPO3 backend
    header.append(select);

    // Fetch available languages dynamically via AJAX from TYPO3 site settings
    fetch(TYPO3.settings.ajaxUrls['flixx_pagetree_overlay_getAvailableLanguages'])
        .then(response => response.json())
        .then(data => {
            // Populate the dropdown with available languages retrieved from TYPO3
            data.languages.forEach(lang => {
                select.append(new Option('L' + lang.uid + '] ' + lang.title, lang.uid));
            });

            // After populating languages, retrieve the user's currently selected language
            fetch(TYPO3.settings.ajaxUrls['flixx_pagetree_overlay_getLanguage'])
                .then(resp => resp.json())
                .then(langData => {
                    // Set the current language as the selected option in the dropdown
                    select.val(langData.language.toString());
                });
        });

    // Event listener: Store the selected language and reload the page upon selection
    select.on('change', function() {
        fetch(TYPO3.settings.ajaxUrls['flixx_pagetree_overlay_setLanguage'], {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ language: this.value })
        }).then(() => location.reload());
    });
});