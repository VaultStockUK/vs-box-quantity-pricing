<?php

defined( 'ABSPATH' ) || exit;

class VS_BQP_Display {
    private $product_data;

    public function __construct( VS_BQP_Product_Data $product_data ) {
        $this->product_data = $product_data;
    }

    public function init() {
        add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_assets' ) );
        add_filter( 'woocommerce_get_price_html', array( $this, 'filter_price_html' ), 20, 2 );
        add_filter( 'woocommerce_available_variation', array( $this, 'add_variation_payload' ), 20, 3 );
        add_action( 'woocommerce_before_variations_form', array( $this, 'render_variation_box_info' ), 5 );
        add_action( 'woocommerce_after_add_to_cart_quantity', array( $this, 'render_quantity_suffix' ) );
        add_filter( 'woocommerce_get_item_data', array( $this, 'add_cart_item_data' ), 10, 2 );
        add_filter( 'woocommerce_cart_item_quantity', array( $this, 'append_cart_quantity_label' ), 10, 3 );
    }

    public function enqueue_assets() {
        if ( is_product() ) {
            wp_enqueue_script( 'vs-bqp-frontend', plugins_url( 'assets/js/frontend.js', VS_BQP_FILE ), array( 'jquery', 'wc-add-to-cart-variation' ), VS_BQP_VERSION, true );
        }
    }

    public function filter_price_html( $price_html, $product ) {
        if ( is_admin() && ! wp_doing_ajax() ) {
            return $price_html;
        }

        if ( ! $product instanceof WC_Product || '' === $price_html ) {
            return $price_html;
        }

        $units = $this->product_data->get_units_per_box( $product );

        if ( $product->is_type( 'variable' ) ) {
            if ( $units <= 1 && ! $this->variable_has_boxed_variations( $product ) ) {
                return $price_html;
            }

            return '<span class="vs-bqp-unit-price">' . $price_html . ' <small>' . esc_html__( 'each', 'vs-box-quantity-pricing' ) . '</small></span>';
        }

        if ( $units <= 1 ) {
            return $price_html;
        }

        $box_price = (float) $product->get_price( 'edit' ) * $units;

        /* translators: 1: number of units in one box, 2: formatted price for one box. */
        $box_info = sprintf( __( '%1$d per box · %2$s per box', 'vs-box-quantity-pricing' ), $units, wp_strip_all_tags( wc_price( $box_price ) ) );

        return '<span class="vs-bqp-unit-price">' . $price_html . ' <small>' . esc_html__( 'each', 'vs-box-quantity-pricing' ) . '</small></span><br><small class="vs-bqp-box-info">' . esc_html( $box_info ) . '</small>';
    }

    public function render_variation_box_info() {
        global $product;

        if ( ! $product instanceof WC_Product || ! $product->is_type( 'variable' ) ) {
            return;
        }

        if ( $this->product_data->get_units_per_box( $product ) <= 1 && ! $this->variable_has_boxed_variations( $product ) ) {
            return;
        }

        echo '<div class="vs-bqp-live-box-info" hidden aria-live="polite"></div>';
    }

    public function render_quantity_suffix() {
        global $product;

        if ( ! $product instanceof WC_Product ) {
            return;
        }

        if ( $product->is_type( 'variable' ) ) {
            echo '<span class="vs-bqp-quantity-suffix" data-vs-bqp-variable="1" hidden> ' . esc_html__( 'boxes', 'vs-box-quantity-pricing' ) . '</span>';
        } elseif ( $this->product_data->get_units_per_box( $product ) > 1 ) {
            echo '<span class="vs-bqp-quantity-suffix"> ' . esc_html__( 'boxes', 'vs-box-quantity-pricing' ) . '</span>';
        }
    }

    public function add_cart_item_data( $item_data, $cart_item ) {
        if ( empty( $cart_item[ VS_BQP_Pricing::CART_UNITS_KEY ] ) ) {
            return $item_data;
        }

        $units = absint( $cart_item[ VS_BQP_Pricing::CART_UNITS_KEY ] );
        if ( $units <= 1 ) {
            return $item_data;
        }

        $quantity = isset( $cart_item['quantity'] ) ? absint( $cart_item['quantity'] ) : 0;

        $item_data[] = array(
            'key'   => __( 'Unit price', 'vs-box-quantity-pricing' ),
            'value' => wp_kses_post( wc_price( (float) $cart_item[ VS_BQP_Pricing::CART_UNIT_PRICE_KEY ] ) . ' ' . esc_html__( 'each', 'vs-box-quantity-pricing' ) ),
        );

        /* translators: %d: number of individual units in one box. */
        $box_size = sprintf( _n( '%d unit', '%d units', $units, 'vs-box-quantity-pricing' ), $units );

        $item_data[] = array(
            'key'   => __( 'Box size', 'vs-box-quantity-pricing' ),
            'value' => $box_size,
        );
        $item_data[] = array(
            'key'   => __( 'Total units', 'vs-box-quantity-pricing' ),
            'value' => (string) ( $units * $quantity ),
        );

        return $item_data;
    }

    public function append_cart_quantity_label( $html, $cart_item_key, $cart_item ) {
        if ( ! empty( $cart_item[ VS_BQP_Pricing::CART_UNITS_KEY ] ) && absint( $cart_item[ VS_BQP_Pricing::CART_UNITS_KEY ] ) > 1 ) {
            $html .= ' <span class="vs-bqp-cart-quantity-label">' . esc_html__( 'boxes', 'vs-box-quantity-pricing' ) . '</span>';
        }

        return $html;
    }

    public function add_variation_payload( $data, $product, $variation ) {
        $units        = $this->product_data->get_units_per_box( $variation );
        $unit_price   = (float) $variation->get_price( 'edit' );
        $display_unit = wc_get_price_to_display( $variation, array( 'price' => $unit_price ) );

        $data['vs_bqp_units_per_box']       = $units;
        $data['vs_bqp_is_boxed']            = $units > 1;
        $data['vs_bqp_each_label']          = esc_html__( 'each', 'vs-box-quantity-pricing' );
        $data['vs_bqp_unit_price_html']     = wp_kses_post( wc_price( $display_unit ) );

        if ( $units > 1 ) {
            $display_box = wc_get_price_to_display( $variation, array( 'price' => $unit_price, 'qty' => $units ) );
            $data['vs_bqp_box_price_html'] = wp_kses_post( wc_price( $display_box ) );

            /* translators: 1: number of units in one box, 2: formatted price for one box. */
            $data['vs_bqp_box_info_html'] = wp_kses_post( sprintf( __( '%1$d per box &middot; %2$s per box', 'vs-box-quantity-pricing' ), $units, wc_price( $display_box ) ) );
        }

        return $data;
    }

    private function variable_has_boxed_variations( $product ) {
        foreach ( $product->get_children() as $variation_id ) {
            $variation = wc_get_product( $variation_id );
            if ( $variation && $this->product_data->get_units_per_box( $variation ) > 1 ) {
                return true;
            }
        }

        return false;
    }
}
