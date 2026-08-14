<?php

defined( 'ABSPATH' ) || exit;

trait VS_BQP_Admin_Bulk_Update {
    private function apply_bulk_units_value( $product, $raw_value ) {
        if ( '' !== $raw_value && ( ! ctype_digit( (string) $raw_value ) || absint( $raw_value ) < 1 ) ) {
            wp_send_json_error( array( 'message' => __( 'Units Per Box must be a whole number of 1 or greater.', 'vs-box-quantity-pricing' ) ), 400 );
        }

        $value   = $this->sanitize_units_per_box( $raw_value );
        $updated = 0;

        foreach ( $product->get_children() as $variation_id ) {
            $variation = wc_get_product( $variation_id );
            if ( ! $variation instanceof WC_Product_Variation ) {
                continue;
            }

            if ( null === $value ) {
                $variation->delete_meta_data( self::META_KEY );
            } else {
                $variation->update_meta_data( self::META_KEY, $value );
            }

            $variation->save_meta_data();
            ++$updated;
        }

        wc_delete_product_transients( $product->get_id() );

        if ( null === $value ) {
            /* translators: %d: number of product variations updated. */
            $message = sprintf( __( '%d variations now use the parent box setting.', 'vs-box-quantity-pricing' ), $updated );
        } else {
            /* translators: 1: number of product variations updated, 2: units per box value. */
            $message = sprintf( __( '%1$d variations updated to %2$d units per box.', 'vs-box-quantity-pricing' ), $updated, $value );
        }

        wp_send_json_success( array( 'updated' => $updated, 'message' => $message ) );
    }
}
