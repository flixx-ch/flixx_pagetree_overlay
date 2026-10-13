/*
 * Copyright (c) 2025 - flixx.ch
 *
 * Digital- & TYPO3-Agency
 *
 * hello@flixx.ch | www.flixx.ch
 */

import AjaxRequest from '@typo3/core/ajax/ajax-request.js';
import DocumentService from '@typo3/core/document-service.js';

const navigationSelector = 'typo3-backend-content-navigation[identifier="backend"] > [slot="navigation"]';
const pageTreeSelector = 'typo3-backend-navigation-component-pagetree';
const selectId = 'pageTreeLanguageSelect';

/**
 * Creates the language selection dropdown, styled like the page tree toolbar.
 */
function createLanguageSelect() {
    const wrapper = document.createElement('div');
    wrapper.style.padding = 'var(--tree-toolbar-padding)';
    wrapper.style.backgroundColor = 'var(--tree-toolbar-bg)';
    wrapper.style.borderBottom = 'var(--tree-toolbar-border-width) solid var(--tree-toolbar-border-color)';

    const select = document.createElement('select');
    select.id = selectId;
    select.className = 'form-select form-select-sm';
    select.setAttribute('aria-label', 'Page tree language');
    wrapper.append(select);

    // Fetch available languages and the user's currently selected language
    Promise.all([
        new AjaxRequest(TYPO3.settings.ajaxUrls['flixx_pagetree_overlay_getAvailableLanguages']).get({ cache: 'no-cache' }).then(response => response.resolve()),
        new AjaxRequest(TYPO3.settings.ajaxUrls['flixx_pagetree_overlay_getLanguage']).get({ cache: 'no-cache' }).then(response => response.resolve()),
    ]).then(([availableData, languageData]) => {
        // Populate the dropdown with available languages retrieved from TYPO3
        availableData.languages.forEach(lang => {
            select.append(new Option('L' + lang.uid + '] ' + lang.title, lang.uid));
        });
        // Set the current language as the selected option in the dropdown
        select.value = languageData.language.toString();
    });

    // Store the selected language and refresh the page tree upon selection
    select.addEventListener('change', () => {
        new AjaxRequest(TYPO3.settings.ajaxUrls['flixx_pagetree_overlay_setLanguage'])
            .post({ language: select.value }, { headers: { 'Content-Type': 'application/json' } })
            .then(() => document.dispatchEvent(new CustomEvent('typo3:pagetree:refresh')));
    });

    return wrapper;
}

/**
 * Prepends the dropdown to the page tree component, so it is only visible together with the page tree.
 * Returns true once the dropdown is in place.
 */
function injectLanguageSelect(navigation) {
    if (document.getElementById(selectId) !== null) {
        return true;
    }
    const pageTree = navigation.querySelector(pageTreeSelector);
    if (pageTree === null) {
        return false;
    }
    pageTree.prepend(createLanguageSelect());
    return true;
}

DocumentService.ready().then(() => {
    const navigation = document.querySelector(navigationSelector);
    if (navigation === null || injectLanguageSelect(navigation)) {
        return;
    }
    // The page tree component is created lazily when a module using it is opened
    const observer = new MutationObserver(() => {
        if (injectLanguageSelect(navigation)) {
            observer.disconnect();
        }
    });
    observer.observe(navigation, { childList: true });
});
