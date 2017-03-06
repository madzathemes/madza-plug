<?php
function ad( $atts, $content = null ) {
	extract( shortcode_atts( array(
		'position' => 'center',
		'type' => 'custom-ad-1',
		), $atts));

		$options = get_option("magazin_theme_options");
		$allowed_html = array('ins' => array( 'class' => array(), 'style' => array(),'data-ad-client' => array(),'data-ad-slot' => array(),'data-ad-format' => array()), 'iframe' => array( 'id' => array(),'name' => array(),'src' => array(),'style' => array(),'scrolling' => array(),'frameborder' => array()), 'script' => array( 'async' => array(), 'type' => array(),'src' => array()), 'noscript' => array(), 'small' => array( 'class' => array()), 'img' => array( 'src' => array(), 'alt' => array(), 'class' => array(), 'width' => array(), 'height' => array() ), 'a' => array( 'href' => array(), 'title' => array() ), 'br' => array(), 'i' => array('class' => array()),  'em' => array(), 'strong' => array(), 'div' => array('class' => array()), 'span' => array('class' => array()));

			$shortcode = '';
			$shortcode .= '<div itemscope itemtype="https://schema.org/WPAdBlock" class="advertise text-'.$position.'">';

				if($type=="custom-ad-1") { if(!empty($options['custom_ad_1'])){ $shortcode .= html_entity_decode($options['custom_ad_1']); }}
				if($type=="custom-ad-2") { if(!empty($options['custom_ad_2'])){ $shortcode .= html_entity_decode($options['custom_ad_2']); }}
				if($type=="custom-ad-3") { if(!empty($options['custom_ad_3'])){ $shortcode .= html_entity_decode($options['custom_ad_3']); }}
				if($type=="custom-ad-4") { if(!empty($options['custom_ad_4'])){ $shortcode .= html_entity_decode($options['custom_ad_4']); }}
				if($type=="custom-ad-5") { if(!empty($options['custom_ad_5'])){ $shortcode .= html_entity_decode($options['custom_ad_5']); }}
				if($type=="custom-ad-6") { if(!empty($options['custom_ad_6'])){ $shortcode .= html_entity_decode($options['custom_ad_6']); }}
				if($type=="custom-ad-7") { if(!empty($options['custom_ad_7'])){ $shortcode .= html_entity_decode($options['custom_ad_7']); }}
				if($type=="custom-ad-8") { if(!empty($options['custom_ad_8'])){ $shortcode .= html_entity_decode($options['custom_ad_8']); }}
				if($type=="custom-ad-9") { if(!empty($options['custom_ad_9'])){ $shortcode .= html_entity_decode($options['custom_ad_9']); }}
				if($type=="sidebar-ad-top") { if(!empty($options['sidebar_ad_top'])){ $shortcode .= html_entity_decode($options['sidebar_ad_top']); }}
				if($type=="sidebar-ad-middle") { if(!empty($options['sidebar_ad_middle'])){ $shortcode .= html_entity_decode($options['sidebar_ad_middle']); }}
				if($type=="sidebar-ad-bottom") { if(!empty($options['sidebar_ad_bottom'])){ $shortcode .= html_entity_decode($options['sidebar_ad_bottom']); }}
				if($type=="article-ad-bottom") { if(!empty($options['article_ad_bottom'])){ $shortcode .= html_entity_decode($options['article_ad_bottom']); }}
				if($type=="footer-ad-top") { if(!empty($options['footer_ad_top'])){ $shortcode .= html_entity_decode($options['footer_ad_top']); }}

			$shortcode .= '</div>';
			return $shortcode;
}
add_shortcode('ad', 'ad');
?>
