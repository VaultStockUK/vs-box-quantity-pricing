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
    }
}
