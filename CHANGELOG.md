# Changelog

All notable changes to VS Box Quantity Pricing will be documented in this file.

The format is based on Keep a Changelog and the project uses semantic versioning.

## [Unreleased]

## [0.2.2] - 2026-08-14

### Fixed

- Moved the live variation box-price display into a persistent WooCommerce variation-form container so themes cannot wipe it out when they refresh their own price markup.
- Kept the selected variation box size and formatted box price in the variation payload and used those fields as the display source.

## [0.2.0] - 2026-08-14

### Added

- Added optional VS Labs Hub registration so the plugin appears in the shared VS Labs dashboard when the Hub is active.
- Added GitHub Actions packaging so validated release branches produce an installable WordPress ZIP artifact.

### Fixed

- Improved variable-product frontend handling so selected variations refresh box-size and per-box pricing correctly.
- Added theme-independent variation display logic for products where the theme changes the standard WooCommerce price markup.
- Rechecked the custom variation bulk action so Units Per Box can be applied across all variations.

## [0.1.4] - 2026-08-14

### Fixed

- Reworked the variable-product bulk action so **Set units per box** opens a dedicated modal instead of relying on a fragile WooCommerce event hook.
- Added a secured AJAX handler that applies the selected box quantity to every variation on the product, including variations not visible on the current pagination page.
- Added an explicit **Use parent setting** action to clear variation-level overrides cleanly.

## [0.1.0] - 2026-08-14

### Added

- Initial WooCommerce plugin architecture designed and built locally.
- Product-level `Units Per Box` setting using `_vs_units_per_box`.
- Simple product box pricing.
- Variable product support with parent defaults and per-variation overrides.
- Explicit `1` value to disable inherited box pricing for an individual variation.
- Unit-rate price presentation with box-size and box-price context.
- Box-based cart quantity presentation.
- Unit price, box size and total unit cart/checkout metadata.
- Stable cart pricing data to prevent double multiplication during repeated total calculations.
- Order line metadata for units per box and total units.
- WooCommerce HPOS compatibility design.
