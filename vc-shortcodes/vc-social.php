<?php

add_shortcode( 'mt_social', 'mt_social_func' );
	function mt_social_func( $atts ) {

        extract(shortcode_atts(array(
            'title' => esc_html__( 'Follow Us And get latest news', 'magazin' ),
        ), $atts));

        $content_ = "[social title='$title' ]";

        return  do_shortcode($content_);

    }

add_action( 'vc_before_init', 'mt_social_fields' );
function mt_social_fields() {
  vc_map( array(
      "base"        => "mt_social",
      "name"        => esc_html__("mt Social", "magazin"),
      "class"        => "mt-social",
      "icon"      => "",
      "category" => "mt Moduls",
			"params"    => array(
        array(
             "type" => "textfield",
             "heading" => esc_html__("Title", "magazin"),
             "param_name" => "title",
             "value" => "",
         ),
				)

  ));
}
