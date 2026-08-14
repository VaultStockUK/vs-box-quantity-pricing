<?php

defined( 'ABSPATH' ) || exit;

class VS_BQP_Display {
    private $product_data;

    public function __construct( VS_BQP_Product_Data $product_data ) {
        $this->product_data = $product_data;
    }

    public function init() {
        add_filter( 'woocommerce_get_price_html', array( $this, 'filter_price_html' ), 20, 2 );
    }

    public function filter_price_html( $price_html, $product ) {
        if ( is_admin() && ! wp_doing_ajax() ) return $price_html;
        if ( ! $product instanceof WC_Product || '' === $price_html ) return $price_html;
        $units = $this->product_data->get_units_per_box( $product );
        if ( $units <= 1 ) return $price_html;
        if ( $product->is_type( 'variable' ) ) {
            return '<span class="vs-bqp-unit-price">' . $price_html . ' <small>' . esc_html__( 'each', 'vs-box-quantity-pricing' ) . '</small></span><br><small class="vs-bqp-box-info">' . esc_html( sprintf( __( 'Default: sold in boxes of %d. Select options for the final box size.', 'vs-box-quantity-pricing' ), $units ) ) . '</small>';
        }
        $box_price = (float) $product->get_price( 'edit' ) * $units;
        return '<span class="vs-bqp-unit-price">' . $price_html . ' <small>' . esc_html__( 'each', 'vs-box-quantity-pricing' ) . '</small></span><br><small class="vs-bqp-box-info">' . esc_html( sprintf( __( '%1$d per box · %2$s per box', 'vs-box-quantity-pricing' ), $units, wp_strip_all_tags( wc_price( $box_price ) ) ) ) . '</small>';
    }
}
