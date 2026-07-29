# Changelog

## 1.0.1 — 30 July 2026

### Fixed
- Block editor stylesheet never loaded. `add_editor_style()` resolves relative
  paths against the theme directory, so `css/theme-extras.css` was looked for
  under Astra and silently skipped. Replaced with a `wp_enqueue_style` on
  `enqueue_block_assets`, which lands inside the iframed editor canvas. Uses its
  own handle with no dependencies, because `astra-theme-css` is not registered in
  the editor context and a missing dependency makes WordPress drop the enqueue.
- Dropped `add_theme_support( 'editor-styles' )` — that is the theme's call to
  make, and Astra already declares it.

## 1.0.0 — 30 July 2026

Initial release. Plugin stood up in response to the first real theme-layer gap
after the Astra Pro cancellation.

### Added
- Plugin bootstrap; front-end and block-editor stylesheet enqueues.
- Design tokens as CSS custom properties (navy, teal, accent, gold gradient).
- Floated-media rules for `.entry-content .alignleft` / `.alignright`:
  horizontal gutter, 0.35em optical top offset, containing-block clearfix,
  and unfloat-and-centre below 768px.
