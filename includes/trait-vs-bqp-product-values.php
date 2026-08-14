<?php

defined( 'ABSPATH' ) || exit;

trait VS_BQP_Product_Values {
    public function get_units_per_box( $product ) {
        if ( is_numeric( $product ) ) $product = wc_get_product( $product );
        if ( ! $product instanceof WC_Product ) return 1;
        $raw = $product->get_meta( self::META_KEY, true );
        if ( '' !== $raw && null !== $raw ) return max( 1, absint( $raw ) );
        if ( $product->is_type( 'variation' ) ) {
            $parent = wc_get_product( $product->get_parent_id() );
            if ( $parent ) return max( 1, absint( $parent->get_meta( self::META_KEY, true ) ) );
        }
        return 1;
    }

    private function sanitize_units_per_box( $value ) {
        if ( '' === $value || null === $value ) return null;
        return max( 1, absint( $value ) );
    }
}
