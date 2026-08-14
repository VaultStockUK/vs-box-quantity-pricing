<?php

defined( 'ABSPATH' ) || exit;

final class VS_BQP_Plugin {
    /** @var VS_BQP_Plugin|null */
    private static $instance = null;

    /** @var VS_BQP_Product_Data */
    private $product_data;

    /** @var VS_BQP_Pricing */
    private $pricing;

    /** @var VS_BQP_Display */
    private $display;

    private function __construct() {
        $this->product_data = new VS_BQP_Product_Data();
        $this->pricing      = new VS_BQP_Pricing( $this->product_data );
        $this->display      = new VS_BQP_Display( $this->product_data );
    }

    /**
     * @return VS_BQP_Plugin
     */
    public static function instance() {
        if ( null === self::$instance ) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    public function init() {
        $this->product_data->init();
        $this->pricing->init();
        $this->display->init();

        add_action( 'vs_labs_register_plugins', array( $this, 'register_with_vs_labs_hub' ) );
    }

    /**
     * Register this plugin with VS Labs Hub when the Hub is installed.
     *
     * The Hub remains optional; this method is only called through the Hub's
     * registration action and is guarded so the plugin stays fully standalone.
     *
     * @return void
     */
    public function register_with_vs_labs_hub() {
        if ( ! class_exists( 'VS_Labs_Registry' ) ) {
            return;
        }

        VS_Labs_Registry::register(
            array(
                'slug'              => 'vs-box-quantity-pricing',
                'name'              => 'VS Box Quantity Pricing',
                'version'           => VS_BQP_VERSION,
                'description'       => 'Sell WooCommerce products in fixed box quantities while displaying clear per-unit pricing.',
                'settings_url'      => '',
                'documentation_url' => 'https://labs.vaultstock.co.uk/plugins/vs-box-quantity-pricing/',
                'support_url'       => 'https://labs.vaultstock.co.uk/',
                'status'            => 'active',
            )
        );
    }
}
