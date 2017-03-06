<?php

add_shortcode( 'mt_subscribe', 'mt_subscribe_func' );
	function mt_subscribe_func( $atts ) {

        extract(shortcode_atts(array(
            'type' => 'center',
            'position' => ''
        ), $atts));

        $content_ = "[subscribe]";

        return  do_shortcode($content_);

    }

add_action( 'vc_before_init', 'mt_subscribe_fields' );
function mt_subscribe_fields() {
  vc_map( array(
      "base"        => "mt_subscribe",
      "name"        => esc_html__("mt Subscribe Form", "magazin"),
      "class"        => "mt-subscribe",
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
