# flixx_pagetree_overlay

Minimal TYPO3 backend extension to enhance the page tree by displaying translated page titles for each available language in a dropdown selector.

## Features

- Language dropdown menu at the top of the page tree
- Page tree refreshes immediately after switching the language (no full backend reload)
- Translated pages are shown as `L<language id>] <translated title>`, pages without translation keep their default title
- Remembers the selected language using TYPO3 BE user session data
- Optionally falls back to a default language from User TSconfig if no session data exists
- Dynamically loads available languages from site configuration (`config.yaml`)
- No deep integration or backend manipulation – only minor UI enhancements

## Why?

This extension provides a lightweight and minimal way to switch language visibility in the page tree.  
It avoids any complex manipulation of TYPO3 core functionalities and simply adapts the title rendering of pages according to the selected language.  
This ensures maximum compatibility and avoids backend-related issues.

## Requirements

| Extension version | TYPO3    | PHP  | Branch |
|-------------------|----------|------|--------|
| 2.x               | 14.3 LTS | 8.2+ | `main` |
| 1.x               | 13.4 LTS | 8.2+ | `1.x`  |

Bugfixes for TYPO3 13 are released from the `1.x` branch.

## Installation

Install via Composer:

```bash
composer require flixx/flixx_pagetree_overlay
```

In Composer mode the extension is active right away. In classic mode, activate it in the TYPO3 Extension Manager.

## Configuration

### User TSconfig

Optionally, set a default language for specific backend users:

```tsconfig
plugin.tx_flixxpagetreeoverlay.defaultNavTreeLanguage = 1
```

The default language is used for the dropdown and the page tree as long as the user has not selected a language in the dropdown.  
A selection in the dropdown overrides it for the current login session.

## Known limitations

- Only the languages of the first site configuration are offered in the dropdown.

## Changelog

See [CHANGELOG.md](CHANGELOG.md).

## License

GNU General Public License, version 2 or later (GPL-2.0-or-later)

## Contact

**flixx.ch**  
Digital- & TYPO3 Agency  
[hello@flixx.ch](mailto:hello@flixx.ch)  
[https://www.flixx.ch](https://www.flixx.ch)
