# VS Box Quantity Pricing

VS Box Quantity Pricing is a lightweight WooCommerce extension for products that are priced per individual unit but purchased in complete boxes.

## Example

- WooCommerce product price: **£6.00 per unit**
- Units Per Box: **36**
- Cart quantity `1`: **1 box / 36 units / £216.00**
- Cart quantity `2`: **2 boxes / 72 units / £432.00**
- Cart quantity `3`: **3 boxes / 108 units / £648.00**

WooCommerce's quantity remains the number of boxes (`1`, `2`, `3`), while the plugin changes the cart product price to the price of one box. WooCommerce then applies quantity, tax, coupons and totals normally.

## v0.1.0 scope

- Simple products.
- Variable products.
- Product-level default Units Per Box.
- Per-variation Units Per Box override.
- Empty variation value inherits the parent product setting.
- Variation value `1` explicitly disables box pricing for that variation.
- Per-unit price presentation remains visible.
- Box price, box size and total unit information in the cart/checkout.
- Box context saved to order line items.
- No template overrides or third-party dependencies.
- WooCommerce HPOS compatibility.

## Variable products

Set **Units Per Box** on the parent variable product to create a default. Each variation can then:

- leave the value blank to inherit the parent value;
- enter `1` to disable box pricing for that variation; or
- enter `2` or greater to use a variation-specific box size.

## Pricing model

The transactional price for one cart quantity is:

`unit price × units per box`

WooCommerce then multiplies this by the cart quantity. The implementation retains the original unit price on the cart line so repeated WooCommerce total calculations cannot multiply the box price twice.

## Status

Target initial version: **0.1.0**
