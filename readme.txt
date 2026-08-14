=== VS Box Quantity Pricing ===
Tags: woocommerce, wholesale, pricing, quantity, boxes
Requires at least: 6.5
Tested up to: 7.0
Stable tag: 0.2.3
Requires PHP: 7.4
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Sell WooCommerce products in fixed box quantities while keeping clear per-unit pricing.

== Description ==

VS Box Quantity Pricing lets WooCommerce stores sell products in complete boxes while keeping the product price entered and displayed as a per-unit rate.

For example, if a product costs £6.00 per unit and contains 36 units per box, customers select a quantity of 1 box and WooCommerce charges £216.00. A quantity of 2 represents 2 boxes, or 72 units, and WooCommerce charges £432.00.

Features include:

* Per-product Units Per Box setting.
* Variable product support with parent defaults and per-variation overrides.
* Quantity selectors that represent boxes rather than individual units.
* Clear per-unit and per-box pricing on product pages.
* Box size and total unit information in the cart and checkout.
* Order line metadata for box size and total units.
* Bulk variation editing for Units Per Box.
* WooCommerce HPOS compatibility.
* Optional integration with VS Labs Hub. The Hub is not required for the plugin to function.

WooCommerce is required.

== Installation ==

1. Install and activate WooCommerce.
2. Install and activate VS Box Quantity Pricing.
3. Edit a WooCommerce product.
4. Enter the product price as the price per individual unit.
5. Enter the number of individual units in the **Units Per Box** field.
6. For variable products, optionally set Units Per Box on individual variations or leave a variation blank to inherit the parent value.

== Frequently Asked Questions ==

= What should I enter as the WooCommerce product price? =

Enter the price of one individual unit. The plugin calculates the effective box price automatically.

= What does the WooCommerce quantity represent? =

For products with a Units Per Box value greater than 1, the quantity represents the number of complete boxes. A quantity of 1 means one box, 2 means two boxes, and so on.

= Does it support variable products? =

Yes. A variable product can provide a default Units Per Box value. Individual variations can inherit the parent value, override it, or use a value of 1 to disable box pricing for that variation.

= Is VS Labs Hub required? =

No. VS Labs Hub integration is optional. VS Box Quantity Pricing remains fully functional as a standalone plugin.

= Does it work with HPOS? =

Yes. The plugin declares compatibility with WooCommerce High-Performance Order Storage.

== Changelog ==

= 0.2.3 =
* Added WordPress.org Plugin Directory metadata and validation support.
* Declared WooCommerce through WordPress's native Requires Plugins header.
* Added the WordPress.org-standard readme.txt.

= 0.2.2 =
* Added a persistent variable-product box-price display that remains visible with themes that replace WooCommerce price markup.
* Improved selected-variation box pricing display.
* Completed optional VS Labs Hub integration.

== Upgrade Notice ==

= 0.2.3 =
WordPress.org release-hardening update. No pricing behaviour changes are required when upgrading from 0.2.2.
