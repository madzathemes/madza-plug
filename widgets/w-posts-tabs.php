<?php
class Post_Tabs_Widget extends WP_Widget {

	function __construct() {
		parent::__construct(
			'posts_tabs_widget',
			__( 'mt Post Tabs', 'tophot' ),
			array( 'description' => esc_html__( 'A Post Widget', 'tophot' ), )
		);
	}

	public function widget( $args, $instance ) {
		echo $args['before_widget'];

		$item_nr = "10";
		$category = "";
		$tag = "";
		$title = "";
		$orderby = "";
		$widget_id = "";
		$tab_popular = "";
		$tab_hot = "";
		$tab_trending = "";
		$tab_posts = "";
		$tab_videos = "";
		$tab_galleries = "";
		$author = "";

		if ( ! empty( $instance['item_nr'] ) ) { $item_nr = $instance['item_nr'];	}
		if ( ! empty( $instance['category'] ) ) { $category = $instance['category'];	}
		if ( ! empty( $instance['title'] ) ) { $title = $instance['title'];	}
		if ( ! empty( $instance['orderby'] ) ) { $orderby = $instance['orderby'];	}
		if ( ! empty( $instance['tab_popular'] ) ) { $tab_popular = $instance['tab_popular'];	}
		if ( ! empty( $instance['tab_hot'] ) ) { $tab_hot = $instance['tab_hot'];	}
		if ( ! empty( $instance['tab_trending'] ) ) { $tab_trending = $instance['tab_trending'];	}
		if ( ! empty( $instance['tab_posts'] ) ) { $tab_posts = $instance['tab_posts'];	}
		if ( ! empty( $instance['tab_videos'] ) ) { $tab_videos = $instance['tab_videos'];	}
		if ( ! empty( $instance['tab_galleries'] ) ) { $tab_galleries = $instance['tab_galleries'];	}
		if ( ! empty( $instance['author'] ) ) { $author = $instance['author'];	}

		echo do_shortcode("[posts_tabs item_nr='$item_nr' author='$author' orderby='$orderby' tag='$tag' category='$category' title='$title' tab_popular='$tab_popular' tab_hot='$tab_hot' tab_trending='$tab_trending' tab_posts='$tab_posts' tab_videos='$tab_videos' tab_galleries='$tab_galleries']");

		echo $args['after_widget'];
	}

	public function form( $instance ) {
		$item_nr = ! empty( $instance['item_nr'] ) ? $instance['item_nr'] : esc_html__( '', 'tophot' );
		$category = ! empty( $instance['category'] ) ? $instance['category'] : esc_html__( '', 'tophot' );
		$tag = ! empty( $instance['tag'] ) ? $instance['tag'] : esc_html__( '', 'tophot' );
		$title = ! empty( $instance['title'] ) ? $instance['title'] : esc_html__( '', 'tophot' );
		$orderby = ! empty( $instance['orderby'] ) ? $instance['orderby'] : esc_html__( '', 'tophot' );
		$tab_popular = ! empty( $instance['tab_popular'] ) ? $instance['tab_popular'] : esc_html__( '', 'tophot' );
		$tab_hot = ! empty( $instance['tab_hot'] ) ? $instance['tab_hot'] : esc_html__( '', 'tophot' );
		$tab_trending = ! empty( $instance['tab_trending'] ) ? $instance['tab_trending'] : esc_html__( '', 'tophot' );
		$tab_posts = ! empty( $instance['tab_posts'] ) ? $instance['tab_posts'] : esc_html__( '', 'tophot' );
		$tab_videos = ! empty( $instance['tab_videos'] ) ? $instance['tab_videos'] : esc_html__( '', 'tophot' );
		$tab_galleries = ! empty( $instance['tab_galleries'] ) ? $instance['tab_galleries'] : esc_html__( '', 'tophot' );
		$author = ! empty( $instance['author'] ) ? $instance['author'] : esc_html__( '', 'tophot' );
		?>

		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php _e( esc_attr( 'Title:' ) ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'item_nr' ) ); ?>"><?php _e( esc_attr( 'Item Nr:' ) ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'item_nr' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'item_nr' ) ); ?>" type="text" value="<?php echo esc_attr( $item_nr ); ?>">
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'category' ) ); ?>"><?php _e( esc_attr( 'Category slug:' ) ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'category' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'category' ) ); ?>" type="text" value="<?php echo esc_attr( $category ); ?>">
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'tag' ) ); ?>"><?php _e( esc_attr( 'Tag slug:' ) ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'tag' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'tag' ) ); ?>" type="text" value="<?php echo esc_attr( $tag ); ?>">
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'author' ) ); ?>"><?php _e( esc_attr( 'Author slug:' ) ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'author' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'author' ) ); ?>" type="text" value="<?php echo esc_attr( $author ); ?>">
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'orderby' ) ); ?>"><?php _e( esc_attr( 'OrderBy:' ) ); ?></label>
			<select class='widefat' id="<?php echo $this->get_field_id('orderby'); ?>" name="<?php echo $this->get_field_name('orderby'); ?>" type="text">
				<option value='date'<?php echo ($orderby=='date')?'selected':''; ?>>Date</option>
				<option value='popular'<?php echo ($orderby=='popular')?'selected':''; ?>>Most Viewed</option>
				<option value='comment_count'<?php echo ($orderby=='comment_count')?'selected':''; ?>>Comment Count</option>
				<option value='shares'<?php echo ($orderby=='shares')?'selected':''; ?>>Shares</option>
			</select>
		</p>

		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'tab_popular' ) ); ?>"><?php _e( esc_attr( 'Tab: Popular:' ) ); ?></label>
			<select class='widefat' id="<?php echo $this->get_field_id('tab_popular'); ?>" name="<?php echo $this->get_field_name('tab_popular'); ?>" type="text">
				<option value='off'<?php echo ($tab_popular=='off')?'selected':''; ?>>Disable</option>
				<option value='date'<?php echo ($tab_popular=='date')?'selected':''; ?>>Date</option>
				<option value='popular'<?php echo ($tab_popular=='popular')?'selected':''; ?>>Most Viewed</option>
				<option value='comment_count'<?php echo ($tab_popular=='comment_count')?'selected':''; ?>>Comment Count</option>
				<option value='shares'<?php echo ($tab_popular=='shares')?'selected':''; ?>>Shares</option>
			</select>
		</p>

		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'tab_hot' ) ); ?>"><?php _e( esc_attr( 'Tab: Hot:' ) ); ?></label>
			<select class='widefat' id="<?php echo $this->get_field_id('tab_hot'); ?>" name="<?php echo $this->get_field_name('tab_hot'); ?>" type="text">
				<option value='off'<?php echo ($tab_hot=='off')?'selected':''; ?>>Disable</option>
				<option value='date'<?php echo ($tab_hot=='date')?'selected':''; ?>>Date</option>
				<option value='popular'<?php echo ($tab_hot=='popular')?'selected':''; ?>>Most Viewed</option>
				<option value='comment_count'<?php echo ($tab_hot=='comment_count')?'selected':''; ?>>Comment Count</option>
				<option value='shares'<?php echo ($tab_hot=='shares')?'selected':''; ?>>Shares</option>
			</select>
		</p>

		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'tab_trending' ) ); ?>"><?php _e( esc_attr( 'Tab: Trending:' ) ); ?></label>
			<select class='widefat' id="<?php echo $this->get_field_id('tab_trending'); ?>" name="<?php echo $this->get_field_name('tab_trending'); ?>" type="text">
				<option value='off'<?php echo ($tab_trending=='off')?'selected':''; ?>>Disable</option>
				<option value='date'<?php echo ($tab_trending=='date')?'selected':''; ?>>Date</option>
				<option value='popular'<?php echo ($tab_trending=='popular')?'selected':''; ?>>Most Viewed</option>
				<option value='comment_count'<?php echo ($tab_trending=='comment_count')?'selected':''; ?>>Comment Count</option>
				<option value='shares'<?php echo ($tab_trending=='shares')?'selected':''; ?>>Shares</option>
			</select>
		</p>

		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'tab_posts' ) ); ?>"><?php _e( esc_attr( 'Tab: Posts:' ) ); ?></label>
			<select class='widefat' id="<?php echo $this->get_field_id('tab_posts'); ?>" name="<?php echo $this->get_field_name('tab_posts'); ?>" type="text">
				<option value='on'<?php echo ($tab_posts=='on')?'selected':''; ?>>Enabled</option>
				<option value='off'<?php echo ($tab_posts=='off')?'selected':''; ?>>Disable</option>
			</select>
		</p>

		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'tab_videos' ) ); ?>"><?php _e( esc_attr( 'Tab: Videos:' ) ); ?></label>
			<select class='widefat' id="<?php echo $this->get_field_id('tab_videos'); ?>" name="<?php echo $this->get_field_name('tab_videos'); ?>" type="text">
				<option value='on'<?php echo ($tab_videos=='on')?'selected':''; ?>>Enabled</option>
				<option value='off'<?php echo ($tab_videos=='off')?'selected':''; ?>>Disable</option>
			</select>
		</p>

		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'tab_galleries' ) ); ?>"><?php _e( esc_attr( 'Tab: Galleries:' ) ); ?></label>
			<select class='widefat' id="<?php echo $this->get_field_id('tab_galleries'); ?>" name="<?php echo $this->get_field_name('tab_galleries'); ?>" type="text">
				<option value='on'<?php echo ($tab_galleries=='on')?'selected':''; ?>>Enabled</option>
				<option value='off'<?php echo ($tab_galleries=='off')?'selected':''; ?>>Disable</option>
			</select>
		</p>



		<?php
	}

	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['item_nr'] = ( ! empty( $new_instance['item_nr'] ) ) ? strip_tags( $new_instance['item_nr'] ) : '';
		$instance['category'] = ( ! empty( $new_instance['category'] ) ) ? strip_tags( $new_instance['category'] ) : '';
		$instance['tag'] = ( ! empty( $new_instance['tag'] ) ) ? strip_tags( $new_instance['tag'] ) : '';
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
		$instance['orderby'] = ( ! empty( $new_instance['orderby'] ) ) ? strip_tags( $new_instance['orderby'] ) : '';
		$instance['tab_popular'] = ( ! empty( $new_instance['tab_popular'] ) ) ? strip_tags( $new_instance['tab_popular'] ) : '';
		$instance['tab_hot'] = ( ! empty( $new_instance['tab_hot'] ) ) ? strip_tags( $new_instance['tab_hot'] ) : '';
		$instance['tab_trending'] = ( ! empty( $new_instance['tab_trending'] ) ) ? strip_tags( $new_instance['tab_trending'] ) : '';
		$instance['tab_posts'] = ( ! empty( $new_instance['tab_posts'] ) ) ? strip_tags( $new_instance['tab_posts'] ) : '';
		$instance['tab_videos'] = ( ! empty( $new_instance['tab_videos'] ) ) ? strip_tags( $new_instance['tab_videos'] ) : '';
		$instance['tab_galleries'] = ( ! empty( $new_instance['tab_galleries'] ) ) ? strip_tags( $new_instance['tab_galleries'] ) : '';
		$instance['author'] = ( ! empty( $new_instance['author'] ) ) ? strip_tags( $new_instance['author'] ) : '';
		return $instance;
	}

}

function register_post_tabs_widget() {
    register_widget( 'Post_Tabs_Widget' );
}
add_action( 'widgets_init', 'register_post_tabs_widget' );
?>
