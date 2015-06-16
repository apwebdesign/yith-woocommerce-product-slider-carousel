<?php
if( !defined( 'ABSPATH' ) )
    exit;

if( !class_exists( 'YWCPS_Ajax_Category' ) ){

    class YWCPS_Ajax_Category{


        public static function output( $option ){

            $placeholder    =   isset( $option['placeholder'] ) ? $option['placeholder'] : '';
            $multiple       =   isset( $option['multiple'] ) ?  $option['multiple'] : 'false';

            $category_ids =  explode( ',', get_option( $option['id']  ) ) ;

            $json_ids   =   array();

            foreach( $category_ids as $category_id ){

                $cat_name   =   get_term_by( 'name', $category_id, 'product_cat' );
                if( !empty( $cat_name ) )
                   $json_ids[ $category_id ] = '#'.$cat_name->term_id.'-'.$cat_name->name;
            }

        ?>

            <tr valign="top">
                <th scope="row" class="titledesc">
                    <label for="<?php echo esc_attr( $option['id'] ); ?>"><?php echo esc_html( $option['title'] ); ?></label>
                </th>
                <td class="forminp forminp-<?php echo sanitize_title( $option['type'] ) ?>">
                    <input type="hidden" style="width:80%;" class="ywcps_enhanced_select" id="<?php echo esc_attr( $option['id'] );?>" name="<?php echo esc_attr( $option['id'] );?>" data-placeholder="<?php echo $placeholder; ?>" data-action="yith_json_search_product_categories" data-multiple="<?php echo $multiple;?>" data-selected="<?php echo esc_attr( json_encode( $json_ids ) ); ?>"
                           value="<?php echo implode( ',', array_keys( $json_ids ) ); ?>" />
                </td>
            </tr>
<?php
        }
    }
}