# Changelog

All notable changes to VS Box Quantity Pricing will be documented in this file.

The format is based on Keep a Changelog and the project uses semantic versioning.

## [Unreleased]

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
