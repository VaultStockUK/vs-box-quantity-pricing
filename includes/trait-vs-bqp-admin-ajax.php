<?php

defined( 'ABSPATH' ) || exit;

trait VS_BQP_Admin_Ajax {
    public function ajax_bulk_set_units_per_box() {
        check_ajax_referer( 'vs_bqp_bulk_units', 'nonce' );

        $product_id = isset( $_POST['product_id'] ) ? absint( $_POST['product_id'] ) : 0;
        if ( ! $product_id || ! current_user_can( 'edit_post', $product_id ) ) {
            wp_send_json_error( array( 'message' => __( 'You do not have permission to edit this product.', 'vs-box-quantity-pricing' ) ), 403 );
        }

        $product = wc_get_product( $product_id );
        if ( ! $product instanceof WC_Product_Variable ) {
            wp_send_json_error( array( 'message' => __( 'This bulk action is only available for variable products.', 'vs-box-quantity-pricing' ) ), 400 );
        }

        $raw_value = isset( $_POST['value'] ) ? sanitize_text_field( wp_unslash( $_POST['value'] ) ) : '';
        $this->apply_bulk_units_value( $product, $raw_value );
    }
}
