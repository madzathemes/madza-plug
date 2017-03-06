<?php
function social( $atts, $content = null ) {
	extract( shortcode_atts( array(
		'title' => ''. esc_html__( 'Follow Us', 'magazine-plug'  ) .'',
		), $atts));

			$facebook_name = get_option("facebook_username");
			$facebook_token = get_option("facebook_token");
			$twitter_name = get_option("twitter_username");
			$youtube_name = get_option("youtube_username");

			$shortcode = '';
			$shortcode .= '<div class="socials">';
				$shortcode .= '<h2 class="heading"><span>'.$title.'</span></h2>';
				if(!empty($facebook_name)){ $shortcode .= '<a target="_blank" href="https://www.facebook.com/'.$facebook_name.'" class="social-facebook mt-radius"><span class="social-count"></span><span class="social-text">'. esc_html__( 'Follow us on', 'magazine-plug'  ) .' <strong>Facebook</strong></span></a>'; }
				if(!empty($twitter_name)){ $shortcode .= '<a target="_blank" href="https://twitter.com/'.$twitter_name.'" class="social-twitter mt-radius"><span class="social-count"></span><span class="social-text">'. esc_html__( 'Follow us on', 'magazine-plug'  ) .' <strong>Twitter</strong></span></a>'; }
				if(!empty($youtube_name)){ $shortcode .= '<a target="_blank" href="https://www.youtube.com/'.$youtube_name.'" class="social-subscribe mt-radius"><span class="social-count"></span><span class="social-text">'. esc_html__( 'Subscribe us on', 'magazine-plug'  ) .' <strong>YouTube</strong></span></a>'; }
				$shortcode .= '<div class="clear"></div>';

			$shortcode .= '</div>';
			return $shortcode;
}
add_shortcode('social', 'social');
?>
