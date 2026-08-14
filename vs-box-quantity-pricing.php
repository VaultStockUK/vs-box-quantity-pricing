<?php
/**
 * Plugin Name: VS Box Quantity Pricing
 * Plugin URI:  https://labs.vaultstock.co.uk/plugins/vs-box-quantity-pricing/
 * Description: Sell WooCommerce products in fixed box quantities while keeping customer-facing prices expressed per individual unit.
 * Version:     0.1.4
 * Author:      VS Labs
 * Author URI:  https://labs.vaultstock.co.uk
 * Text Domain: vs-box-quantity-pricing
 * Requires at least: 6.5
 * Requires PHP: 7.4
 * WC requires at least: 8.0
 * WC tested up to: 10.1
 * License: GPL-2.0-or-later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 */

defined( 'ABSPATH' ) || exit;

define( 'VS_BQP_VERSION', '0.1.4' );
define( 'VS_BQP_FILE', __FILE__ );
define( 'VS_BQP_PATH', plugin_dir_path( __FILE__ ) );

add_action(
    'before_woocommerce_init',
    static function () {
        if ( class_exists( '\Automattic\WooCommerce\Utilities\FeaturesUtil' ) ) {
            \Automattic\WooCommerce\Utilities\FeaturesUtil::declare_compatibility( 'custom_order_tables', __FILE__, true );
        }
    }
);

add_action(
    'plugins_loaded',
    static function () {
        if ( ! class_exists( 'WooCommerce' ) ) {
            add_action(
                'admin_notices',
                static function () {
                    echo '<div class="notice notice-error"><p>';
                    echo esc_html__( 'VS Box Quantity Pricing requires WooCommerce to be installed and active.', 'vs-box-quantity-pricing' );
                    echo '</p></div>';
                }
            );
            return;
        }

        require_once VS_BQP_PATH . 'includes/class-vs-bqp-product-data.php';
        require_once VS_BQP_PATH . 'includes/class-vs-bqp-pricing.php';
        require_once VS_BQP_PATH . 'includes/class-vs-bqp-display.php';
        require_once VS_BQP_PATH . 'includes/class-vs-bqp-plugin.php';

        VS_BQP_Plugin::instance()->init();
    }
);
