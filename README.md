# QHTA Theme Extras

Presentation / theme-layer plugin for qhta.com.au. Absorbs the sitewide display
concerns previously handled by Astra Pro.

## Scope

**Belongs here:** Astra hook injections replacing Custom Layouts, mega menu,
global CSS tokens, sitewide display tweaks.

**Does not belong here:** anything with business logic. Conference domain logic
lives in the conference program plugin.

**Test:** "Would this survive the conference ending?" Yes -> here. No -> conference plugin.

## Structure

```
qhta-theme-extras/
  qhta-theme-extras.php   Bootstrap, enqueues
  css/theme-extras.css    Sitewide styles, sectioned and labelled
  scripts/build-zip.sh    Packages the deploy zip
  README.md
  CHANGELOG.md
```

## Install

```bash
./scripts/build-zip.sh
```

Writes `qhta-theme-extras-X.Y.Z.zip` into the plugin root. Upload via Plugins ->
Add New -> Upload Plugin, activate.

Bump `Version` in the header AND `QHTA_TX_VERSION` on every CSS change so the
cache-buster fires — the build script refuses to run if the two disagree.
Hostinger caches aggressively; purge after deploy.

## Notes

- Stylesheet declares `astra-theme-css` as a dependency, so rules load after
  Astra and win on equal specificity without `!important`.
- The same stylesheet is loaded into the block editor canvas, so the editor
  preview matches the front end.
