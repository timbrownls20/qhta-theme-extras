# Changelog

## 1.0.3 — 30 July 2026

### Fixed
- Floated-media gutter did nothing on Spectra/UAGB image blocks. Spectra emits
  per-block CSS keyed to a generated class (`.uagb-block-<hash>`) that zeroes the
  margins at specificity 0,2,0 — the same weight as `.entry-content .alignright`
  — and prints it inline in `wp_head`, after our `<link>`. At equal specificity
  the later rule wins, so `float` applied but `margin` resolved to `0px` on all
  four sides. Section 2 selectors now reach 0,3,0 via a `:is()` naming the
  element that carries the align class, which puts them out of reach of load
  order without `!important`.

### Changed
- Section 2 now explicitly covers the three markup shapes that carry an align
  class: `figure.wp-block-image` (core), `div.wp-block-uagb-image` (Spectra), and
  a bare `img` (classic editor).

## 1.0.2 — 30 July 2026

### Fixed
- Floated-media rules did nothing in the block editor even after 1.0.1 got the
  stylesheet into the canvas. The canvas has no `.entry-content` element — its
  wrapper is `.editor-styles-wrapper` — so every selector in section 2 matched
  nothing there. Each selector is now doubled for the editor wrapper.
  (`add_editor_style()` auto-prefixes selectors with `.editor-styles-wrapper`;
  `enqueue_block_assets` does not, so the scoping has to be written out.)

### Notes
- Spectra/UAGB image blocks carry `alignleft`/`alignright` on the outer
  `div.wp-block-uagb-image`, not on a `figure` or the `img`. Section 2 targets
  whichever element holds the class, so it covers both core and Spectra blocks.
  Inspect that outer div, not the inner `img` — the image's `margin: 0` comes
  from Spectra's own `__figure img` rule and is expected.

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
