<?php

defined( 'ABSPATH' ) || exit;

class VS_BQP_Display {
    private $product_data;

    public function __construct( VS_BQP_Product_Data $product_data ) {
        $this->product_data = $product_data;
    }

    public function init() {
        require_once VS_BQP_PATH . 'includes/class-vs-bqp-display-price.php';
        require_once VS_BQP_PATH . 'includes/class-vs-bqp-display-cart.php';
        require_once VS_BQP_PATH . 'includes/class-vs-bqp-display-variation.php';
        ( new VS_BQP_Display_Price( $this->product_data ) )->init();
        ( new VS_BQP_Display_Cart( $this->product_data ) )->init();
        ( new VS_BQP_Display_Variation( $this->product_data ) )->init();
    }
}
