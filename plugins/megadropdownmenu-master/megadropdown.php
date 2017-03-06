<?php


class megadropdown {
	var $is_mobile = true; // if mobile

	var $current_page = 1; // Default page number
	var $found_posts; // found_posts
	var $total_pages; // total_pages
	/**
	 * Constructor
	 */
	function __construct() {
		// add_action( 'init', array($this, 'register_menu'));

		if(is_admin()) {

			// add action for save custom field
			add_action('wp_update_nav_menu_item', array($this, 'md_update_custom_category'), 10, 3);

			// add filter for edit menu walker (admin page)
			add_filter('wp_edit_nav_menu_walker', array($this, 'md_edit_nav_menu_walker'), 10, 2);
		}

		// add filter wp nav menu objects
		add_filter('wp_nav_menu_objects', array($this, 'md_nav_menu_object'), 10, 2);

		// add action for stylesheet
		add_action('wp_enqueue_scripts', array( $this, 'load_style'));

		// add action for script js
		add_action('wp_enqueue_scripts', array( $this, 'load_script'));

   		add_action( 'wp_ajax_nopriv_getNextPage', array($this, 'getNextPage') );
   		add_action( 'wp_ajax_getNextPage', array($this, 'getNextPage') );

   		add_action( 'wp_ajax_nopriv_getPrevPage', array($this, 'getPrevPage') );
   		add_action( 'wp_ajax_getPrevPage', array($this, 'getPrevPage') );
	}
	// end of constructor

	/**
	 * set_page
	 * function to set page number
	 * @param $pagenumber
	 * @return -
	 */
	function set_current_page($pagenumber){
		$this->current_page = $pagenumber;
	}

	/**
	 * get_page
	 * function to get page number
	 * @param -
	 * @return $this->page
	 */
	function get_current_page(){
		return $this->current_page;
	}

	/**
	 * set_found_posts
	 * set found_posts
	 * @param $found
	 * @return -
	 */
	function set_found_posts($found){
		$this->found_posts = $found;
	}

	/**
	 * get_found_posts
	 * get found_posts number
	 * @param -
	 * @return $found_posts
	 */
	function get_found_posts(){
		return $this->found_posts;
	}

	/**
	 * set_total_pages
	 * set total page from [max_number_pages]
	 * @param $total
	 * @return -
	 */
	function set_total_pages($total){
		$this->total_pages = $total;
	}

	/**
	 * get_total_pages()
	 * get total pages value
	 * @param -
	 * @return $total_pages
	 */
	function get_total_pages(){
		return $this->total_pages;
	}

    /**
     * register nav menu
     *
     */
    function register_menu() {
    	register_nav_menus(
    		array(
    			'theme_location' 	=> 'sec',
				'menu_id' 			=> 'df-primary-megadropdown-menu',
    			'menu' 			=> 'main',  // md_walker class for megamenu
				'walker' 		=> new md_walker, // md_walker for megamenu
				'menu_class' 	=> 'nav navbar-nav df-megadropdown-menu'
    			)
    	);
    }

	/**
	 * Load stylesheet for mega dropdown menu plugin
	 * @param -
	 */
	function load_style() {
	}

	/**
	 * load script js / jquery for mega dropwon menu plugin
	 * @param -
	 */
	function load_script() {

	}

	/*
	 * save custom field
	 * md_update_custom_category
	 * @param $menu_id
	 * @param $menu_item_db_id
	 * @param args
	 */
	function md_update_custom_category( $menu_id, $menu_item_db_id, $args ){
		// check if element is properly sent
		/*if( is_array( $_REQUEST['menu-item-subtitle'])) {
			$subtitle_value = $_REQUEST['menu-item-subtitle'][$menu_item_db_id];
			update_post_meta( $menu_item_db_id, '_menu_item_subtitle', $subtitle_value);
		}*/

		if(isset($_POST['megadropdown_menu_cat'][$menu_item_db_id])){
			update_post_meta($menu_item_db_id, 'megadropdown_menu_cat', $_POST['megadropdown_menu_cat'][$menu_item_db_id]);
		}
	}

	/*
	 * edit / custom field in admin
	 * md_edit_nav_menu_walker
	 * @param $walker
	 * @param $menu_id
	 */
	function md_edit_nav_menu_walker( $walker, $menu_id ){
		// walker_nav_menu_edit_custom from edit_custom_walker.php
		// include_once('edit_custom_walker.php');
		return 'Walker_Nav_Menu_Edit_Custom';
	}

	function get_sub_cat_posts($args) {
		$category = get_categories($args);
		return $category;
	}

	/*
	 * add mega menu support
	 * @param $items
	 * @param $args
	 * @return array
	 */
	function md_nav_menu_object($items, $args = '') {
		$buffer_items = array();
		$category_key_post_meta = 'megadropdown_menu_cat';
		// $posts_per_page = 4; // DEFAULT VALUE | OR limit FOR QUERY

		$has_sub_cat;
		// print_r($this->category_has_children());

		$no_item = 1;
		// print_r($items);
		foreach ($items as &$item) {
			$item->is_mega_menu = false;

			$megadropdown_menu_cat = get_post_meta($item->ID, $category_key_post_meta, true);

			if($megadropdown_menu_cat != ''){

				$sub_args = array(
					'parent' => $megadropdown_menu_cat
					);
				$sub_cat = $this->get_sub_cat_posts($sub_args);

				$sizeof = (sizeof($sub_cat) == 0) ? 'no sub' : 'has sub categories with post';
				// print_r($sub_cat);

				$item->classes[] = 'df-md-menuitem';
				$item->classes[] = 'df-is-megamenu dropdown';

				$buffer_items[] = $item;

				// generate wp post
				$new_item = $this->generate_post(); // generate menu item
				$new_item->is_mega_menu = true;
				$new_item->menu_item_parent = $item->ID;
				$new_item->cat_id = $megadropdown_menu_cat; // category id
				$new_item->no_item = $no_item;
				$new_item->url = '';

				// open tag for megamenu
				$new_item->title = '</a>';
				$new_item->title .= '<div class="df-block-megamenu df-block-megamenu-'.esc_attr( $megadropdown_menu_cat ).'-'.esc_attr( $no_item ).'">';
				$new_item->title .= '<div class="row">'; // open tag for row

				$posts_per_page = (sizeof($sub_cat) == 0) ? 5 : 4;

				if(sizeof($sub_cat) == 0){ // if cat has no sub-cat with posts
					$has_sub_cat = 'false'; //

					$offset = $this->get_offset($this->get_current_page(), $posts_per_page);

					// open tag for inner megamenu
					$new_item->title .= '<div class="df-block-inner-megamenu df-block-inner-megamenu-'.esc_attr( $megadropdown_menu_cat ).'-'.esc_attr( $no_item ).'">';

					// query post by category
					$querypostbyCat = $this->get_posts_by_cat($megadropdown_menu_cat, $posts_per_page, $offset);

					// set found_posts
					$this->set_found_posts($querypostbyCat->found_posts);
					// set and passing found_posts to $new_item
					$new_item->found_posts = $this->get_found_posts();
					$this->set_total_pages($querypostbyCat->max_num_pages);

					$new_item->current_page = $this->get_current_page();
					$new_item->last_page = $this->get_total_pages();

					$new_item->offset = $offset;

					$new_item->title .= '<input type="hidden" name="df-total-pages-'.esc_attr( $megadropdown_menu_cat ) .'-'. esc_attr( $no_item ) .'" value="'. esc_attr( $this->get_total_pages() ) .'" class="df-total-pages-'. esc_attr( $megadropdown_menu_cat ) .'-'. esc_attr( $no_item ) .'">';
					$new_item->title .= '<input type="hidden" name="df-posts-per-page-'. esc_attr( $megadropdown_menu_cat ) .'-'. esc_attr( $no_item ) .'" value="'. esc_attr( $posts_per_page ) .'" class="df-posts-per-page-'. esc_attr( $megadropdown_menu_cat ) .'-'. esc_attr( $no_item ) .'">';
					$new_item->title .= '<input type="hidden" name="df-current-page-'. esc_attr( $megadropdown_menu_cat ) .'-'. esc_attr( $no_item ) .'" value="'. esc_attr( $this->get_current_page() ) .'" class="df-current-page-'. esc_attr( $megadropdown_menu_cat ) .'-'. esc_attr( $no_item ) .'">';
					$new_item->title .= '<input type="hidden" name="df-has-sub-cat-'. esc_attr( $megadropdown_menu_cat ) .'-'. esc_attr( $no_item ) .'" value="'. esc_attr( $has_sub_cat ) .'" class="df-has-sub-cat-'. esc_attr( $megadropdown_menu_cat ) .'-'. esc_attr( $no_item ) .'">';

					// render result query
					$new_item->title .= $this->render_inner($querypostbyCat->posts, $megadropdown_menu_cat, $no_item, $has_sub_cat);

					$new_item->title .= '</div>'; // close tag for inner megamenu

				}else{// if cat has sub-cat with posts
					$has_sub_cat = 'true';

					// loading div container
					// $new_item->title .= '<div class="df-loading df-loading-'.esc_attr( $megadropdown_menu_cat ).'-'.esc_attr( $no_item ).'">LOADING</div>';

					// load sub categories as navigation
					$new_item->title .= '<div class="col-md-3">';
					$new_item->title .= '<ul class="nav nav-stacked df-megamenu-nav-sub" id="megamenu-'.esc_attr( $megadropdown_menu_cat ).'-'.esc_attr( $no_item ).'">';
					$new_item->title .= '<li class="active">';
					$new_item->title .= '<a  data-toggle="tab" href="#df-pane-'.esc_attr( $megadropdown_menu_cat ).'-'.esc_attr( $no_item ).'">All</a>';
					$new_item->title .= '</li>';
					foreach($sub_cat as $sc){
						$new_item->title .= '<li class="">';
							$new_item->title .= '<a data-toggle="tab" href="#df-pane-'.esc_attr( $sc->cat_ID ).'-'.esc_attr( $no_item ).'" class="">'.$sc->cat_name.'</a>';
						$new_item->title .= '</li>';
					}
					$new_item->title .= '</ul>';
					$new_item->title .= '</div>';
					// load sub categories end here

					$offset = $this->get_offset($this->get_current_page(), $posts_per_page);



					$querypostbyCat = $this->get_posts_by_cat($megadropdown_menu_cat, $posts_per_page, $offset);


					// load content posts here
					$new_item->title .= '<div class="df-container-tab-content col-md-9">'; // open tag for col-md-9 (container of tab content)
					$new_item->title .= '<div class="tab-content tab-content-'.esc_attr( $megadropdown_menu_cat ).'-'.esc_attr( $no_item ).'">'; // open tag for tab content

					// open tag for tab-content_inner / pane
					$new_item->title .= '<div id="df-pane-'.esc_attr( $megadropdown_menu_cat ).'-'.esc_attr( $no_item ).'" class="tab-pane fade active in df-tab-content-inner-'.esc_attr( $megadropdown_menu_cat ).'-'.esc_attr( $no_item ).'">';

					// set found_posts
					$this->set_found_posts($querypostbyCat->found_posts);
					$new_item->found_posts = $this->get_found_posts();
					$this->set_total_pages($querypostbyCat->max_num_pages);

					if($this->get_found_posts() > 3){
    				$stylefirst = 'pointer-events: none; cursor: default; color: #ccc';
		       		$new_item->title .= '<div class="row">
		       							<div class="row_next_prev hidden-xs row_next_prev-'.esc_attr($megadropdown_menu_cat).'-'.esc_attr($no_item).'">
				       						<div class="" style="">
				       							<a href="#" style="'.$stylefirst.'" data-cat="'.esc_attr($megadropdown_menu_cat).'" data-item="'.esc_attr($no_item).'" id="prev-'.esc_attr($megadropdown_menu_cat).'-'.esc_attr($no_item).'" class="prev_megamenu">Prev</a> |
				       							<a href="#" style="" data-cat="'.esc_attr($megadropdown_menu_cat).'" data-item="'.esc_attr($no_item).'" id="next-'.esc_attr($megadropdown_menu_cat).'-'.esc_attr($no_item).'" class="next_megamenu">Next</a>
				       						</div>
				       					</div>
			                            </div>';
	           		}

	           		$new_item->title .= '<div class="row-inner">';// open tag for row block inner megamenu

					// loading div container

					//  open tag for block inner megamenu
					$new_item->title .= '<div class="df-block-inner-megamenu df-block-inner-megamenu-'.esc_attr( $megadropdown_menu_cat ).'-'.esc_attr( $no_item ).'">';
					$new_item->title .= '<input type="hidden" name="df-total-pages-'.esc_attr( $megadropdown_menu_cat ) .'-'. esc_attr( $no_item ) .'" value="'. esc_attr( $this->get_total_pages() ) .'" class="df-total-pages-'. esc_attr( $megadropdown_menu_cat ) .'-'. esc_attr( $no_item ) .'">';
					$new_item->title .= '<input type="hidden" name="df-posts-per-page-'. esc_attr( $megadropdown_menu_cat ) .'-'. esc_attr( $no_item ) .'" value="'. esc_attr( $posts_per_page ) .'" class="df-posts-per-page-'. esc_attr( $megadropdown_menu_cat ) .'-'. esc_attr( $no_item ) .'">';
					$new_item->title .= '<input type="hidden" name="df-current-page-'. esc_attr( $megadropdown_menu_cat ) .'-'. esc_attr( $no_item ) .'" value="'. esc_attr( $this->get_current_page() ) .'" class="df-current-page-'. esc_attr( $megadropdown_menu_cat ) .'-'. esc_attr( $no_item ) .'">';
					$new_item->title .= '<input type="hidden" name="df-has-sub-cat-'. esc_attr( $megadropdown_menu_cat ) .'-'. esc_attr( $no_item ) .'" value="'. esc_attr( $has_sub_cat ) .'" class="df-has-sub-cat-'. esc_attr( $megadropdown_menu_cat ) .'-'. esc_attr( $no_item ) .'">';
					$new_item->title .= $this->render_inner($querypostbyCat->posts, $megadropdown_menu_cat, $no_item, 'true');
					$new_item->title .= '</div>'; // close tag for block inner megamenu

					$new_item->title .= '</div>';// close tag for row block inner megamenu

					$new_item->title .= '</div>'; // close tag for tab-content_inner / pane
					foreach ($sub_cat as $countersc) {
						// $new_item->title .= $countersc->cat_ID;


						$new_item->title .= '<div id="df-pane-'.$countersc->cat_ID.'-'.$no_item.'" class="tab-pane fade df-tab-content-inner-'.$countersc->cat_ID.'-'.$no_item.'">'; // open tag for tab-content_inner
						// query post by category
						$querypostbyCat = $this->get_posts_by_cat($countersc->cat_ID, $posts_per_page, $offset);

						// set found_posts
						$this->set_found_posts($querypostbyCat->found_posts);
						$new_item->found_posts = $this->get_found_posts();
						$this->set_total_pages($querypostbyCat->max_num_pages);

						if($this->get_found_posts() > 3){
	    					$stylefirst = 'pointer-events: none; cursor: default; color: #ccc';
			       			$new_item->title .= '<div class="row">
			       								<div class="row_next_prev hidden-xs row_next_prev-'.esc_attr($countersc->cat_ID).'-'.esc_attr($no_item).'">
		       										<div class="" style="">
		       											<a href="#" style="'.$stylefirst.'" data-cat="'.esc_attr($countersc->cat_ID).'" data-item="'.esc_attr($no_item).'" id="prev-'.esc_attr($countersc->cat_ID).'-'.esc_attr($no_item).'" class="prev_megamenu">Prev</a> |
		       											<a href="#" style="" data-cat="'.esc_attr($countersc->cat_ID).'" data-item="'.esc_attr($no_item).'" id="next-'.esc_attr($countersc->cat_ID).'-'.esc_attr($no_item).'" class="next_megamenu">Next</a>
		       										</div>
		       									</div>
	                            				</div>';
		           		}
		           		$new_item->title .= '<div class="row-inner">';// open tag for row block inner megamenu
						// open tag for inner megamenu


						$new_item->title .= '<div class="df-block-inner-megamenu df-block-inner-megamenu-'.esc_attr( $countersc->cat_ID ).'-'.esc_attr( $no_item ).'">'; // open tag for block inner megamenu
						$new_item->title .= '<input type="hidden" name="df-total-pages-'.esc_attr( $countersc->cat_ID ) .'-'. esc_attr( $no_item ) .'" value="'. esc_attr( $this->get_total_pages() ) .'" class="df-total-pages-'. esc_attr( $countersc->cat_ID ) .'-'. esc_attr( $no_item ) .'">';
						$new_item->title .= '<input type="hidden" name="df-posts-per-page-'. esc_attr( $countersc->cat_ID ) .'-'. esc_attr( $no_item ) .'" value="'. esc_attr( $posts_per_page ) .'" class="df-posts-per-page-'. esc_attr( $countersc->cat_ID ) .'-'. esc_attr( $no_item ) .'">';
						$new_item->title .= '<input type="hidden" name="df-current-page-'. esc_attr( $countersc->cat_ID ) .'-'. esc_attr( $no_item ) .'" value="'. esc_attr( $this->get_current_page() ) .'" class="df-current-page-'. esc_attr( $countersc->cat_ID ) .'-'. esc_attr( $no_item ) .'">';
						$new_item->title .= '<input type="hidden" name="df-has-sub-cat-'. esc_attr( $countersc->cat_ID ) .'-'. esc_attr( $no_item ) .'" value="'. esc_attr( $has_sub_cat ) .'" class="df-has-sub-cat-'. esc_attr( $countersc->cat_ID ) .'-'. esc_attr( $no_item ) .'">';
						$new_item->title .= $this->render_inner($querypostbyCat->posts, $countersc->cat_ID, $no_item, $has_sub_cat);
						$new_item->title .= '</div>'; // close tag for block inner megamenu

						$new_item->title .= '</div>';// close tag for row block inner megamenu

						$new_item->title .= '</div>'; // close tag for tab-content_inner
					}
					$new_item->title .= '</div>'; // close tag for tab content
					$new_item->title .= '</div>'; // close tag for col-md-9 (container of tab content)
					// load content posts end here

				}

				$new_item->title .= '</div>'; // close tag for row
				$new_item->title .= '</div>'; // close tag for megamenu
				$new_item->title .= '<a>';

				$buffer_items[] = $new_item;
			}else{
				$item->classes[] = 'df-md-menuitem';
				$item->classes[] = 'dropdown df-is-not-megamenu';
				$buffer_items[] = $item;
			}
			$no_item++;
		}


		// print_r($buffer_items);
		return $buffer_items;
	}

	/**
	 * get_posts_by_cat
	 * @param $cat
	 * @param $posts_per_page
	 * @param $offset
	 * @return WP_Query Object
	 */
	function get_posts_by_cat($cat, $posts_per_page, $offset){
		$params = array(
				'cat' => $cat,
				'posts_per_page' => $posts_per_page,
				'offset' => $offset
			);
		return new WP_Query($params);
	}

	/**
	 * get_offset
	 * get offset for pagination
	 * @param $posts_per_page
	 * @param $current_page
	 * ($this->get_current_page() * $posts_per_page) - $posts_per_page;
	 * @return
	 */
	function get_offset($current_page, $posts_per_page){
		return ($current_page * $posts_per_page) - $posts_per_page;
	}

	/**
	 * generate_post
	 * @param -
	 * @return WP_Post()
	 */
	function generate_post() {
        $post = new stdClass;
        $post->ID = '0';
        $post->post_author = '';
        $post->post_date = '';
        $post->post_date_gmt = '';
        $post->post_password = '';
        $post->post_type = 'nav_menu_item';
        $post->post_status = 'publish';
        $post->to_ping = '';
        $post->pinged = '';
        $post->comment_status = '';
        $post->ping_status = '';
        $post->post_pingback = '';
        //$post->post_category = '';
        $post->page_template = 'default';
        $post->post_parent = 0;
        $post->menu_order = 0;
        return new WP_Post($post);
    }
     /**
      * render inner post
      * @param $posts
      * @return div megamenu
      */
    function render_inner($posts, $cat_id, $no_item, $has_sub_cat){
    	$buff = '';

    	if(!empty($posts)) {

    		if($has_sub_cat == 'false'){
    			$buff .= '<div class="mega-post-wrap megamenu-grid-container-'.esc_attr($cat_id).'-'.esc_attr($no_item).'">';
	    		// $buff .= '<div class="'. $found_post .'"><a href="#">Prev</a> | <a href="#">Next</a></div>';
	    		// print_r($found_post);
	    		foreach ($posts as $post) {
	    			$buff .= '<div class="megamenu-span mega-5">';
						$buff .= '<div class="mega-post-in">';

	    			$buff .= '<a href="'. $this->get_href($post) .'" >';

												$buff .='<div class="poster-cat mt-theme-background"><span>';
													$category_name = get_the_category($post->ID);
													$cat_nr = get_theme_mod( 'mt_post_meta_cat', 1 );
													if(!empty($category_name[0]) and $cat_nr == 1 or $cat_nr == 2 or $cat_nr == 3) { $buff .=''.$category_name[0]->name.''; }
													if(!empty($category_name[1]) and $cat_nr == 2 or $cat_nr == 3) { $buff .=', '.$category_name[1]->name.''; }
													if(!empty($category_name[2]) and $cat_nr == 3) { $buff .=', '.$category_name[2]->name.''; }
												$buff .= '</span></div>';

						$buff .= $this->image_post($post);

						$buff .= '</a>';
						$buff .= '<a href="'. $this->get_href($post) .'" ><h4>';
						$buff .= ''.$post->post_title.'';
	    			$buff .= '</h4></a>';
						$buff .= '</div>';
	    			$buff .= '</div>';
	    		}
	    		$buff .= '</div>';
    		}


    	}
    	return $buff;
    }

    /**
     * image_post
     * @param $post
     * @return featured image of post
     */
		 function image_post($post){
     	$thumbs='';
     	if( has_post_thumbnail( $post->ID) ){
							$thumbs .='<div class="mt-megamenu-img poster-image mt-radius"><div class="mt-post-image"><div class="mt-post-image-background" style="background-image:url('. get_the_post_thumbnail_url($post->ID,'magazin_5').');"></div><img alt="'.$post->post_title.'" class="lazy" src="data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7"  data-src="'. get_the_post_thumbnail_url($post->ID,'medium').'" width="550" height="550" /></div></div>';
			}else{
     		$thumbs = '';
     	}
     	return $thumbs;
     }

    /**
     * get_href
     * @param $post
     * @return url / href / permalink of post
     */
    function get_href($post){
    	$url='';
    	return $url = esc_url(get_permalink($post->ID));
    }

    /**
     * generate_nextprev_posts
     * generate prev/next posts in megamenu
     * @param $args
     * @return $new_posts
     */
    function generate_nextprev_posts( $args = array() ){
    	$no_item = $args['no_item'];
    	$cat_id = $args['category_id'];
    	$total_pages = $args['total_pages'];
    	// $found_posts = $args['found_posts'];
    	$posts_per_page = $args['posts_per_page'];
    	$before_page = $args['current_page'];
    	$has_sub_cat = $args['has_sub_cat'];
    	$type = $args['type'];

    	// type 'next'
    	if($type == 'next'){
    		if($before_page == '1' ){
	    		$current_page = $before_page + 1;
	    	}else{
	    		if($before_page <  $total_pages){
	    			$current_page = $before_page + 1;
	    		}else{
	    			$current_page = $total_pages;
	    		}
	    	}
    	}else{
    		// type 'prev'
    		$current_page = $before_page - 1;
    	}

    	$offset = $this->get_offset($current_page, $posts_per_page);

    	$query = $this->get_posts_by_cat($cat_id, $posts_per_page, $offset);

    	if( $query->have_posts() ){
    		$new_posts = '<div class="df-block-inner-megamenu-'.esc_attr( $cat_id ).'-'.esc_attr( $no_item ).'">';

    		$new_posts .= '<input type="hidden" name="df-total-pages-'.esc_attr( $cat_id ) .'-'. esc_attr( $no_item ) .'" value="'. esc_attr( $total_pages ) .'" class="df-total-pages-'. esc_attr( $cat_id ) .'-'. esc_attr( $no_item ) .'">';
			$new_posts .= '<input type="hidden" name="df-posts-per-page-'. esc_attr( $cat_id ) .'-'. esc_attr( $no_item ) .'" value="'. esc_attr( $posts_per_page ) .'" class="df-posts-per-page-'. esc_attr( $cat_id ) .'-'. esc_attr( $no_item ) .'">';
			$new_posts .= '<input type="hidden" name="df-current-page-'. esc_attr( $cat_id ) .'-'. esc_attr( $no_item ) .'" value="'. esc_attr( $current_page ) .'" class="df-current-page-'. esc_attr( $cat_id ) .'-'. esc_attr( $no_item ) .'">';
			$new_posts .= '<input type="hidden" name="df-has-sub-cat-'. esc_attr( $cat_id ) .'-'. esc_attr( $no_item ) .'" value="'. esc_attr( $has_sub_cat ) .'" class="df-has-sub-cat-'. esc_attr( $cat_id ) .'-'. esc_attr( $no_item ) .'">';

    		$new_posts .= $this->render_inner($query->posts, $cat_id, $no_item, $has_sub_cat);
    		$new_posts .= '</div>';

    	} else {
    		$new_posts = '<div class="df-block-inner-megamenu-'.esc_attr( $cat_id ).'-'.esc_attr( $no_item ).'">';
    		$new_posts .= 'category: '.$cat_id;
    		$new_posts .= 'posts_per_page: '. $posts_per_page;
    		$new_posts .= 'offset: '.$offset;
    		$new_posts .= 'current page: '.$current_page;
    		$new_posts .= '</div>';

    		$new_posts .= json_encode($query->posts);
    	}
    	return $new_posts;
    }

    /**
     * getNextPage
     * @param -
   	 * @return -
     */
	function getNextPage(){
		$no_item = $_POST['no_item'];
		$category_id = $_POST['category_id'];
		$total_pages = $_POST['total_pages'];
		$posts_per_page = $_POST['posts_per_page'];
		$current_page = $_POST['current_page'];
		$has_sub_cat = $_POST['has_sub_cat'];
		$type = $_POST['type'];

		$params = array(
			'no_item' => $no_item,
			'category_id' => $category_id,
			'total_pages' => $total_pages,
			// 'found_posts' => $found_posts,
			'posts_per_page' => $posts_per_page,
			'current_page' => $current_page,
			'has_sub_cat' => $has_sub_cat,
			'type' => $type
			);

		$results = $this->generate_nextprev_posts( $params );
		die($results);
	}

	/**
	 * getPrevPage
	 * @param -
	 * @return -
	 */
	function getPrevPage(){
		$no_item = $_POST['no_item'];
		$category_id = $_POST['category_id'];
		$total_pages = $_POST['total_pages'];
		$posts_per_page = $_POST['posts_per_page'];
		$current_page = $_POST['current_page'];
		$has_sub_cat = $_POST['has_sub_cat'];
		$type = $_POST['type'];

		$params = array(
			'no_item' => $no_item,
			'category_id' => $category_id,
			'total_pages' => $total_pages,
			// 'found_posts' => $found_posts,
			'posts_per_page' => $posts_per_page,
			'current_page' => $current_page,
			'has_sub_cat' => $has_sub_cat,
			'type' => $type
			);

		$results = $this->generate_nextprev_posts( $params );
		die($results);
	}

}

// instatiate plugin's class
new megadropdown();

// front end menu generates here!
include_once('custom_walker.php');

// add custom field to admin menu panel
include_once('edit_custom_walker.php');
