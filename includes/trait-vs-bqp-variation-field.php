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
}
