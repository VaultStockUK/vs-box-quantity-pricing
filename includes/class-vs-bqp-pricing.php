<?php

defined( 'ABSPATH' ) || exit;

class VS_BQP_Pricing {
    use VS_BQP_Pricing_Cart_Data;
    use VS_BQP_Pricing_Calculation;
    use VS_BQP_Pricing_Order_Meta;

    const CART_UNIT_PRICE_KEY = '_vs_bqp_unit_price';
    const CART_UNITS_KEY = '_vs_bqp_units_per_box';

    private $product_data;

    public function __construct( VS_BQP_Product_Data $product_data ) {
        $this->product_data = $product_data;
    }

    public function init() {
        add_action( 'woocommerce_before_calculate_totals', array( $this, 'apply_box_prices' ), 20 );
        add_filter( 'woocommerce_add_cart_item_data', array( $this, 'capture_cart_pricing_data' ), 10, 4 );
        add_filter( 'woocommerce_get_cart_item_from_session', array( $this, 'restore_cart_pricing_data' ), 10, 3 );
        add_action( 'woocommerce_checkout_create_order_line_item', array( $this, 'add_order_item_metadata' ), 10, 4 );
    }
}
