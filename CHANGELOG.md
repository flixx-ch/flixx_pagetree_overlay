# Changelog

All notable changes to this extension are documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.1.0/),
and this extension adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [2.0.2] - 2026-10-13

### Fixed

- No error anymore when the page tree is loaded without a backend user, e.g. by another extension in frontend or CLI context.

### Changed

- The LICENSE file now contains the GPL-2.0 license text, matching the declared license GPL-2.0-or-later.

## [2.0.1] - 2026-10-13

### Breaking

- Requires TYPO3 14.3 LTS. TYPO3 13.4 is supported by the 1.x versions (branch `1.x`).

### Added

- The page tree refreshes in place after switching the language, without reloading the whole backend.

### Changed

- The language dropdown is rendered inside the TYPO3 14 page tree and is only shown together with the page tree.
- The JavaScript module no longer depends on jQuery.
- The JavaScript module is loaded via `BeforeBackendPageRenderEvent`.
- Extension title and version are maintained in `composer.json` (TYPO3 14.2 deprecated `ext_emconf.php`).

### Fixed

- The default language from User TSconfig (`plugin.tx_flixxpagetreeoverlay.defaultNavTreeLanguage`) is now applied to the page tree, not only to the dropdown.
- Translations that only exist as workspace versions no longer show up in the page tree of the live workspace.

## 2.0.0 - 2026-10-13 [YANKED]

- Withdrawn and replaced by 2.0.1 with identical code.

## [1.0.3] - 2026-10-13

### Fixed

- No error anymore when the page tree is loaded without a backend user, e.g. by another extension in frontend or CLI context.

### Changed

- The LICENSE file now contains the GPL-2.0 license text, matching the declared license GPL-2.0-or-later.

## [1.0.2] - 2026-10-13

### Fixed

- The default language from User TSconfig (`plugin.tx_flixxpagetreeoverlay.defaultNavTreeLanguage`) is now applied to the page tree, not only to the dropdown.

## 1.0.1 - 2026-10-13 [YANKED]

- Withdrawn and replaced by 1.0.2 with identical code.

## [1.0.0] - 2025-03-27

- Initial release for TYPO3 13.4.

[2.0.2]: https://github.com/flixx-ch/flixx_pagetree_overlay/compare/2.0.1...2.0.2
[2.0.1]: https://github.com/flixx-ch/flixx_pagetree_overlay/compare/1.0.0...2.0.1
[1.0.3]: https://github.com/flixx-ch/flixx_pagetree_overlay/compare/1.0.2...1.0.3
[1.0.2]: https://github.com/flixx-ch/flixx_pagetree_overlay/compare/1.0.0...1.0.2
[1.0.0]: https://github.com/flixx-ch/flixx_pagetree_overlay/releases/tag/1.0.0
