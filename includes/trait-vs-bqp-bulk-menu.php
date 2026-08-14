<?php

defined( 'ABSPATH' ) || exit;

trait VS_BQP_Bulk_Menu {
    public function render_bulk_action() {
        echo '<optgroup label="' . esc_attr__( 'VS Box Quantity Pricing', 'vs-box-quantity-pricing' ) . '">';
        echo '<option value="vs_bqp_set_units_per_box">' . esc_html__( 'Set units per box', 'vs-box-quantity-pricing' ) . '</option>';
        echo '</optgroup>';
    }

    public function enqueue_admin_assets( $hook_suffix ) {
        if ( ! in_array( $hook_suffix, array( 'post.php', 'post-new.php' ), true ) ) return;
        $screen = get_current_screen();
        if ( ! $screen || 'product' !== $screen->post_type ) return;
        wp_enqueue_style( 'vs-bqp-admin', plugins_url( 'assets/admin.css', VS_BQP_FILE ), array(), VS_BQP_VERSION );
        wp_enqueue_script( 'vs-bqp-admin', plugins_url( 'assets/js/admin.js', VS_BQP_FILE ), array( 'jquery' ), VS_BQP_VERSION, true );
        $product_id = isset( $_GET['post'] ) ? absint( $_GET['post'] ) : 0;
        $product = $product_id ? wc_get_product( $product_id ) : false;
        wp_localize_script( 'vs-bqp-admin', 'vs_bqp_admin', array(
            'ajax_url' => admin_url( 'admin-ajax.php' ),
            'nonce' => wp_create_nonce( 'vs_bqp_bulk_units' ),
            'product_id' => $product_id,
            'default_units' => $product ? (string) $this->get_units_per_box( $product ) : '',
            'invalid_units_message' => __( 'Units Per Box must be a whole number of 1 or greater.', 'vs-box-quantity-pricing' ),
            'saving_message' => __( 'Updating variations…', 'vs-box-quantity-pricing' ),
            'error_message' => __( 'The variations could not be updated. Please try again.', 'vs-box-quantity-pricing' ),
        ) );
    }
}
