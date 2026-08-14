<?php

defined( 'ABSPATH' ) || exit;

class VS_BQP_Product_Data {
    use VS_BQP_Product_Field;
    use VS_BQP_Variation_Field;
    use VS_BQP_Bulk_Action;
    use VS_BQP_Product_Values;

    const META_KEY = '_vs_units_per_box';

    public function init() {
        add_action( 'woocommerce_product_options_pricing', array( $this, 'render_product_field' ) );
        add_action( 'woocommerce_admin_process_product_object', array( $this, 'save_product_field' ) );
        add_action( 'woocommerce_variation_options_pricing', array( $this, 'render_variation_field' ), 10, 3 );
        add_action( 'woocommerce_save_product_variation', array( $this, 'save_variation_field' ), 10, 2 );
        add_action( 'woocommerce_variable_product_bulk_edit_actions', array( $this, 'render_bulk_action' ) );
        add_action( 'wp_ajax_vs_bqp_bulk_set_units_per_box', array( $this, 'ajax_bulk_set_units_per_box' ) );
        add_action( 'admin_footer', array( $this, 'render_bulk_modal' ) );
        add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_admin_assets' ) );
    }
}
