<?php

add_shortcode( 'mt_grid', 'mt_grid_func' );
	function mt_grid_func( $atts ) {

        extract(shortcode_atts(array(
            'position' => '',
            'title' => '',
            'category' => '',
            'orderby' => '',
            'type' => '',
						'tag' => '',
            'offset' => '',
						'author' => '',
        ), $atts));

        $content_ = "[grid type='$type' author='$author' tag='$tag' title='$title' position='$position' offset='$offset' orderby='$orderby' category='$category']";

        return  do_shortcode($content_);

    }

add_action( 'vc_before_init', 'mt_grid_fields' );
function mt_grid_fields() {
  vc_map( array(
      "base"        => "mt_grid",
      "name"        => esc_html__("mt Post Grid", "magazin"),
      "class"        => "mt-grid",
      "icon"      => "",
      "category" => "mt Moduls",
      "params"    => array(

      	 array(
              "type" => "textfield",
              "heading" => esc_html__("Offset", "magazin"),
              "param_name" => "offset",
              "value" => "",
          ),
					array(
              "type" => "dropdown",
              "heading" => esc_html__("Type", "magazin"),
              "param_name" => "type",
							"std" => "",
              "value" => array('Style 1' => '1', 'Style 2' => '2', 'Style 3' => '3'),
          ),
          array(
               "type" => "textfield",
               "heading" => esc_html__("Category slug", "magazin"),
               "param_name" => "category",
               "value" => "",
           ),
					 array(
                "type" => "textfield",
                "heading" => esc_html__("Tag slug", "magazin"),
                "param_name" => "tag",
                "value" => "",
            ),
						array(
                 "type" => "textfield",
                 "heading" => esc_html__("Author slug", "magazin"),
                 "param_name" => "author",
                 "value" => "",
            	),
          array(
              "type" => "dropdown",
              "heading" => esc_html__("OrderBy", "magazin"),
              "param_name" => "orderby",
							"std" => "",
              "value" => array('Date' => 'date', 'Most Viewed' => 'popular', 'Most Shares' => 'shares', 'Most Comments' => 'comment_count', 'Random' => 'rand', 'Title' => 'title'),
          ),
					array(
	             "type" => "textfield",
	             "heading" => esc_html__("Title", "magazin"),
	             "param_name" => "title",
	             "value" => "",
	         ),
					array(
              "type" => "dropdown",
              "heading" => esc_html__("Title Position", "magazin"),
              "param_name" => "position",
							"std" => "",
              "value" => array('left' => 'left', 'center' => 'center', 'right' => 'right'),
          ),

      )
  ));
}
