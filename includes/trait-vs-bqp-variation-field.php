<?php

defined( 'ABSPATH' ) || exit;

trait VS_BQP_Variation_Field {
    public function render_variation_field( $loop, $variation_data, $variation ) {
        woocommerce_wp_text_input( array(
            'id' => self::META_KEY . '[' . $loop . ']',
            'name' => self::META_KEY . '[' . $loop . ']',
            'value' => get_post_meta( $variation->ID, self::META_KEY, true ),
            'label' => __( 'Units Per Box', 'vs-box-quantity-pricing' ),
            'description' => __( 'Leave blank to inherit the parent product value. Enter 1 to disable box pricing for this variation.', 'vs-box-quantity-pricing' ),
            'desc_tip' => true,
            'type' => 'number',
            'wrapper_class' => 'form-row form-row-full',
            'custom_attributes' => array( 'min' => '1', 'step' => '1' ),
        ) );
    }

    public function save_variation_field( $variation_id, $loop ) {
        if ( ! isset( $_POST[ self::META_KEY ][ $loop ] ) ) return;
        $variation = wc_get_product( $variation_id );
        if ( ! $variation ) return;
        $value = $this->sanitize_units_per_box( wc_clean( wp_unslash( $_POST[ self::META_KEY ][ $loop ] ) ) );
        if ( null === $value ) $variation->delete_meta_data( self::META_KEY );
        else $variation->update_meta_data( self::META_KEY, $value );
        $variation->save_meta_data();
    }
}
