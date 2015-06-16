<?php
if( !defined( 'ABSPATH' ) )
    exit;

if( !class_exists( 'YITH_WooCommerce_Product_Slider' ) ) {

    class YITH_WooCommerce_Product_Slider
    {

        protected static $_instance;
        protected $_panel = null;
        protected $_panel_page = 'yith_wc_product_slider';
        protected $_official_documentation = '';
        protected $_premium_landing_url = 'http://yithemes.com/themes/plugins/yith-woocommerce-product-slider-carousel/';
        protected $_premium = 'premium.php';

        public function __construct()
        {
            // Load Plugin Framework
            $this->product_slider = YITH_Product_Slider_Type();

            add_action( 'after_setup_theme', array($this, 'plugin_fw_loader'), 1);
            //Add action links
            add_filter( 'plugin_action_links_' . plugin_basename(YWCPS_DIR . '/' . basename(YWCPS_FILE)), array($this, 'action_links'));
            //Add row meta
            add_filter( 'plugin_row_meta', array( $this, 'plugin_row_meta' ) , 10, 4 );
            //Add menu  field under YITH_PLUGIN
            add_action( 'yith_wc_product_slider_carousel_premium', array( $this, 'premium_tab' ) );
            add_action( 'admin_menu', array($this, 'add_product_slider_carousel_menu' ), 5);

            add_action( 'wp_enqueue_scripts', array( $this, 'include_style_script' ) );
            add_action( 'admin_enqueue_scripts', array( $this, 'include_admin_style_script' ) );

            //Add context menu to TinyMCE editor
            add_action( 'admin_init', array( $this, 'add_shortcodes_button' ) );

           if( !defined( 'YWCPS_PREMIUM' ) ) {
               $this->_include_templates();
               add_action('woocommerce_admin_field_ajax-category', 'YWCPS_Ajax_Category::output');
           }

        }

        public static function get_instance()
        {
            if (is_null(self::$_instance)) {
                self::$_instance = new self();
            }

            return self::$_instance;
        }

        private function _include_templates()
        {
             include_once( YWCPS_TEMPLATE_PATH .'/admin/ajax-category.php');
        }

        public function plugin_fw_loader()
        {
            if (!defined('YIT') || !defined('YIT_CORE_PLUGIN')) {
                require_once(YWCPS_DIR . 'plugin-fw/yit-plugin.php');
            }
        }

        /**
         * Action Links
         *
         * add the action links to plugin admin page
         *
         * @param $links | links plugin array
         *
         * @return   mixed Array
         * @since    1.0
         * @author   Andrea Grillo <andrea.grillo@yithemes.com>
         * @return mixed
         * @use plugin_action_links_{$plugin_file_name}
         */
        public function action_links($links)
        {

            $links[] = '<a href="' . admin_url("admin.php?page={$this->_panel_page}") . '">' . __('Settings', 'ywcps') . '</a>';

            if (defined('YWCPS_FREE_INIT')) {
                $links[] = '<a href="' . $this->get_premium_landing_uri() . '" target="_blank">' . __('Premium Version', 'ywcps') . '</a>';
            }

            return $links;
        }

        /**
         * plugin_row_meta
         *
         * add the action links to plugin admin page
         *
         * @param $plugin_meta
         * @param $plugin_file
         * @param $plugin_data
         * @param $status
         *
         * @return   Array
         * @since    1.0
         * @author   Andrea Grillo <andrea.grillo@yithemes.com>
         * @use plugin_row_meta
         */
        public function plugin_row_meta($plugin_meta, $plugin_file, $plugin_data, $status)
        {
            if ((defined('YWCPS_INIT') && (YWCPS_INIT == $plugin_file)) ||
                (defined('YWCPS_FREE_INIT') && (YWCPS_FREE_INIT == $plugin_file))
            ) {

                $plugin_meta[] = '<a href="' . $this->_official_documentation . '" target="_blank">' . __('Plugin Documentation', 'ywcps') . '</a>';
            }

            return $plugin_meta;
        }

        /**
         * Get the premium landing uri
         *
         * @since   1.0.0
         * @author  Andrea Grillo <andrea.grillo@yithemes.com>
         * @return  string The premium landing link
         */
        public function get_premium_landing_uri()
        {
            return defined('YITH_REFER_ID') ? $this->_premium_landing_url . '?refer_id=' . YITH_REFER_ID : $this->_premium_landing_url;
        }

        /**
         * Premium Tab Template
         *
         * Load the premium tab template on admin page
         *
         * @since   1.0.0
         * @author  Andrea Grillo <andrea.grillo@yithemes.com>
         * @return  void
         */
        public function premium_tab()
        {
            $premium_tab_template = YWCPS_TEMPLATE_PATH . '/admin/' . $this->_premium;
            if (file_exists($premium_tab_template)) {
                include_once($premium_tab_template);
            }
        }

        /**
         * Add a panel under YITH Plugins tab
         *
         * @return   void
         * @since    1.0
         * @author   Andrea Grillo <andrea.grillo@yithemes.com>
         * @use     /Yit_Plugin_Panel class
         * @see      plugin-fw/lib/yit-plugin-panel.php
         */
        public function add_product_slider_carousel_menu()
        {
            if (!empty($this->_panel)) {
                return;
            }

            $admin_tabs = array(
                'settings' => __('Settings', 'ywcps'),
            );

            if (!defined('YWCPS_PREMIUM'))
                $admin_tabs['premium-landing'] = __('Premium Version', 'ywcps');
            else {
                $admin_tabs['layout1']  =   __('Layout 1', 'ywcps');
                $admin_tabs['layout2']  =   __('Layout 2', 'ywcps');
                $admin_tabs['layout3']  =   __('Layout 3', 'ywcps');

            }

            $args = array(
                'create_menu_page' => true,
                'parent_slug' => '',
                'page_title' => __('Product Slider Carousel', 'ywcps'),
                'menu_title' => __('Product Slider Carousel', 'ywcps'),
                'capability' => 'manage_options',
                'parent' => '',
                'parent_page' => 'yit_plugin_panel',
                'page' => $this->_panel_page,
                'admin-tabs' => $admin_tabs,
                'options-path' => YWCPS_DIR . '/plugin-options'
            );

            $this->_panel = new YIT_Plugin_Panel_WooCommerce($args);
        }


        /**Include style and script
         * @author YITHEMES
         * @since 1.0.0
         */
        public function include_style_script()
        {
            wp_register_style('yith-fontawesome', YWCPS_ASSETS_URL . 'css/font-awesome.min.css');
            wp_register_style('owl-carousel-style', YWCPS_ASSETS_URL . 'css/owl.css');
            wp_register_style('yith-animate', YWCPS_ASSETS_URL . 'css/animate.css');
            wp_register_style('yith-product-slider-style', YWCPS_ASSETS_URL . 'css/product_slider_style.css');

            wp_enqueue_style('yith-fontawesome');
            wp_enqueue_style('owl-carousel-style');
            wp_enqueue_style('yith-animate');
            wp_enqueue_style('yith-product-slider-style');
            wp_register_script('yith-common-library', YWCPS_ASSETS_URL . 'js/jquery.commonlibraries.js', array('jquery'), false, true);
            wp_enqueue_script('yith-common-library');
            wp_register_script('owl-carousel', YWCPS_ASSETS_URL . 'js/owl.carousel.js', array('jquery'), '1.0.0', true);
        }


        public function include_admin_style_script()
        {
            //ywcps_shortcode
            wp_register_script( 'ywcps_admin_script', YWCPS_ASSETS_URL . 'js/yith_admin_product_slider.js', array('jquery'), '1.0.0', true );
            wp_enqueue_script( 'ywcps_admin_script' );

            $ywcps_localize_script  =   array(
                'i18n_matches_1'            => _x( 'One result is available, press enter to select it.', 'enhanced select', 'woocommerce' ),
                'i18n_matches_n'            => _x( '%qty% results are available, use up and down arrow keys to navigate.', 'enhanced select', 'woocommerce' ),
                'i18n_no_matches'           => _x( 'No matches found', 'enhanced select', 'woocommerce' ),
                'i18n_ajax_error'           => _x( 'Loading failed', 'enhanced select', 'woocommerce' ),
                'i18n_input_too_short_1'    => _x( 'Please enter 1 or more characters', 'enhanced select', 'woocommerce' ),
                'i18n_input_too_short_n'    => _x( 'Please enter %qty% or more characters', 'enhanced select', 'woocommerce' ),
                'i18n_input_too_long_1'     => _x( 'Please delete 1 character', 'enhanced select', 'woocommerce' ),
                'i18n_input_too_long_n'     => _x( 'Please delete %qty% characters', 'enhanced select', 'woocommerce' ),
                'i18n_selection_too_long_1' => _x( 'You can only select 1 item', 'enhanced select', 'woocommerce' ),
                'i18n_selection_too_long_n' => _x( 'You can only select %qty% items', 'enhanced select', 'woocommerce' ),
                'i18n_load_more'            => _x( 'Loading more results&hellip;', 'enhanced select', 'woocommerce' ),
                'i18n_searching'            => _x( 'Searching&hellip;', 'enhanced select', 'woocommerce' ),
                'ajax_url'                  => admin_url( 'admin-ajax.php' ),
                'search_categories_nonce'   => wp_create_nonce( YWCPS_SLUG .'_search-categories' ),
                'plugin_nonce'                    =>  ''.YWCPS_SLUG.''

            );

            wp_localize_script( 'ywcps_admin_script', 'ywcps_admin_i18n', $ywcps_localize_script );
            wp_localize_script('jquery', 'yith_wpsc_slider_info', array('product_slider' => $this->get_productslider()));

        }


        /**
         * Add shortcode button
         *
         * Add shortcode button to TinyMCE editor, adding filter on mce_external_plugins
         *
         * @return void
         * @since 1.0.0
         * @author Antonio La Rocca <antonio.larocca@yithemes.it>
         */
        public function add_shortcodes_button()
        {
            if (!current_user_can('edit_posts') && !current_user_can('edit_pages'))
                return;
            if (get_user_option('rich_editing') == 'true') {
                add_filter('mce_external_plugins', array(&$this, 'add_shortcodes_tinymce_plugin'));
                add_filter('mce_buttons', array(&$this, 'register_shortcodes_button'));
            }
        }

        /**
         * Add shortcode plugin
         *
         * Add a script to TinyMCE script list
         *
         * @param $plugin_array array() Array containing TinyMCE script list
         *
         * @return array() The edited array containing TinyMCE script list
         * @since 1.0.0
         * @author Antonio La Rocca <antonio.larocca@yithemes.it>
         */
        public function add_shortcodes_tinymce_plugin($plugin_array)
        {
            $plugin_array['ywcps_shortcode'] = YWCPS_ASSETS_URL . 'js/tinymce.js';
            return $plugin_array;
        }

        /**
         * Register shortcode button
         *
         * Make TinyMCE know a new button was included in its toolbar
         *
         * @param $buttons array() Array containing buttons list for TinyMCE toolbar
         *
         * @return array() The edited array containing buttons list for TinyMCE toolbar
         * @since 1.0.0
         * @author Antonio La Rocca <antonio.larocca@yithemes.it>
         */
        public function register_shortcodes_button($buttons)
        {
            array_push($buttons, "|", "ywcps_shortcode");
            return $buttons;
        }

        /**return all product slider
         * @author YITHEMES
         * @since 1.0.0
         * @used include_style_script
         * @return array
         */
        public function get_productslider()
        {
            global $slider_free_id;

            return array( array( 'text' => get_option('ywcps_title'), 'value' => $slider_free_id ) );

        }


    }
}