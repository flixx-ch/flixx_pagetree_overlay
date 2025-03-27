# flixx_pagetree_overlay

Minimal TYPO3 backend extension to enhance the page tree by displaying translated page titles for each available language in a dropdown selector.

## Features

- Language dropdown menu in the page tree header
- Remembers the selected language using TYPO3 BE user session data
- Optionally falls back to a default language from User TSconfig if no session data exists
- Dynamically loads available languages from site configuration (`config.yaml`)
- No deep integration or backend manipulation – only minor UI enhancements

## Why?

This extension provides a lightweight and minimal way to switch language visibility in the page tree.  
It avoids any complex manipulation of TYPO3 core functionalities and simply adapts the title rendering of pages according to the selected language.  
This ensures maximum compatibility and avoids backend-related issues.

## Installation

Install via Composer:

```bash
composer require flixx/flixx-pagetree-overlay
```

Activate the extension in the TYPO3 Extension Manager.

## Configuration

### User TSconfig

Optionally, set a default language for specific backend users:

```tsconfig
plugin.tx_flixxpagetreeoverlay.defaultNavTreeLanguage = 1
```

This value is overridden if the user selects another language from the dropdown.

## License

GNU GENERAL PUBLIC LICENSE

## Contact

**flixx.ch**  
Digital- & TYPO3 Agency  
[hello@flixx.ch](mailto:hello@flixx.ch)  
[https://www.flixx.ch](https://www.flixx.ch)
