<?php

add_shortcode( 'mt_posts', 'mt_posts_func' );
	function mt_posts_func( $atts ) {

        extract(shortcode_atts(array(
            'title_type' => '',
            'title' => '',
            'category' => '',
            'orderby' => '',
            'type' => '',
						'tag' => '',
						'item_nr' => '',
            'offset' => '',
						'pagination' => '',
						'author' => '',
						'taxonomy' => '',
						'taxonomy_term' => '',
        ), $atts));

        $content_ = "[posts type='$type' taxonomy_term='$taxonomy_term' taxonomy='$taxonomy' author='$author' tag='$tag' item_nr='$item_nr' offset='$offset' orderby='$orderby' category='$category' title='$title' pagination='$pagination' title_type='$title_type']";

        return  do_shortcode($content_);

    }

add_action( 'vc_before_init', 'mt_posts_fields' );
function mt_posts_fields() {
  vc_map( array(
      "base"        => "mt_posts",
      "name"        => esc_html__("mt Posts", "magazin"),
      "class"        => "mt-posts",
      "icon"      => "",
      "category" => "mt Moduls",
      "params"    => array(


					array(
              "type" => "dropdown",
              "heading" => esc_html__("Type", "magazin"),
              "param_name" => "type",
							"std" => "",
              "value" => array('Small' => 'small', 'Small Two Columns' => 'small-two', 'Normal' => 'normal', 'Normal Two Columns' => 'normal-two', 'Normal Right Text' => 'normal-right', 'Normal Right Text Small' => 'normal-right-small', 'Carousel' => 'carousel-post-slider'),
          ),

					array(
							 "type" => "textfield",
							 "heading" => esc_html__("Intem Nr", "magazin"),
							 "param_name" => "item_nr",
							 "value" => "",
					 ),
					array(
               "type" => "textfield",
               "heading" => esc_html__("Offset", "magazin"),
               "param_name" => "offset",
               "value" => "",
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
                 "type" => "textfield",
                 "heading" => esc_html__("Taxonomy", "magazin"),
                 "param_name" => "taxonomy",
                 "value" => "",
            	),
						array(
                 "type" => "textfield",
                 "heading" => esc_html__("Taxonomy Term", "magazin"),
                 "param_name" => "taxonomy_term",
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
	              "param_name" => "title_type",
								"std" => "",
	              "value" => array('left' => 'left', 'center' => 'center', 'right' => 'right'),
	          ),
						array(
	              "type" => "dropdown",
	              "heading" => esc_html__("Pagination", "magazin"),
	              "param_name" => "pagination",
								"std" => "",
	              "value" => array('off' => 'off', 'on' => 'on'),
	          ),

      )
  ));
}
