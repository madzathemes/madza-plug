<?php
function share( $atts, $content = null ) {
  $url = wp_get_attachment_url( get_post_thumbnail_id(get_the_ID()) );
  $shortcode = '';
	$shortcode .= '<div class="single-share">' . apply_filters('the_content', $content);
    $shortcode .= '<div class="single-share-socials mt-radius-b">';
      $shortcode .= '<a href="http://www.facebook.com/sharer.php?u='. get_the_permalink() .'" target="_blank"><div class="facebook mt-radius-b"></div></a>';
      $shortcode .= '<a href="http://twitter.com/home/?status='. get_the_title().' - '. get_the_permalink() .'" target="_blank"><div class="twiiter mt-radius-b"></div></a>';
      $shortcode .= '<a href="https://plus.google.com/share?url='. get_the_permalink() .'" target="_blank"><div class="google mt-radius-b"></div></a>';
      $shortcode .= '<a href="http://pinterest.com/pin/create/button/?url='. get_the_permalink() .'&media='.  $url .'" target="_blank"><div class="pinterest mt-radius-b"></div></a>';
    $shortcode .= '</div>';
  $shortcode .= '</div>';
	return $shortcode;
}
add_shortcode('share', 'share');
?>
