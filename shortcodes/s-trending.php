<?php
function posts_trending( $atts, $content = null ) {
		extract( shortcode_atts( array(
			'posttype' => 'post',
			'item_nr' => '',
			'order' => '',
			'orderby' => '',
			'include' => '',
			'exclude' => '',
			'category' => '',
			'tag' => '',
			'class' => '',
			'type' => 'small-two',
			'offset'=> '',
			'pagination'=> 'off',
			'title_type'=> 'off',
			'title'=> 'Title',
			), $atts));


			global $exclude_single_id, $post;
      if (is_single()) { $exclude = $exclude_single_id; }

			if($pagination == "on") {
				$paged = ( get_query_var( 'paged' ) ) ? absint( get_query_var( 'paged' ) ) : 1;
			}
			else {
				$paged = "";
			}

			$args = array(
				'post_type'=>$posttype,
				'order'=>$order,
				'orderby'=>$orderby,
				'include'=>$include,
				'exclude'=>$exclude,
				'posts_per_page'=>$item_nr,
				'offset'=>$offset,
				'category_name'=>$category,
				'paged' => $paged,
				'tag'=>$tag
			);

			$args_popular = array(
				'post_type'=>$posttype,
				'order'=>$order,
				'orderby'=>"meta_value_num",
				'include'=>$include,
				'exclude'=>$exclude,
				'posts_per_page'=>$item_nr,
				'offset'=>$offset,
				'meta_key' => 'magazin_post_views_count',
				'category_name'=>$category,
				'paged' => $paged,
				'tag'=>$tag
			);
			$args_shares = array(
				'post_type'=>$posttype,
				'order'=>$order,
				'orderby'=>"meta_value_num",
				'include'=>$include,
				'exclude'=>$exclude,
				'posts_per_page'=>$item_nr,
				'offset'=>$offset,
				'meta_key' => 'magazin_share_count_real',
				'category_name'=>$category,
				'paged' => $paged,
				'tag'=>$tag
			);


			if ($orderby == "popular") {
				$the_query = new WP_Query( $args_popular );
			}
			else if ($orderby == "shares") {
				$the_query = new WP_Query( $args_shares );
			}
			else {
				$the_query = new WP_Query( $args );
			}

			if(is_search() and $type=="normal-right"){

			global $query_string;

				$query_args = explode("&", $query_string);
				$search_query = array();

				if( strlen($query_string) > 0 ) {
					foreach($query_args as $key => $string) {
						$query_split = explode("=", $string);
						$search_query[$query_split[0]] = urldecode($query_split[1]);
					} // foreach
				} //if
				$the_query = new WP_Query($search_query);
			}

			$shortcode = '';
			$share = get_post_meta(get_the_ID(), "magazin_share_count", true);
			$shares = "0";
			if (!empty($share)){
				$shares = $share;
			}






				if($type=="trending-normal"){
					if($title_type=="center" and $title != ""){ $shortcode .= '<h2 class="heading"><span>'.$title.'</span></h2>'; }
					if($title_type=="left" and $title != ""){ $shortcode .= '<h2 class="heading heading-left"><span>'.$title.'</span></h2>'; }
					if($title_type=="right" and $title != ""){ $shortcode .= '<h2 class="heading heading-right"><span>'.$title.'</span></h2>'; }
					$i=1;
					while ( $the_query->have_posts() ) : $the_query->the_post();
					if ( has_post_thumbnail() ) {
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
						$shortcode .='<div class="poster trending-normal'; if (!has_post_thumbnail()) { $shortcode .= ' img-empty'; } if (has_post_format( 'video' )) { $shortcode .= ' video'; } if (has_post_format( 'gallery' )) { $shortcode .= ' gallery'; } $shortcode .='">';
						$shortcode .='<div class="number mt-theme-background">'.$i.'</div>';
							$shortcode .='<a class="poster-image mt-radius" href="'. get_permalink().'">';
								if ( has_post_format( 'video' )) {
									$shortcode .='<span class="video-icon"></span>';
								}
								if ( has_post_thumbnail() ) {
								  $shortcode .='<div class="mt-post-image" ><div class="mt-post-image-background" style="background-image:url('. get_the_post_thumbnail_url(get_the_ID(),'magazin_5').');"></div><img class="lazy" src="data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7" alt="'.get_the_title().'" data-src="'. get_the_post_thumbnail_url(get_the_ID(),'magazin_550').'" width="550" height="550" /></div>';
								}
								if ( !has_post_format( 'video' ) ) {
									$shortcode .='<i class="ic-open open"></i>';
									$shortcode .='<div class="poster-info mt-theme-background">';
										if ( has_post_thumbnail() ) {
											$shortcode .='<div class="poster-cat"><span>';
												$category_name = get_the_category(get_the_ID());
												$cat_nr = get_theme_mod( 'mt_post_meta_cat', 1 );
												if(!empty($category_name[0]) and $cat_nr == 1 or $cat_nr == 2 or $cat_nr == 3) { $shortcode .=''.$category_name[0]->name.''; }
												if(!empty($category_name[1]) and $cat_nr == 2 or $cat_nr == 3) { $shortcode .=', '.$category_name[1]->name.''; }
												if(!empty($category_name[2]) and $cat_nr == 3) { $shortcode .=', '.$category_name[2]->name.''; }
											$shortcode .='</span></div>';
										}
										$shortcode .='<div class="poster-data color-silver-light">';
											$shortcode .='<span class="poster-shares">'. $shares .' '. esc_html__("shares", "magazine-plug") .'</span>';
											$shortcode .='<span class="poster-views">'. $viewes .' '. esc_html__("views", "magazine-plug") .'</span>';
											if (get_comments_number()!="0") { $shortcode .='<span class="poster-comments">'.get_comments_number().'</span>'; }
										$shortcode .='</div>';
									$shortcode .='</div>';
								}
								if ( has_post_format( 'video' ) and has_post_thumbnail() ) {
									$shortcode .='<div class="poster-info mt-theme-background">';
									$shortcode .='<div class="poster-cat"><span>';
										$category_name = get_the_category(get_the_ID());
										$cat_nr = get_theme_mod( 'mt_post_meta_cat', 1 );
										if(!empty($category_name[0]) and $cat_nr == 1 or $cat_nr == 2 or $cat_nr == 3) { $shortcode .=''.$category_name[0]->name.''; }
										if(!empty($category_name[1]) and $cat_nr == 2 or $cat_nr == 3) { $shortcode .=', '.$category_name[1]->name.''; }
										if(!empty($category_name[2]) and $cat_nr == 3) { $shortcode .=', '.$category_name[2]->name.''; }
									$shortcode .='</span></div>';
									$shortcode .='<div class="poster-data color-silver-light">';
										$shortcode .='<span class="poster-shares">'. $shares .' '. esc_html__("shares", "magazine-plug") .'</span>';
										$shortcode .='<span class="poster-views">'. $viewes .' '. esc_html__("views", "magazine-plug") .'</span>';
										if (get_comments_number()!="0") { $shortcode .='<span class="poster-comments">'.get_comments_number().'</span>'; }
									$shortcode .='</div>';
									$shortcode .='</div>';
								}
							$shortcode .='</a>';
							$shortcode .='<div class="poster-content-wrap">';
										$shortcode .='<div class="poster-data color-silver-light">';
											$shortcode .='<span class="poster-shares">'. $shares .' '. esc_html__("shares", "magazine-plug") .'</span>';
											$shortcode .='<span class="poster-views">'. $viewes .' '. esc_html__("views", "magazine-plug") .'</span>';
											if (get_comments_number()!="0") { $shortcode .='<span class="poster-comments">'.get_comments_number().'</span>'; }
										$shortcode .='</div>';

								$shortcode .='<a href="'. get_permalink().'"><h2>'. get_the_title() .'</h2></a>';
								$shortcode .='<small class="mt-pl"><strong class="mt-pl-a">'. get_the_author_meta( "display_name" ) .'</strong><span class="color-silver-light mt-ml"> - </span><span class="color-silver-light mt-pl-d">'. esc_attr( get_the_date('M d, Y') ) .'</span></small>';
							$shortcode .='</div>';
						$shortcode .='</div>';
						$i++;
					}
					endwhile;
				}


				if($type=="trending-carousel"){
					$shortcode .='<div class="poster-carousel-trending">';
					if($title_type=="center" and $title != ""){ $shortcode .= '<h2 class="heading"><span>'.$title.'</span></h2>'; }
					if($title_type=="left" and $title != ""){ $shortcode .= '<h2 class="heading heading-left"><span>'.$title.'</span></h2>'; }
					if($title_type=="right" and $title != ""){ $shortcode .= '<h2 class="heading heading-right"><span>'.$title.'</span></h2>'; }
					$shortcode .='<div class="post-carousel ">';

					$i=1;
					while ( $the_query->have_posts() ) : $the_query->the_post();
						if (has_post_thumbnail()) {
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
							$shortcode .='<div class="poster trending-carousel'; if (!has_post_thumbnail()) { $shortcode .= ' img-empty'; } if (has_post_format( 'video' )) { $shortcode .= ' video'; } if (has_post_format( 'gallery' )) { $shortcode .= ' gallery'; } $shortcode .='">';

								$shortcode .='<a class="poster-image" href="'. get_permalink().'">';
									if ( has_post_format( 'video' )) {
										$shortcode .='<span class="video-icon"></span>';
									}
									if ( has_post_thumbnail() ) {
										$shortcode .='<div class="mt-post-image" ><img src="data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7" data-lazy="'. get_the_post_thumbnail_url(get_the_ID(),'large').'" alt="'.get_the_title().'"/></div>';
									}
									if ( !has_post_format( 'video' ) ) {
										$shortcode .='<div class="poster-info">';
											if ( has_post_thumbnail() ) {
												$shortcode .='<div class="poster-cat"><span class="mt-radius">';
													$category_name = get_the_category(get_the_ID());
													$cat_nr = get_theme_mod( 'mt_post_meta_cat', 1 );
													if(!empty($category_name[0]) and $cat_nr == 1 or $cat_nr == 2 or $cat_nr == 3) { $shortcode .=''.$category_name[0]->name.''; }
													if(!empty($category_name[1]) and $cat_nr == 2 or $cat_nr == 3) { $shortcode .=', '.$category_name[1]->name.''; }
													if(!empty($category_name[2]) and $cat_nr == 3) { $shortcode .=', '.$category_name[2]->name.''; }
												$shortcode .='</span></div>';
											}
											$shortcode .='<div class="poster-data color-silver-light">';
												$shortcode .='<span class="poster-shares">'. $shares .' '. esc_html__("shares", "magazine-plug") .'</span>';
												$shortcode .='<span class="poster-views">'. $viewes .' '. esc_html__("views", "magazine-plug") .'</span>';
												if (get_comments_number()!="0") { $shortcode .='<span class="poster-comments">'.get_comments_number().'</span>'; }
											$shortcode .='</div>';
										$shortcode .='</div>';
									}
									if ( has_post_format( 'video' ) and has_post_thumbnail() ) {
										$shortcode .='<div class="poster-info mt-theme-background">';
										$shortcode .='<div class="poster-cat"><span>';
											$category_name = get_the_category(get_the_ID());
											$cat_nr = get_theme_mod( 'mt_post_meta_cat', 1 );
											if(!empty($category_name[0]) and $cat_nr == 1 or $cat_nr == 2 or $cat_nr == 3) { $shortcode .=''.$category_name[0]->name.''; }
											if(!empty($category_name[1]) and $cat_nr == 2 or $cat_nr == 3) { $shortcode .=', '.$category_name[1]->name.''; }
											if(!empty($category_name[2]) and $cat_nr == 3) { $shortcode .=', '.$category_name[2]->name.''; }
										$shortcode .='</span></div>';
										$shortcode .='<div class="poster-data color-silver-light">';
											$shortcode .='<span class="poster-shares">'. $shares .' '. esc_html__("shares", "magazine-plug") .'</span>';
											$shortcode .='<span class="poster-views">'. $viewes .' '. esc_html__("views", "magazine-plug") .'</span>';
											if (get_comments_number()!="0") { $shortcode .='<span class="poster-comments">'.get_comments_number().'</span>'; }
										$shortcode .='</div>';
										$shortcode .='</div>';
									}
								$shortcode .='</a>';
								$shortcode .='<div class="poster-content-wrap">';

											$shortcode .='<div class="poster-data color-silver-light">';
												$shortcode .='<span class="poster-shares">'. $shares .' </span>';
												$shortcode .='<span class="poster-views">'. $viewes .' </span>';
												if (get_comments_number()!="0") { $shortcode .='<span class="poster-comments">'.get_comments_number().'</span>'; }
											$shortcode .='</div>';

									$shortcode .='<a href="'. get_permalink().'"><h2>'. get_the_title() .'</h2></a>';
									$shortcode .='<small class="mt-pl"><strong class="mt-pl-a">'. get_the_author_meta( "display_name" ) .'</strong><span class="color-silver-light mt-ml"> - </span><span class="color-silver-light mt-pl-d">'. esc_attr( get_the_date('M d, Y') ) .'</span></small>';
								$shortcode .='</div>';
							$shortcode .='</div>';
							$i++;
						}
					endwhile;
					$shortcode .='</div>';
					$shortcode .='</div>';

				}

			if($pagination == "on") {

			 $pag_args1 = array(
              'format'  => '?paged=%#%',
              'current' => $paged,
							'prev_text' => "<span></span>",
							'next_text' => "<span></span>",
              'total'   => $the_query->max_num_pages
          );

			  $shortcode .=  '<div class="pagination">'.paginate_links($pag_args1) .'</div>';

			}
			wp_reset_postdata();
			return $shortcode;
}
add_shortcode('posts_trending', 'posts_trending');
?>
