<?php
if( !defined( 'ABSPATH' ) ){
    exit;
}

wp_register_script( 'yith_wc_product_slider', YWCPS_ASSETS_URL .'js/yith_product_slider.js', array('jquery'), '1.0.0', false );
wp_enqueue_script( 'owl-carousel' );
wp_enqueue_script( 'yith_wc_product_slider' );

$query_args =   array(
    'posts_per_page' =>  $posts_per_page,
    'post_type'     =>  'product',
    'post_status'   =>  'publish',
);


if ( isset( $categories ) && !empty( $categories ) ){

    $query_args['product_cat']  =   $categories;
}

if( isset( $product_type ) && !empty( $product_type ) ){

    switch ( $product_type ){

        case 'on_sale'  :
            $product_ids_on_sale    = wc_get_product_ids_on_sale();
            $product_ids_on_sale[]  = 0;
            $query_args['post__in'] = $product_ids_on_sale;
            break;
        case 'best_seller'  :
            $query_args['meta_key'] = 'total_sales';
            $query_args['orderby']  = 'meta_value_num';
            $query_args['order']    =   'DESC';
            break;
        case 'last_ins' :
            $query_args['orderby']  =  'post_date';
            $query_args['order']    =   'DESC';
            break;
        case 'free'  :
            $query_args['meta_query'][] = array(
                'key'     => '_price',
                'value'   => 0,
                'compare' => '=',
                'type'    => 'DECIMAL',
            );

            break;
        case 'featured' :
            $query_args['meta_query']   = array();
            $query_args['meta_query'][] = array(
                'key'   => '_featured',
                'value' => 'yes'
            );
            break;

        case 'custom_select' :
            $product_ids    =   get_post_meta( $id, '_ywcps_products', true );

            if( !empty( $product_ids ) )
            {
                $query_args['post__in'] = $product_ids ;
                unset ( $query_args['product_cat'] );
            }
            break;
    }

    $order =    strtoupper ( $order );
    switch ( $order_by ) {


        case 'date':
            if ( !isset( $query_args['orderby'] ) ) {
                $query_args['orderby']  =  'post_date';
                $query_args['order']    =   $order;
            }
            break;

        case 'price' :

            if ( isset( $query_args['meta_query'] ) && !isset( $query_args['meta_query']['key'] ) &&  $query_args['meta_query']['key']!= '_price' ) {
                $query_args['meta_key'] = '_price';
                $query_args['orderby']  =  'meta_value_num';
                $query_args['order']    =  $order;
            }
            break;

        case 'name' :
            if ( !isset( $query_args['orderby'] ) ) {
                $query_args['orderby']  =  'post_title';
                $query_args['order']    =   $order;
            }
            break;
    }
}


$atts['query_args'] =   $query_args;

yit_plugin_get_template( YWCPS_DIR, 'product_slider_view_default.php', $atts, false );

?>
