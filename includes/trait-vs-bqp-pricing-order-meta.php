<?php

defined( 'ABSPATH' ) || exit;

trait VS_BQP_Pricing_Order_Meta {
    public function add_order_item_metadata( $item, $cart_item_key, $values, $order ) {
        if ( empty( $values[ self::CART_UNITS_KEY ] ) || absint( $values[ self::CART_UNITS_KEY ] ) <= 1 ) {
            return;
        }
        $units = absint( $values[ self::CART_UNITS_KEY ] );
        $boxes = isset( $values['quantity'] ) ? absint( $values['quantity'] ) : 0;
        $item->add_meta_data( __( 'Units per box', 'vs-box-quantity-pricing' ), $units, true );
        $item->add_meta_data( __( 'Total units', 'vs-box-quantity-pricing' ), $units * $boxes, true );
    }
}
