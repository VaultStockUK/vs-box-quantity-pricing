<?php

defined( 'ABSPATH' ) || exit;

trait VS_BQP_Pricing_Calculation {
    public function apply_box_prices( $cart ) {
        if ( ! $cart instanceof WC_Cart ) {
            return;
        }
        foreach ( $cart->get_cart() as $key => $item ) {
            if ( empty( $item['data'] ) || ! $item['data'] instanceof WC_Product ) {
                continue;
            }
            $product = $item['data'];
            $units = isset( $item[ self::CART_UNITS_KEY ] ) ? max( 1, absint( $item[ self::CART_UNITS_KEY ] ) ) : $this->product_data->get_units_per_box( $product );
            if ( $units <= 1 ) {
                continue;
            }
        }
    }
}
