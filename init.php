<?php
/**
 * Plugin Name: YITH WooCommerce Product Slider Carousel
 * Plugin URI:
 * Description: YITH WooCommerce Product Slider allows you to create responsive product slider!
 * Version: 1.0.0
 * Author: YIThemes
 * Author URI: http://yithemes.com/
 * Text Domain: ywcps
 * Domain Path: /languages/
 *
 * @author Your Inspiration Themes
 * @package YITH WooCommerce Product Slider
 * @version 1.0.0
 */

/*
 * This source file is subject to the GNU GENERAL PUBLIC LICENSE (GPL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://www.gnu.org/licenses/gpl-3.0.txt
*/
if( !defined( 'ABSPATH' ) ){
    exit;
}
if ( ! function_exists( 'is_plugin_active' ) ) {
    require_once( ABSPATH . 'wp-admin/includes/plugin.php' );
}

if ( !function_exists( 'WC' ) ) {
    function yith_ywcps_install_woocommerce_admin_notice() {
        ?>
        <div class="error">
            <p><?php _e( 'YITH WooCommerce Product Slider Carousel is enabled but not effective. It requires WooCommerce in order to work.', 'ywcps' ); ?></p>
        </div>
    <?php
    }

    add_action( 'admin_notices', 'yith_ywcps_install_woocommerce_admin_notice' );
    return;
}

if ( defined( 'YWCPS_PREMIUM' ) ) {
    function yith_ywcps_install_free_admin_notice() {
        ?>
        <div class="error">
            <p><?php _e( 'You can\'t activate the free version of YITH WooCommerce Product Slider Carousel while you are using the premium one.', 'ywcps' ); ?></p>
        </div>
    <?php
    }

    add_action( 'admin_notices', 'yith_ywcps_install_free_admin_notice' );

    deactivate_plugins( plugin_basename( __FILE__ ) );
    return;
}

if ( !function_exists( 'yith_plugin_registration_hook' ) ) {
    require_once 'plugin-fw/yit-plugin-registration-hook.php';
}
register_activation_hook( __FILE__, 'yith_plugin_registration_hook' );


if ( !defined( 'YWCPS_VERSION' ) ) {
    define( 'YWCPS_VERSION', '1.0.0' );
}

if ( !defined( 'YWCPS_FREE_INIT' ) ) {
    define( 'YWCPS_FREE_INIT', plugin_basename( __FILE__ ) );
}

if ( !defined( 'YWCPS_FILE' ) ) {
    define( 'YWCPS_FILE', __FILE__ );
}

if ( !defined( 'YWCPS_DIR' ) ) {
    define( 'YWCPS_DIR', plugin_dir_path( __FILE__ ) );
}

if ( !defined( 'YWCPS_URL' ) ) {
    define( 'YWCPS_URL', plugins_url( '/', __FILE__ ) );
}

if ( !defined( 'YWCPS_ASSETS_URL' ) ) {
    define( 'YWCPS_ASSETS_URL', YWCPS_URL . 'assets/' );
}

if ( !defined( 'YWCPS_ASSETS_PATH' ) ) {
    define( 'YWCPS_ASSETS_PATH', YWCPS_DIR . 'assets/' );
}

if ( !defined( 'YWCPS_TEMPLATE_PATH' ) ) {
    define( 'YWCPS_TEMPLATE_PATH', YWCPS_DIR . 'templates/' );
}

if ( !defined( 'YWCPS_INC' ) ) {
    define( 'YWCPS_INC', YWCPS_DIR . 'includes/' );
}
if( !defined(' YWCPS_SLUG' ) ){
    define( 'YWCPS_SLUG', 'yith-woocommerce-product-slider-carousel' );
}

load_plugin_textdomain( 'ywcps', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );

if ( ! function_exists( 'YITH_Product_Slider' ) ) {
    /**
     * Unique access to instance of YITH_Product_Slider class
     *
     * @return YITH_Product_Slider
     * @since 1.0.0
     */
    function YITH_Product_Slider() {
        // Load required classes and functions
        require_once( YWCPS_INC .'functions.yith-product-slider.php' );
        require_once( YWCPS_INC .'class.yith-product-slider-type.php' );
        require_once( YWCPS_INC . 'class.yith-product-slider-shortcode.php' );
        require_once( YWCPS_INC .'class.yith-woocommerce-product-slider.php' );

        if( defined( 'YWCPS_PREMIUM' ) && file_exists( YWCPS_INC .'class.yith-woocommerce-product-slider-premium.php' ) ) {
            require_once( YWCPS_INC .'functions.yith-product-slider-premium.php' );
            require_once( YWCPS_INC .'class.yith-product-slider-type-premium.php' );
            require_once( YWCPS_INC . 'class.yith-woocommerce-product-slider-premium.php' );
            require_once( YWCPS_INC . 'class.yith-product-slider-widget.php' );

            return YITH_WooCommerce_Product_Slider_Premium::get_instance();
        }
        return YITH_WooCommerce_Product_Slider::get_instance();

    }
}

/**
 * Instance main plugin class
 */
YITH_Product_Slider();