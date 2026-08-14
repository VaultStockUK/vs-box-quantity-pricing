<?php

defined( 'ABSPATH' ) || exit;

class VS_BQP_Display {
    private $product_data;
    public function __construct( VS_BQP_Product_Data $product_data ) {
        $this->product_data = $product_data;
    }
}
