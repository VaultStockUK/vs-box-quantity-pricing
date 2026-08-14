<?php

defined( 'ABSPATH' ) || exit;

class VS_BQP_Pricing {
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

    public function capture_cart_pricing_data( $cart_item_data, $product_id, $variation_id, $quantity ) {
        $product = wc_get_product( $variation_id ? $variation_id : $product_id );
        if ( ! $product ) {
            return $cart_item_data;
        }

        $units = $this->product_data->get_units_per_box( $product );
        if ( $units <= 1 ) {
            return $cart_item_data;
        }

        $cart_item_data[ self::CART_UNIT_PRICE_KEY ] = (float) $product->get_price( 'edit' );
        $cart_item_data[ self::CART_UNITS_KEY ] = $units;
        return $cart_item_data;
    }

    public function restore_cart_pricing_data( $cart_item, $values, $key ) {
        if ( isset( $values[ self::CART_UNIT_PRICE_KEY ], $values[ self::CART_UNITS_KEY ] ) ) {
            $cart_item[ self::CART_UNIT_PRICE_KEY ] = (float) $values[ self::CART_UNIT_PRICE_KEY ];
            $cart_item[ self::CART_UNITS_KEY ] = max( 1, absint( $values[ self::CART_UNITS_KEY ] ) );
        }
        return $cart_item;
    }
}
