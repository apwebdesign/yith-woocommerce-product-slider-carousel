<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
} // Exit if accessed directly

$animations_list =   ywcps_animations_list();

$animations_in     =   array();
foreach( $animations_list['Fading Entrances'] as $value ){
    $animations_in[$value]=$value;
}
$animations_out =   array();
foreach( $animations_list['Fading Exits'] as $value ){
    $animations_out[$value]=$value;
}

$settings   =   array(

    'settings'   =>  array(

        'section_product_slider_settings' =>  array(
            'name'  => __('General Settings', 'ywcps'),
            'type'  =>  'title',
            'id'    =>  'ywcps_section_general_start'
        ),

        'check_responsive'  =>  array(
            'name'  =>  __('Enable Responsive', 'ywcps'),
            'type'  =>  'hidden',
            'id'    =>  'ywcps_check_responsive',
            'default'   =>  'no',
            'std'       =>  'no',
        ),

        'n_posts_per_page'  =>  array(
            'name'  =>  __('Product to show', 'ywcps'),
            'type'  =>  'number',
            'id'    =>  'ywcps_n_posts_per_page',
            'desc_tip'  =>  __('This option lets you choose the number of products you want to show. -1 for all', 'ywcps'),
            'custom_attributes' =>  array(
                'min'   =>  -1,
                'max'   =>  99,
            ),
            'std'   =>  15
        ),

        'check_rtl'  =>  array(
            'name'  =>  __('Enable Rtl support', 'ywcps'),
            'type'  =>  'checkbox',
            'id'    =>  'ywcps_check_rtl',
            'default'   =>  'no',
            'std'       =>  'no',
        ),
        'ywcps_check_loop' =>  array(
            'name' =>  __('Loop slider', 'ywcps'),
            'desc'  =>  __('Choose if you want your slider to scroll products continuously', 'ywcps'),
            'type'  =>  'checkbox',
            'std'   =>  'no',
            'default'   =>  'no',
            'id'    =>  'ywcps_check_loop'
        ),

        'ywcps_pagination_speed' =>  array(
            'name' =>  __('Pagination Speed', 'ywcps'),
            'desc_tip'  =>  __('Pagination speed in milliseconds', 'ywcps'),
            'type'  =>  'text',
            'std'   =>  '800',
            'default'   =>  '800',
            'id'    =>  'ywcps_pagination_speed'
        ),


        'ywcps_auto_play' =>  array(
            'name' =>  __('AutoPlay', 'ywcps'),
            'desc_tip'  =>  __('Insert the autoplay value in milliseconds, enter 0 to disable it', 'ywcps'),
            'type'  =>  'text',
            'std'   =>  '5000',
            'default'   =>  '5000',
            'id'    =>'ywcps_auto_play'
        ),

        'ywcps_stop_hover'  =>  array(
            'name' =>  __('Stop on Hover', 'ywcps'),
            'desc'  =>  __('Stop autoplay on mouse hover', 'ywcps'),
            'type'  =>  'checkbox',
            'std'   => 'no',
            'default'   => 'no',
            'id'    =>  'ywcps_stop_hover'
        ),

        'ywcps_show_navigation'  =>  array(
            'name' =>  __('Show Navigation', 'ywcps'),
            'desc'  =>  __('Display "prev" and "next" button', 'ywcps'),
            'type'  =>  'checkbox',
            'std'   => 'no',
            'default'   => 'no',
            'id'    =>  'ywcps_show_navigation'
        ),

        'ywcps_show_dot_navigation' =>  array(
            'name' =>  __('Show Dots Navigation' ,'ywcps'),
            'desc'  =>  __('Show or Hide dots navigation', 'ywcps'),
            'type'  =>  'checkbox',
            'std'   =>  'no',
            'default'   => 'no',
            'id'    =>  'ywcps_show_dot_navigation'
        ),

        'ywcps_animate_in'  =>  array(
            'name' =>  __('Animation IN', 'ywcps'),
            'desc_tip'  =>  __('Choose entrance animation for a new slide.*Animation functions work only if there is just one item in the slider and only in browsers that support perspective property', 'ywcps'),
            'type'  =>  'select',
            'options'   =>  $animations_in,
            'id'    =>  'ywcps_animate_in'
        ),
        'ywcps_animate_out'  =>  array(
            'name' =>  __('Animation OUT', 'ywcps'),
            'desc_tip'  =>  __('Choose exit animation for a slide. *Animation functions work only if there is just one item in the slider and only in browsers that support perspective property', 'ywcps'),
            'type'  =>  'select',
            'options'   =>  $animations_out,
            'id'    =>  'ywcps_animate_out'
        ),

        'ywcps_animation_speed' =>  array(
            'name' =>  __('Animation Speed', 'ywcps'),
            'desc_tip'  =>  __('Enter animation duration in milliseconds', 'ywcps'),
            'type'  =>  'text',
            'std'   =>  450,
            'default'   => 450,
            'id'    => 'ywcps_animation_speed'
        ),

        'general_settings_end'     => array(
            'type' => 'sectionend',
            'id'   => 'ywcps_section_general_end'
        ),

        'section_product_slider_content'    =>  array(
            'name'  =>  __( 'Content Setting', 'ywcps' ),
            'type'  =>  'title',
            'id'    =>  'ywcps_section_content_start'
        ),
        'ywcps_title'   =>  array(
          'name'    =>  __('Title', 'ywcps' ),
          'type'    =>  'text',
          'id'      =>  'ywcps_title',
          'placeholder'    =>  __('Enter Product Slider Title', 'ywcps'),
           'custom_attributes'  =>  array(
               'required'   =>  'required'
           ),
            'default'   => 'Free Slider',
            'std'       => 'Free Slider'
        ),

        'ywcps_show_title'  =>  array(
            'name'  =>  __('Show Title', 'ywcps'),
            'type'  =>  'checkbox',
            'std'   =>  'yes',
            'default'   =>  'yes',
            'id'    =>  'ywcps_show_title'
        ),
        'ywcps_categories' => array(
            'name' =>  __('Choose Product Category','ywcps'),
            'placeholder'  =>  __('Choose product categories','ywcps'),
            'desc'         =>   __( 'Leave this field empty if you want all categories to be shown in the slider', 'ywcps'),
            'type'  =>  'ajax-category',
            'multiple' =>  'true',
            'id'    =>  'ywcps_categories',
        ),

        'ywcps_layout_type' =>  array(
            'name' =>  __('Slider Template', 'ywcps'),
            'desc_tip'  =>  __('Choose template for Product Slider', 'ywcps'),
            'type'  =>  'select',
            'options'    =>  array(
                'default'   =>  'WooCommerce Loop',
            ),
            'std' =>    'default',
            'id'    =>  'ywcps_layout_type'
        ),

        'ywcps_image_per_row'   => array(
            'name' =>  __('Images per row', 'ywcps'),
            'desc'  =>  '',
            'type'  =>  'number',
            'custom_attributes' =>  array(
                'min'   =>  1,
                'max'   =>  4,
            ),
            'std'   =>  4,
            'default'   =>  4,
            'id'    =>'ywcps_image_per_row'
        ),

        'ywcps_order_by'    =>  array(
            'name'     =>  __('Order By', 'ywcps'),
            'type'      =>  'select',
            'desc'  =>  '',
            'options'   =>  array(
                'name'      =>  __('Name', 'ywcps'),
                'price'     =>  __('Price', 'ywcps'),
                'date'  =>  __('Date', 'ywcps')
            ),
            'id'    =>  'ywcps_order_by'
        ),

        'ywcps_order_type'   => array(
            'name' =>  __('Order Type', 'ywcps'),
            'type'  =>  'select',
            'desc'  =>  '',
            'options'   =>  array(
                'asc'   =>  'ASC',
                'desc'  =>  'DESC'
            ),
            'id'    =>  'ywcps_order_type'
        ),

        'ywcps_info_shortcode' =>  array(
            'name'  => __('Use this shortcode in your pages ', 'ywcps'),
            'type'  =>  'text',
            'custom_attributes' =>  array( 'readonly' => 'readonly' ),
            'id'    =>  'ywcps_info_shortcode',
            'default' => '[yith_wc_productslider id='.YITH_Product_Slider()->get_productslider()[0]['value'].']',
            'std'   => '[yith_wc_productslider id='.YITH_Product_Slider()->get_productslider()[0]['value'].']',
            'css' =>  'width:30%'
        ),

        'content_settings_end'     => array(
            'type' => 'sectionend',
            'id'   => 'ywcps_section_content_end'
        ),



    )

);

return apply_filters( 'ywsfl_general_settings' , $settings );