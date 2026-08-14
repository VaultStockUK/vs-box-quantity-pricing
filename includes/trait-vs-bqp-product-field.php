<?php

defined( 'ABSPATH' ) || exit;

trait VS_BQP_Product_Field {
    public function render_product_field() {
        woocommerce_wp_text_input(
            array(
                'id'                => self::META_KEY,
                'label'             => __( 'Units Per Box', 'vs-box-quantity-pricing' ),
                'description'       => __( 'Number of individual units contained in one purchasable box. The WooCommerce product price should be entered as the price per individual unit. For variable products, this is the default inherited by variations unless overridden.', 'vs-box-quantity-pricing' ),
                'desc_tip'          => true,
                'type'              => 'number',
                'custom_attributes' => array( 'min' => '1', 'step' => '1' ),
            )
        );
    }

    public function save_product_field( $product ) {
        if (
            ! isset( $_POST['woocommerce_meta_nonce'] ) ||
            ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['woocommerce_meta_nonce'] ) ), 'woocommerce_save_data' )
        ) {
            return;
        }

        if ( ! isset( $_POST[ self::META_KEY ] ) ) {
            return;
        }

        $raw_value = sanitize_text_field( wp_unslash( $_POST[ self::META_KEY ] ) );
        $value     = $this->sanitize_units_per_box( $raw_value );

        if ( null === $value ) {
            $product->delete_meta_data( self::META_KEY );
        } else {
            $product->update_meta_data( self::META_KEY, $value );
        }
    }
}
