<?php
/*
Plugin Name: Madza Plug
Plugin URI: https://madzathemes.net
Description: Madza Plug Plugin
Author: Madars Bitenieks
Version: 1.1
Author URI: https://madzathemes.net
*/
include_once ('madza-metabox.php');
include_once ('plugins/easy-google-fonts/easy-google-fonts.php');
include_once ('plugins/megadropdownmenu-master/megadropdown.php');
include_once ('plugins/cmb2/jw-cmb2-rgba-colorpicker.php');
if (class_exists('WPBakeryShortCode')) {
	include_once ('vc-shortcodes/vc-posts-tabs.php');
	include_once ('vc-shortcodes/vc-ads.php');
	include_once ('vc-shortcodes/vc-subscribe.php');
	include_once ('vc-shortcodes/vc-social.php');
	include_once ('vc-shortcodes/vc-grid.php');
	include_once ('vc-shortcodes/vc-posts.php');
}
include_once ('shortcodes/s-ads.php');
include_once ('shortcodes/s-posts.php');
include_once ('shortcodes/s-posts-tabs.php');
include_once ('shortcodes/s-trending.php');
include_once ('shortcodes/s-space.php');
include_once ('shortcodes/s-social.php');
include_once ('shortcodes/s-share.php');
include_once ('shortcodes/s-subscribe.php');
include_once ('shortcodes/s-grid.php');

include_once ('widgets/w-ads.php');
include_once ('widgets/w-posts.php');
include_once ('widgets/w-posts-tabs.php');
include_once ('widgets/w-space.php');
include_once ('widgets/w-social.php');
include_once ('widgets/w-subscribe.php');
include_once ('widgets/w-grid.php');
include_once ('widgets/w-trending.php');

include_once ('customizer/customizer-general.php');
include_once ('customizer/customizer-ads.php');
include_once ('customizer/customizer-posts.php');
include_once ('example-functions.php');
include_once ('plugins/kirki/kirki.php');
add_filter('widget_text', 'do_shortcode');

function magazin_text_domain() {
	load_plugin_textdomain( 'magazine-plug', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
}
add_action( 'plugins_loaded', 'magazin_text_domain' );

add_action('init','magazin_random_add_rewrite');
function magazin_random_add_rewrite() {
       global $wp;
       $wp->add_query_var('random');
       add_rewrite_rule('random/?$', 'index.php?random=1', 'top');
}

add_action('template_redirect','magazin_random_template');
function magazin_random_template() {
       if (get_query_var('random') == 1) {
               $posts = get_posts('post_type=post&orderby=rand&numberposts=1');
               foreach($posts as $post) {
                       $link = get_permalink($post);
               }
               wp_redirect($link,307);
               exit;
       }
}

function magazin_theme_setup() {

	add_image_size( 'magazin_430', 430, 240, true);
	add_image_size( 'magazin_585', 585, 285, true);
	add_image_size( 'magazin_550', 550, 550, false );
	add_image_size( 'magazin_480', 520, 520, false );
	add_image_size( 'magazin_625', 625, 625, false );
	add_image_size( 'magazin_100', 100, 68, true );
	add_image_size( 'madza_920', 920, 999, true );

}

add_action( 'after_setup_theme', 'magazin_theme_setup' );

function magazin_header_hooks() {

	if ( is_singular() ) {

	wp_enqueue_script( "comment-reply" ); ?>

	<?php include_once( ABSPATH . 'wp-admin/includes/plugin.php' ); if ( !is_plugin_active( 'wordpress-seo/wp-seo.php' ) ) { ?>
	<?php global $post;

	$option = get_option("magazin_option");

	$excerpt = apply_filters('get_the_excerpt', get_post_field('post_excerpt', $post->ID));
	$excerpt_ = magazin_custom_excerpts(27);
	if (!empty($option['post_meta_excerpt'])) {
		if($option['post_meta_excerpt']==3){
			$excerpt = get_post_meta($post->ID, "magazin_excerpt", true);
			if (!empty($excerpt)) { $excerpt_ = $excerpt; }
		}
		else if($option['post_meta_excerpt']==4){
			$excerpt = get_post_meta($post->ID, "magazin_subtitle", true);
			if (!empty($excerpt)) { $excerpt_ = $excerpt; }
		}

	}


	$excerpt_count = "55";
	$excerpt_count_option = get_option("magazin_facebook_description");

	if(!empty($excerpt_count_option)) {
			$excerpt_count = $excerpt_count_option;
	}

	if ( $excerpt_ == '' ) {
	    $excerpt_ = wp_trim_words( $post->post_content, $excerpt_count );
	} ?>

	  <meta property="og:url"           content="<?php the_permalink();?>" />
		<meta property="og:type"          content="<?php wp_title();?>" />
		<meta property="og:title"         content="<?php the_title();?>" />
		<meta property="og:description"   content="<?php echo esc_html( $excerpt_ ); ?>" />
		<meta property="og:image"         content="<?php  if ( has_post_thumbnail() ) { the_post_thumbnail_url(); } ?>" />
	<?php } } ?>
	<style type="text/css"><?php echo balanceTags(get_option("custom_css")); ?></style>
	<?php
}

add_action('wp_head', 'magazin_header_hooks');

function mt_header_script() {
		$autoplay = get_option("carousel_autoplay");
		$options = get_option("sticky_sidebar");
		wp_enqueue_script('mt-effects', get_template_directory_uri() . '/inc/js/effects.js', array('jquery'), '1.0', true);
		if(is_rtl()){ wp_add_inline_script( 'mt-effects', 'var $rtl = true;', 'before' ); } else { wp_add_inline_script( 'mt-effects', 'var $rtl = false;', 'before' ); }
		if(!empty($autoplay)){ if($autoplay=="1"){ wp_add_inline_script( 'mt-effects', 'var $autoplay = true;', 'before' ); } else { wp_add_inline_script( 'mt-effects', 'var $autoplay = false;', 'before' ); } } else { wp_add_inline_script( 'mt-effects', 'var $autoplay = false;', 'before' ); }
		if(!empty($options)){ if($options=="1"){ wp_add_inline_script( 'mt-effects', 'jQuery(document).ready(function() {jQuery(".sidebar, .panel-grid-cell").theiaStickySidebar({additionalMarginTop: 29,	minWidth: 1200});});', 'after' ); } } else { wp_add_inline_script( 'mt-effects', 'jQuery(document).ready(function() {jQuery(".sidebar, .panel-grid-cell").theiaStickySidebar({additionalMarginTop: 29,	minWidth: 1200});});', 'after' ); }
		wp_enqueue_script( 'mt-defer', get_template_directory_uri(). '/inc/js/defer.js', array( 'jquery'),  '1.0', true );
		if ( true == get_theme_mod( 'mt_header_time', false ) ) {
			wp_add_inline_script( 'mt-defer', '
			var today = new Date();
			var h = today.getHours();
			function startTime() {
			    var today = new Date();
			    var m = today.getMinutes();
			    var s = today.getSeconds();
			    m = checkTime(m);
			    s = checkTime(s);
			    document.getElementById("time-live").innerHTML =
			    h + ":" + m + "<span>:" + s + "</span>";
			    var t = setTimeout(function(){requestAnimationFrame(startTime)}, 1000);
			}
			function checkTime(i) { if (i < 10) {i = "0" + i};   return i; }
			', 'before' );
			wp_add_inline_script( 'mt-defer', 'window.onload=startTime; ', 'after' );
		}


}
add_action('wp_enqueue_scripts', 'mt_header_script');



function magazin_custom_excerpts($limit) {
    return wp_trim_words(get_the_content(), $limit);
}

function html_sanitize_text( $input ) {
    return wp_kses_post( force_balance_tags( $input ) );
}

/*-----------------------------------------------------------------------------------*/
/* Magazin Framework post views function
/*-----------------------------------------------------------------------------------*/
function magazin_PostViews($post_ID) {

    //Set the name of the Posts Custom Field.
    $count_key = 'magazin_post_views_count';

    //Returns values of the custom field with the specified key from the specified post.
    $count = get_post_meta($post_ID, $count_key, true);

    //If the the Post Custom Field value is empty.
    if($count == ''){
        $count = 0; // set the counter to zero.

        //Delete all custom fields with the specified key from the specified post.
        delete_post_meta($post_ID, $count_key);

        //Add a custom (meta) field (Name/value)to the specified post.
        add_post_meta($post_ID, $count_key, '0');
        return $count . '';

    //If the the Post Custom Field value is NOT empty.
    }else{
        $count++; //increment the counter by 1.
        //Update the value of an existing meta key (custom field) for the specified post.
        update_post_meta($post_ID, $count_key, $count);

        //If statement, is just to have the singular form 'View' for the value '1'
        if($count == '1'){
        return $count . '';
        }
        //In all other cases return (count) Views
        else {
        return $count . '';
        }
    }
}

function magazin_custom_oembed_filter($html, $url, $attr, $post_ID) {
		$return = "";
    $return .='<div class="single-share">';
			$return .='<div class="video-wrap">';
				$return .='<div class="video-container">';
					$return .='<div class="single-share-socials mt-radius-b">';
						$return .='<a href="http://www.facebook.com/sharer.php?u='. get_the_permalink() .'" target="_blank"><div class="facebook mt-radius-b"></div></a>';
						$return .='<a href="http://twitter.com/home/?status='. get_the_title() .' - '.  get_the_permalink() .'" target="_blank"><div class="twiiter mt-radius-b"></div></a>';
						$return .='<a href="https://plus.google.com/share?url='. get_the_permalink() .'" target="_blank"><div class="google mt-radius-b"></div></a>';
					$return .='<a href="http://pinterest.com/pin/create/button/?url='. get_the_permalink() .'&media='. esc_url($url) .'" target="_blank"><div class="pinterest mt-radius-b"></div></a>';
				$return .='</div>'.$html.'</div>';
			$return .='</div>';
		$return .='</div>';
    return $return;
}
add_filter( 'embed_oembed_html', 'magazin_custom_oembed_filter', 10, 4 ) ;



add_filter('body_class','magazin_class');
function magazin_class($classes) {

	$body_class = "";

	$title = get_post_meta(get_the_ID(), "magazin_page_title", true);
	if(!empty($title) and !is_search()){
		$body_class .= 'remove-title';
	}

	$radius_option = get_option("radius");

	$colors_option = get_option("colors");

	$zoom_option = get_option("zoom");
	$zoom = "zoom-on";
	if(!empty($zoom_option)) {
		if($zoom_option=="off"){ $zoom = "zoom-off"; }
		else if($zoom_option=="on"){ $zoom = "zoom-on"; }
	}

	$colors = "mt-color-1";
	if(!empty($colors_option)) {
		if($colors_option=="color2"){
			$colors = "mt-color-2";
		}
	}

	$radius = "mt-radius-25";
	if(!empty($radius_option)) {
		if($radius_option=="0px"){
			$radius = "mt-radius-0";
		} else
		if($radius_option=="5px"){
			$radius = "mt-radius-5";
		}
	}

	// Post meta
	if ( false == get_theme_mod( 'mt_post_meta_author', true ) ) {
		$body_class .=' remove-pl-author ';
	}
	if ( false == get_theme_mod( 'mt_post_meta_date', true ) ) {
		$body_class .=' remove-pl-date ';
	}
	if ( 4 == get_theme_mod( 'mt_post_meta_cat', 1 ) ) {
		$body_class .=' remove-pl-cat ';
	}
	if ( false == get_theme_mod( 'mt_post_meta_author_post', true ) ) {
		$body_class .=' remove-ps-author ';
	}
	if ( false == get_theme_mod( 'mt_post_meta_author_post_img', true ) ) {
		$body_class .=' remove-ps-author-img ';
	}
	if ( false == get_theme_mod( 'mt_post_meta_date_post', true ) ) {
		$body_class .=' remove-ps-date ';
	}
	if ( false == get_theme_mod( 'mt_post_meta_view_post', true ) ) {
		$body_class .=' remove-ps-view ';
	}
	if ( false == get_theme_mod( 'mt_post_meta_share_post', true ) ) {
		$body_class .=' remove-ps-share ';
	}

	if ( true == get_theme_mod( 'mt_menu_full', true ) ) {
		$body_class .=' mt-menu-full ';
	}


	$body_class .= ' '.$zoom.' '.$radius.' '.$colors;
	$classes[] =  $body_class;
	return $classes;
}

function admin_js() {
    if ( is_admin() ) {
			wp_enqueue_script('magazin-admin', get_template_directory_uri() . '/inc/js/admin.js', array('jquery'), '1.0', true);
    }
}
add_action('admin_footer', 'admin_js');

function magazin_get_shares( $post_id ) {
	$cache_key = 'magazin_share_cache' . $post_id;
	$access_token = 'APP_ID|APP_SECRET';
	$count = get_transient( $cache_key ); // try to get value from Wordpress cache

	$facebook_token = get_option("facebook_token");
	$share_time = get_option("share_time");

	if(!empty( $share_time )){ $share_times = $share_time; } else { $share_times = 36000;  }

	if(!empty( $facebook_token )){
		// if no value in the cache
		if ( $count === false  ) {
			$count = "0";
			$response = wp_remote_get('https://graph.facebook.com/v2.7/?id=' . urlencode( get_permalink( $post_id ) ) . '&access_token=' . $facebook_token);
			if (!empty($response)) {
				$body = json_decode( $response['body'], true );
			}

			if (!empty($body->share)) {
	      $count = intval( $body->share->share_count );
	    }

			update_post_meta($post_id, 'magazin_share_count_real', $count);

			set_transient( $cache_key, $count, $share_times ); // store value in cache for a 10 hour

		}
	}
	return $count;
}

function SearchFilter($query) {

	if (!is_admin()) {

		if ($query->is_search) {

			$query->set('post_type', 'post');

		}

		return $query;

	}
}

add_filter('pre_get_posts','SearchFilter');

function wpsites_exclude_latest_post($query) {
	if ($query->is_category() && $query->is_main_query()) {
		$query->set( 'offset', '1' );
	}
}

add_action('pre_get_posts', 'wpsites_exclude_latest_post');

add_action('pre_get_posts', 'myprefix_query_offset', 1 );
function myprefix_query_offset(&$query) {

    //Before anything else, make sure this is the right query...
    if ( ! $query->is_category() ) {
        return;
    }

    $offset = 4;
    $option = get_option("magazin_theme_options");
    if(!empty($option['category_grid_style'])) {
    	if($option['category_grid_style']=="1"){
    		$offset = 0;
    	} else if($option['category_grid_style']=="2"){
    		$offset = 2;
    	} else if($option['category_grid_style']=="3"){
    		$offset = 3;
    	}
    }

    $default_posts_per_page = get_option( 'posts_per_page' );

    //First, define your desired offset...
    $offset = $offset;

    //Next, determine how many posts per page you want (we'll use WordPress's settings)
    $ppp = $default_posts_per_page;

    //Next, detect and handle pagination...
    if ( $query->is_paged ) {

        //Manually determine page query offset (offset + current page (minus one) x posts per page)
        $page_offset = $offset + ( ($query->query_vars['paged']-1) * $ppp );

        //Apply adjust page offset
        $query->set('offset', $page_offset );

    }
}

add_filter('found_posts', 'myprefix_adjust_offset_pagination', 1, 2 );
function myprefix_adjust_offset_pagination($found_posts, $query) {

    //Define our offset again...
		$offset = 4;
    $option = get_option("magazin_theme_options");
    if(!empty($option['category_grid_style'])) {
    	if($option['category_grid_style']=="1"){
    		$offset = 0;
    	} else if($option['category_grid_style']=="2"){
    		$offset = 2;
    	} else if($option['category_grid_style']=="3"){
    		$offset = 3;
    	}
    }

    //Ensure we're modifying the right query object...
    if ( $query->is_category() ) {
        //Reduce WordPress's found_posts count by the offset...
        return $found_posts - $offset;
    }
    return $found_posts;
}

function more_post_ajax(){

    $ppp = (isset($_POST["ppp"])) ? $_POST["ppp"] : 3;
		$format = (isset($_POST['format'])) ? $_POST['format'] : "all";
		$category = (isset($_POST['category'])) ? $_POST['category'] : "";
		$tag = (isset($_POST['tag'])) ? $_POST['tag'] : "";
		$offset = (isset($_POST['offset'])) ? $_POST['offset'] : "";
		$orderby = (isset($_POST['orderby'])) ? $_POST['orderby'] : "";
		$author = (isset($_POST['author'])) ? $_POST['author'] : "";

		$meta_key = "";

		if($orderby=="popular") { $meta_key = "magazin_post_views_count"; $orderby = "meta_value_num"; }
		if($orderby=="shares") { $meta_key = "meta_value_num"; $orderby = "magazin_share_count_real"; }

		$args = array(
        'suppress_filters' => true,
        'post_type' => 'post',
				'post_status' => 'publish',
        'posts_per_page' => $ppp,
				'category_name'=>$category,
				'tag'=>$tag,
				'author_name'=>$author,
				'orderby'=> $orderby,
				'meta_key' => $meta_key,
				'offset' => $offset,
    );
		if($format=="gallery") {
			$args = array(
	        'suppress_filters' => true,
	        'post_type' => 'post',
					'post_status' => 'publish',
	        'posts_per_page' => $ppp,
					'category_name'=>$category,
					'tag'=>$tag,
					'author_name'=>$author,
					'offset' => $offset,
					'orderby'=> $orderby,
					'meta_key' => $meta_key,
					'tax_query' => array(
							array(
								'taxonomy' => 'post_format',
								'field'    => 'slug',
								'terms' => array( 'post-format-gallery' ),
							),
						),
	    );
		}

		if($format=="posts") {
			$args = array(
	        'suppress_filters' => true,
	        'post_type' => 'post',
					'post_status' => 'publish',
	        'posts_per_page' => $ppp,
					'category_name'=>$category,
					'offset' => $offset,
					'author_name'=>$author,
					'orderby'=> $orderby,
					'tag'=>$tag,
					'meta_key' => $meta_key,
					'tax_query' => array(
						array(
							'taxonomy' => 'post_format',
							'field'    => 'slug',
							'terms' => array( 'post-format-gallery', 'post-format-video' ),
							'operator' => 'NOT IN'
						),
					),
	    );
		}

		if($format=="video") {
			$args = array(
	        'suppress_filters' => true,
	        'post_type' => 'post',
					'post_status' => 'publish',
	        'posts_per_page' => $ppp,
					'category_name'=>$category,
					'offset' => $offset,
					'author_name'=>$author,
					'orderby'=> $orderby,
					'tag'=>$tag,
					'meta_key' => $meta_key,
					'tax_query' => array(
							array(
								'taxonomy' => 'post_format',
								'field'    => 'slug',
								'terms' => array( 'post-format-video' ),
							),
						),
	    );
		}

    $loop = new WP_Query($args);

    $shortcode = '';

    if ($loop -> have_posts()) :  while ($loop -> have_posts()) : $loop -> the_post();

		$option = get_option("magazin_option");
		$excerpt_ = magazin_custom_excerpts(27);
		if (!empty($option['post_meta_excerpt'])) {
			if($option['post_meta_excerpt']==2){
				$excerpt_ = get_the_excerpt();
			}
			else if($option['post_meta_excerpt']==3){
				$excerpt = get_post_meta(get_the_ID(), "magazin_excerpt", true);
				if (!empty($excerpt)) { $excerpt_ = $excerpt; }
			}
			else if($option['post_meta_excerpt']==4){
				$excerpt = get_post_meta(get_the_ID(), "magazin_subtitle", true);
				if (!empty($excerpt)) { $excerpt_ = $excerpt; }
			}

		} else {
			$excerpt = get_post_meta(get_the_ID(), "magazin_excerpt", true);
			if (!empty($excerpt)) { $excerpt_ = $excerpt; }
		}

		// Category Code.
		$category_name = get_the_category(get_the_ID());
		$categorys = '';
		$categorys .='<div class="poster-cat"><span class="mt-theme-text">';
		$cat_nr = get_theme_mod( 'mt_post_meta_cat', 1 );
		if(!empty($category_name[0]) and $cat_nr == 1 or $cat_nr == 2 or $cat_nr == 3) { $categorys .=''.$category_name[0]->name.''; }
		if(!empty($category_name[1]) and $cat_nr == 2 or $cat_nr == 3) { $categorys .=', '.$category_name[1]->name.''; }
		if(!empty($category_name[2]) and $cat_nr == 3) { $categorys .=', '.$category_name[2]->name.''; }
		$categorys .='</span></div>';

		// Share count meta real and fake.
		$share = get_post_meta(get_the_ID(), "magazin_share_count", true);
		$share_real = get_post_meta(get_the_ID(), "magazin_share_count_real", true);
		$shares = $share_real;
		if (!empty($share)){ $shares = $share+$share_real; $shares = number_format($shares);}


		// View count meta real and fake.
		$view = get_post_meta(get_the_ID(), "magazin_view_count", true);
		$views = get_post_meta(get_the_ID(), "magazin_post_views_count", true);
		$viewes = $views + "0";
		if (!empty($view)){ $viewes = $view + $views; $viewes = number_format($viewes); }

		// Post data, share counts.
		$data ='';
		$data .='<div class="poster-data color-silver-light">';
		$data .='<span class="poster-shares">'. $shares .' '. esc_html__("shares", "magazine-plug") .'</span>';
		$data .='<span class="poster-views">'. $viewes .' '. esc_html__("views", "magazine-plug") .'</span>';
		if (get_comments_number()!="0") { $data .='<span class="poster-comments">'.get_comments_number().'</span>'; }
		$data .='</div>';


		$icon = '';
		if ( has_post_format( 'video' ) ) { $icon .='<span class="video-icon mt-theme-background"></span>'; }
		else if ( has_post_format( 'gallery' ) ) { $icon .='<span class="video-icon mt-theme-background gallery-icon"></span>'; }
		else { $icon .='<span class="post-icon mt-theme-background"><i class="ic-open open"></i></span>'; }

		// Shortcode
		$shortcode .='<div class="poster normal size-350'; if (!has_post_thumbnail()) { $shortcode .= ' img-empty'; } if (has_post_format( 'video' )) { $shortcode .= ' video'; } $shortcode .='">';
		if ( has_post_thumbnail() ) {
			$shortcode .='<a class="poster-image mt-radius pull-left" href="'. get_permalink().'">';
				$shortcode .= $icon;
				$shortcode .='<div class="mt-post-image" ><img src="'. get_the_post_thumbnail_url(get_the_ID(),'magazin_550').'" width="550" height="550" /></div>';
				$shortcode .='<div class="poster-info">'; $shortcode .= $categorys; $shortcode .= $data; $shortcode .='</div>';
			$shortcode .='</a>';
		}
			$shortcode .='<div class="poster-content">';
				$shortcode .= $categorys;
				$shortcode .= $data;
				$shortcode .='<a href="'. get_permalink().'"><h2>'. get_the_title() .'</h2></a>';
				$shortcode .='<small class="mt-pl"><strong class="mt-pl-a">'. get_the_author_meta( "display_name" ) .'</strong><span class="color-silver-light mt-ml"> - </span><span class="color-silver-light mt-pl-d">'. esc_attr( get_the_date('M d, Y') ) .'</span></small>';
				$shortcode .='<p>'.$excerpt_.'</p>';
				$shortcode .='<div class="hidden mt-readmore"><a class="mt-readmore-url" href="'. get_permalink().'">'. esc_html__("View Post", "magazine-plug") .'</a></div>';
			$shortcode .='</div>';
			$shortcode .='<div class="clearfix"></div>';
		$shortcode .='</div>';

    endwhile;
		wp_reset_postdata();
    endif;
    die($shortcode);
}

add_action('wp_ajax_nopriv_more_post_ajax', 'more_post_ajax');
add_action('wp_ajax_more_post_ajax', 'more_post_ajax');

function remove_caption_extra_width($width) {
   return $width - 10;
}
add_filter('img_caption_shortcode_width', 'remove_caption_extra_width');

function magazin_javascript_detection() {
	echo "<script>(function(html){html.className = html.className.replace(/\bno-js\b/,'js')})(document.documentElement);</script>\n";
}
add_action( 'wp_head', 'magazin_javascript_detection', 0 );

function modify_contact_methods($profile_fields) {

	// Add new fields
	$profile_fields['twitter'] = 'Twitter URL';
	$profile_fields['facebook'] = 'Facebook URL';
	$profile_fields['gplus'] = 'Google+ URL';
	$profile_fields['instagram'] = 'Instagram URL';
	$profile_fields['linkedin'] = 'LinkedIn URL';
	$profile_fields['pinterest'] = 'Pinterest URL';
	$profile_fields['youtube'] = 'YouTube URL';
	$profile_fields['dribbble'] = 'Dribbble URL';

	return $profile_fields;
}
add_filter('user_contactmethods', 'modify_contact_methods');

?>
