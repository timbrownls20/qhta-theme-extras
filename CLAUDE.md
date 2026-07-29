# CLAUDE.md

Context for Claude Code working in this repo. Read this first.

## What this is

`qhta-theme-extras` — a WordPress plugin holding the **presentation / theme
layer** for qhta.com.au (Queensland History Teachers' Association).

It exists because Astra Pro was cancelled. Everything Astra Pro used to provide
sitewide — Custom Layouts, mega menu, global styling — gets rebuilt here as
plain code. Built **lazily**: a section is only added when a real gap is hit, not
scaffolded up front.

Currently at v1.0.0 with one functional section (floated media rules).

## Scope boundary — enforce this

There are two custom plugins and they must not bleed into each other.

| | Owns |
|---|---|
| **qhta-theme-extras** (this repo) | Presentation only. Astra hook injections, mega menu, global CSS tokens, sitewide display tweaks. |
| **conference program plugin** (separate) | Domain logic. `conference_session` CPT, ACF fields, `[conference_program]` shortcode. |

**Test when unsure:** *"Would this survive the conference ending?"*
Yes → theme-extras. No → conference plugin.

This plugin contains **no business logic**. No CPTs, no shortcodes with domain
meaning, no membership or payment logic. If a task requires any of those, say so
rather than adding them here.

## Environment

- WordPress on **Hostinger** (hPanel). Legacy host Panthur being decommissioned.
- Theme: **Astra** (free — Astra Pro is cancelled, do not write code depending on it).
- Also installed: Elementor Free + Ultimate Addons, Paid Memberships Pro, ACF Free.
- Site: qhta.com.au

## Structure

```
qhta-theme-extras/
  qhta-theme-extras.php   Bootstrap + enqueues. Keep thin.
  css/theme-extras.css    Sitewide styles. Numbered, labelled sections.
  CLAUDE.md               This file.
  README.md               Human-facing overview.
  CHANGELOG.md            Every change, every version.
```

As the plugin grows, add `inc/` for PHP partials required from the bootstrap.
Do not let `qhta-theme-extras.php` become a dumping ground.

## Conventions

- **Prefix everything.** Functions `qhta_tx_`, constants `QHTA_TX_`, CSS custom
  properties `--qhta-`. No unprefixed globals.
- **Escape and guard.** `ABSPATH` check at the top of every PHP file. Escape all
  output. Nonce-check anything that writes.
- **No `!important`.** The stylesheet declares `astra-theme-css` as a dependency
  so it loads after Astra and wins on equal specificity. If a rule needs
  `!important`, the selector is wrong — fix the selector.
- **CSS sections are numbered and labelled** with a comment explaining *why* the
  rule is needed, not what it does. Future maintainers need the reason.
- **Design tokens live in `:root`** in section 1 of the stylesheet. Reference
  them via `var()`; never hard-code a brand hex in a rule.
- **Minimal footprint.** Clean custom code over third-party plugins. No build
  step, no dependencies, no npm. Plain PHP and CSS that a successor can read.

### Design tokens

| Token | Value |
|---|---|
| Navy | `#1d3461` |
| Teal | `#3ecfb2` |
| Accent | `#8a1538` |
| Gold gradient | `linear-gradient(to right, #8b6914, #c9971a, #8b6914)` |

## Version bumping — do not skip

On **every** change to the CSS or PHP, bump the version in **both** places:

1. `Version:` in the plugin header comment
2. `QHTA_TX_VERSION` constant

They must match. The constant is the `wp_enqueue_style` cache-buster; if it
doesn't change, Hostinger serves the stale file and the change appears not to
have worked. This has burned us before.

Then add a `CHANGELOG.md` entry under the new version with Added / Changed /
Fixed subheadings and the date.

## Deploy

No CI. Manual, and deliberately so.

```bash
# from the parent directory
zip -r qhta-theme-extras-X.Y.Z.zip qhta-theme-extras -x '*.DS_Store' '*.git*'
```

Then: wp-admin → Plugins → Add New → Upload Plugin → activate/replace.
Then: hPanel → Websites → qhta.com.au → Advanced → Cache Manager → **Purge All**.
Then: hard-reload the affected page.

**Verification standard for this project is programmatic, not visual.** Confirm
the stylesheet is actually in the page source with the expected `?ver=`, loading
after Astra's — don't sign off on "it looks right".

## Known gotchas

- **Hostinger object cache** holds WP transients past their TTL. If this plugin
  ever needs cached data, use `wp_options` with `autoload=no` plus WP-Cron for
  scheduled refresh. Never transients.
- **`astra-theme-css` handle.** The enqueue depends on it. If Astra's handle
  differs on this install, WordPress silently drops the enqueue instead of
  erroring — the stylesheet just won't appear in source. First thing to check
  when styles don't apply.
- **WordPress strips empty `<a>` tags** on save before JS can populate them.
  Anchors need placeholder text to survive.
- **The `claudeus-wp-mcp` MCP server** reaches posts/pages/media/theme and
  WooCommerce tables only. Not PMPro tables (`wp_pmpro_*`). It has no
  plugin-upload capability — deploys are manual. It is also intermittently down.

## Working style

Direct and terse. Proceed decisively; don't open with clarifying questions.
Deliver the output and stop — no padding, no follow-up offers.

For multi-step work, give a time-boxed plan with milestones and an explicit
"done =" criterion per milestone, not an open-ended task list.
