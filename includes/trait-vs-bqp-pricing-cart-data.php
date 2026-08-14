<?php

defined( 'ABSPATH' ) || exit;

trait VS_BQP_Pricing_Cart_Data {
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
