<?php
if( !defined( 'ABSPATH' ) ){
    exit;
}
?>
<?php

global $wpdb, $woocommerce, $woocommerce_loop;

$hide_cart  =   isset( $hide_add_to_cart ) ? $hide_add_to_cart :    false;
$hideprice  =    isset( $hide_price ) ? $hide_price :    false;
$products = new WP_Query( $query_args );

$i = 0;
$cols = '';

$priorities    =   array(
    'hide_cart'     =>  -1,
    'hide_price'    =>  -1
);

if( $hide_cart )
{
    $priorities['hide_cart'] = has_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart' );

    if( $priorities['hide_cart'] != false )
    {
        remove_action( 'woocommerce_template_loop_add_to_cart', $priorities['hide_cart'] );
        add_filter( 'woocommerce_loop_add_to_cart_link', '__return_empty_string', 10 );
    }

}

if( $hideprice ){

    $priorities['hide_price'] = has_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price' );

    if( $priorities['hide_price'] != false )
    {
        remove_action( 'woocommerce_template_loop_price', $priorities['hide_price'] );
        add_filter( 'woocommerce_get_price_html', '__return_empty_string', 10 );

    }
}


ob_start();

if ( $products->have_posts() ) :
    echo '<div class="woocommerce">';
    if( $show_title )
        echo    '<h3>'.$title.'</h3>';
    echo '<div class="ywcps-wrapper" data-columns="%columns%" data-en_responsive="'.$en_responsive.'" data-n_item_desk_small="'.$n_item_desk_small.'" data-n_item_tablet="'.$n_item_tablet.'" data-n_item_mobile="'.$n_item_mobile.'"';
    echo   'data-n_items="'.$n_items.'" data-is_loop="'.$is_loop.'" data-pag_speed="'.$page_speed.'" data-auto_play="'.$auto_play.'" data-stop_hov="'.$stop_hov.'" data-show_nav="'.$show_nav.'"';
    echo   'data-en_rtl="'.$is_rtl.'" data-anim_in="'.$anim_in.'" data-anim_out="'.$anim_out.'" data-anim_speed="'.$anim_speed.'" data-show_dot_nav="'.$show_dot_nav.'">';
    echo '<div class="ywcps-slider">';
    echo '<div class="row">';
    echo'<ul class="products ywcps_products_slider">';
    while ( $products->have_posts() ) : $products->the_post();
        wc_get_template( 'content-product.php');
        $i ++;
        $cols = ( isset($woocommerce_loop['columns']) ) ? $woocommerce_loop['columns'] : 6; //fix $woocommerce_loop['columns'] empty
    endwhile; // end of the loop.
    echo '</ul></div></div>';
    echo '<div class="ywcps-nav">';
    echo '<div id="nav_prev_def_free" class="ywcps-nav-prev"><span id="default_prev"></span></div>';
    echo '<div id="nav_next_def_free" class="ywcps-nav-next"><span id="default_next"></span></div>';
    echo '</div></div><div class="es-carousel-clear"></div>';
    echo '</div>';
endif;

if( $hide_cart && $priorities['hide_cart'] != false )
{
    add_action( 'woocommerce_template_loop_add_to_cart', $priorities['hide_cart'] );
    remove_filter( 'woocommerce_loop_add_to_cart_link', '__return_empty_string', 10 );
}

if ( $hideprice && $priorities['hide_price'] != false ) {
    add_action( 'woocommerce_template_loop_price', $priorities['hide_price'] );
    remove_filter( 'woocommerce_get_price_html', '__return_empty_string', 10 );
}

$content = ob_get_clean();

echo str_replace( '%columns%', $cols, $content );

wp_reset_query();


?>
