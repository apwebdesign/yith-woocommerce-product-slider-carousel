<?php
if( !defined( 'ABSPATH' ) ){
    exit;
}

if( !class_exists( 'YITH_Product_Slider_Shortcode' ) ){

    class YITH_Product_Slider_Shortcode{

        public static function print_product_slider( $atts, $content=null ){

            global $yith_wc_product_slider;

            $default_attrs  = array( );

            $atts    =   shortcode_atts( $default_attrs, $atts );

               $extra_params    =   array(
               'en_responsive'       =>   get_option( 'ywcps_check_responsive' ) == 'yes' ? "true" :  "false" ,
               'n_item_desk_small'   =>   get_option( 'ywcps_n_item_small_desk' ),
               'n_item_tablet'       =>   get_option( 'ywcps_n_item_tablet' ),
               'n_item_mobile'       =>   get_option( 'ywcps_n_item_mobile' ),
               'is_rtl'              =>   get_option( 'ywcps_check_rtl' ) == 'yes'  ?   "true"    :   "false",
               'posts_per_page'     =>    get_option( 'ywcps_n_posts_per_page' ),

               //Slider Settings
              
               'categories'          =>   get_option(  'ywcps_categories' ,false ),
               'product_type'        =>   get_option(  'ywcps_product_type' ),
               'title'               =>   get_option(  'ywcps_title' ),
               'n_items'             =>   get_option(  'ywcps_image_per_row' ),
               'order_by'            =>   get_option(  'ywcps_order_by' ),
               'order'               =>   get_option(  'ywcps_order_type' ),
               'is_loop'             =>   get_option(  'ywcps_check_loop' ) == 'yes' ?  "true"  :   "false",
               'page_speed'          =>   get_option(  'ywcps_pagination_speed' ),
               'auto_play'           =>   get_option(  'ywcps_auto_play' ) ,
               'stop_hov'            =>   get_option(  'ywcps_stop_hover' )   ==  'yes' ?   "true"    :   "false",
               'show_nav'            =>   get_option(  'ywcps_show_navigation' )   == 'yes' ?   "true"    :   "false",
               'anim_in'             =>   get_option(  'ywcps_animate_in' ),
               'anim_out'            =>   get_option(  'ywcps_animate_out' ),
               'anim_speed'          =>   get_option(  'ywcps_animation_speed' ),
               'show_dot_nav'        =>   get_option(  'ywcps_show_dot_navigation' ) == 'yes' ? "true"    :   "false",
               'show_title'          =>   get_option( 'ywcps_show_title' ) == 'yes'
           );

               $atts            =   array_merge( $extra_params, $atts );
               $atts['atts']    =   $extra_params;

               $yith_wc_product_slider  =   true;
               $template                =   yit_plugin_get_template( YWCPS_DIR, 'product_slider_view.php', $atts, true );
               $yith_wc_product_slider  =   false;

               return apply_filters( 'yith_wcpsl_productslider_html', $template, array(), true );

           }

        }
}
add_shortcode( 'yith_wc_productslider', array( 'YITH_Product_Slider_Shortcode', 'print_product_slider' ) );