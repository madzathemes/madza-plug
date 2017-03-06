<?php

add_shortcode( 'mt_ads', 'mt_ads_func' );
	function mt_ads_func( $atts ) {

        extract(shortcode_atts(array(
            'type' => 'center',
            'position' => ''
        ), $atts));

        $content_ = "[ad type='$type' position='$position']";

        return  do_shortcode($content_);

    }

add_action( 'vc_before_init', 'mt_ads_fields' );
function mt_ads_fields() {
  vc_map( array(
      "base"        => "mt_ads",
      "name"        => esc_html__("mt Ads", "magazin"),
      "class"        => "mt-ads",
      "icon"      => "",
      "category" => "mt Moduls",
      "params"    => array(

          array(
              "type" => "dropdown",
              "heading" => esc_html__("Type", "magazin"),
              "param_name" => "type",
							"std" => "",
              "value" => array(
								'Custom ad 1' => 'custom-ad-1',
								'Custom ad 2' => 'custom-ad-2',
								'Custom ad 3' => 'custom-ad-3',
								'Custom ad 4' => 'custom-ad-4',
								'Custom ad 5' => 'custom-ad-5',
								'Custom ad 6' => 'custom-ad-6',
								'Custom ad 7' => 'custom-ad-7',
								'Custom ad 8' => 'custom-ad-8',
								'Custom ad 9' => 'custom-ad-9',
								'Sidebar top ad' => 'sidebar-ad-top',
								'Sidebar middle ad' => 'sidebar-ad-middle',
								'Sidebar bottom ad' => 'sidebar-ad-bottom',
								'Article top ad' => 'article-ad-top',
								'Article bottom ad' => 'article-ad-bottom',
								'Footer top ad' => 'footer-ad-top',
							),
          ),
          array(
              "type" => "dropdown",
              "heading" => esc_html__("Position", "magazin"),
              "param_name" => "position",
							"std" => "",
              "value" => array('right' => 'right', 'left' => 'left', 'center' => 'center'),
          )

      )
  ));
}
