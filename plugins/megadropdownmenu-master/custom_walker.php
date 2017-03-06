<?php
/**
	 * Custom Walker
	 *
	 * @access      public
	 * @since       1.0
	 * @return      void
	*/
class md_walker extends Walker_Nav_Menu {

	function start_lvl(&$output,  $depth = 0, $args= array()) {
		$indent        	= str_repeat( "\t", $depth );
		$class_names	= 'dropdown-menu';
		// build html
		$output .= "\n" . $indent . '<ul class="' . $class_names . '">' . "\n";
		// $output .= '<div><a href="#">Prev</a> | <a href="#">Next</a></div>';
	}

	function start_el(&$output, $item, $depth = 0, $args = array(), $id = 0) {

       	global $wp_query, $wpdb, $wpdb2;

       	$indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';

       	$class_names = $value = '';
       	$walkerObj = $args->walker;
       	$has_children_item_menu = $walkerObj->has_children;

       	$classes = empty( $item->classes ) ? array() : (array) $item->classes;

       	$classes[] = 'menu-item-' . $item->ID;

       	// $classes[] = ($has_children) ? 'dropdown' : '';

       	$classes[] = ($item->is_mega_menu == true) ? 'list_megamenu-'.$item->is_mega_menu : '';

        // $is_mega_menu = ($item->is_mega_menu == true) ? 'is_mega_menu' : 'is_not_mega_menu';

       	$class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item , $args) );
       	$class_names = ' class="'. esc_attr( $class_names ) . '"';

       	$id = apply_filters( 'nav_menu_item_id', 'menu-item-'. $item->ID, $item, $args );

       	$id = $id ? ' id="' . esc_attr( $id ) . '"' : '';

       	$output .= $indent . '<li' . $value . $class_names .'>';

       	$atts = array();

	   	$atts['title']  = ! empty( $item->attr_title ) ? $item->attr_title : '';
	   	$atts['target'] = ! empty( $item->target )     ? $item->target     : '';
	   	$atts['rel']    = ! empty( $item->xfn )        ? $item->xfn        : '';
	   	$atts['href']   = ! empty( $item->url )        ? $item->url        : '';
       	$atts = apply_filters( 'nav_menu_link_attributes', $atts, $item, $args );

       	$attributes = '';

        foreach ( $atts as $attr => $value ) {
            if ( ! empty( $value ) ) {
                $value = ( 'href' === $attr ) ? esc_url( $value ) : esc_attr( $value );
                $attributes .= ' ' . $attr . '="' . $value . '"';
            }
        }

        $item_output =  $args->before;

        if($item->is_mega_menu == null){
        	$item_output .= '<a'. $attributes .' class="intar">';

        }
        // $item_output .= $args->link_before .$prepend.apply_filters( 'the_title', $item->title, $item->ID ).$append;

         /** This filter is documented in wp-includes/post-template.php */
        $item_output .= $args->link_before . apply_filters( 'the_title', $item->title, $item->ID ) . $args->link_after;

        // $item_output .= $description.$args->link_after;
        // wp prepare ..
        // $f_metaid = "meta_id";
        // $tb_postmeta = $wpdb->prefix."wp_postmeta";

        // $has_children_item_menu = $wpdb->get_var(
        //                     $wpdb->prepare(
        //                         "SELECT COUNT(meta_id)
        //                         FROM wp_postmeta
        //                         WHERE meta_key='_menu_item_menu_item_parent'
        //                         AND meta_value= %d ",
        //                         $item->ID
        //                     )
        //                 );
        if(($depth == 0 && $has_children_item_menu > 0) ){
        	$item_output .= '&nbsp;<span class="caret megamenu-'.$item->is_mega_menu.' depth-'.$depth.' child-'.$has_children_item_menu.'"></span>';
        }

        // if( ($depth == 0 && $item->is_mega_menu == '1') ){
        //     $item_output .= '&nbsp;<span class="caret megamenu-'.$item->is_mega_menu.' depth-'.$depth.' child-'.$has_children_item_menu.'"></span>';
        // }

        if ($item->is_mega_menu == null) {
            $item_output .= '</a>';
        }

        $item_output .= $args->after;


        $output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
    }

    // function display_element( $element, &$children_elements, $max_depth, $depth=0, $args, &$output ) {
    //     $id_field = $this->db_fields['id'];
    //     if ( !empty( $children_elements[ $element->$id_field ] ) ) {
    //         $element->classes[] = 'themeslug-menu-item-parent';
    //     }
    //     Walker_Nav_Menu::display_element( $element, $children_elements, $max_depth, $depth, $args, $output );
    // }

}
