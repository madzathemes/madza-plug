<?php
function space( $atts, $content = null ) {
	extract( shortcode_atts( array(
		'size' => '10',
		), $atts));
			$shortcode = '';
			$shortcode .= '<div class="clearfix" style="height:'.$size.'px"></div>';
			return $shortcode;
}
add_shortcode('space', 'space');
?>
