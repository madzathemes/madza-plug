<?php
function subscribe( $atts, $content = null ) {
	extract( shortcode_atts( array(
		'position' => 'center',
		'type' => 'custom-ad-1',
		), $atts));

			$shortcode = '';
			$shortcode .= '<div class="letter-wrap">
        <div class="gt_newpost mt-radius">
          <div class="form-overlay"></div>
          <form method="post" target="popupwindow" action="https://www.specificfeeds.com/follow?pub=7TqNP3vbLCHPZ32iTs3xu6gzzHWHxDTV">
          	<h3>'. esc_html("Get the best viral stories straight into your inbox!", 'magazine-plug').'</h3>
          	<input type="text" name="email" placeholder="'. esc_html("Your email adress", 'magazine-plug') .'" required>
          	<input type="submit" value="'. esc_html("Sign Up", 'magazine-plug') .'" name="subscribe">
          	<small class="color-silver-light">'. esc_html("Don't worry, we don't spam", 'magazine-plug') .'</small>
          </form>
        </div>
      </div>';
			return $shortcode;
}
add_shortcode('subscribe', 'subscribe'); ?>
