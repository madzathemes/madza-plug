<?php
class Posts_Widget extends WP_Widget {

	function __construct() {
		parent::__construct(
			'posts_widget',
			__( 'mt Posts', 'tophot' ),
			array( 'description' => esc_html__( 'A Post Widget', 'tophot' ), )
		);
	}

	public function widget( $args, $instance ) {
		echo $args['before_widget'];

		$item_nr = "";
		$type = "normal";
		$offset = "";
		$category = "";
		$title = "";
		$title_type = "";
		$orderby = "";
		$pagination = "";
		$tag = "";
		$author = "";
		$taxonomy = "";
		$taxonomy_term = "";
		$widget_id = "";

		if ( ! empty( $instance['type'] ) ) { $type = $instance['type']; }
		if ( ! empty( $instance['item_nr'] ) ) { $item_nr = $instance['item_nr'];	}
		if ( ! empty( $instance['offset'] ) ) { $offset = $instance['offset'];	}
		if ( ! empty( $instance['category'] ) ) { $category = $instance['category'];	}
		if ( ! empty( $instance['title'] ) ) { $title = $instance['title'];	}
		if ( ! empty( $instance['tag'] ) ) { $tag = $instance['tag'];	}
		if ( ! empty( $instance['title_type'] ) ) { $title_type = $instance['title_type'];	}
		if ( ! empty( $instance['orderby'] ) ) { $orderby = $instance['orderby'];	}
		if ( ! empty( $instance['pagination'] ) ) { $pagination = $instance['pagination'];	}
		if ( ! empty( $instance['author'] ) ) { $author = $instance['author'];	}
		if ( ! empty( $instance['taxonomy'] ) ) { $taxonomy = $instance['taxonomy'];	}
		if ( ! empty( $instance['taxonomy_term'] ) ) { $taxonomy_term = $instance['taxonomy_term'];	}

		echo do_shortcode("[posts type='$type' item_nr='$item_nr' taxonomy='$taxonomy' taxonomy_term='$taxonomy_term' author='$author' offset='$offset' orderby='$orderby' category='$category' tag='$tag' title='$title' pagination='$pagination' title_type='$title_type']");

		echo $args['after_widget'];
	}

	public function form( $instance ) {
		$type = ! empty( $instance['type'] ) ? $instance['type'] : esc_html__( 'middle', 'tophot' );
		$item_nr = ! empty( $instance['item_nr'] ) ? $instance['item_nr'] : esc_html__( '', 'tophot' );
		$offset = ! empty( $instance['offset'] ) ? $instance['offset'] : esc_html__( '', 'tophot' );
		$category = ! empty( $instance['category'] ) ? $instance['category'] : esc_html__( '', 'tophot' );
		$title = ! empty( $instance['title'] ) ? $instance['title'] : esc_html__( '', 'tophot' );
		$title_type = ! empty( $instance['title_type'] ) ? $instance['title_type'] : esc_html__( '', 'tophot' );
		$orderby = ! empty( $instance['orderby'] ) ? $instance['orderby'] : esc_html__( '', 'tophot' );
		$pagination = ! empty( $instance['pagination'] ) ? $instance['pagination'] : esc_html__( '', 'tophot' );
		$tag = ! empty( $instance['tag'] ) ? $instance['tag'] : esc_html__( '', 'tophot' );
		$author = ! empty( $instance['author'] ) ? $instance['author'] : esc_html__( '', 'tophot' );
		$taxonomy = ! empty( $instance['taxonomy'] ) ? $instance['taxonomy'] : esc_html__( '', 'tophot' );
		$taxonomy_term = ! empty( $instance['taxonomy_term'] ) ? $instance['taxonomy_term'] : esc_html__( '', 'tophot' );
		?>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'type' ) ); ?>"><?php _e( esc_attr( 'Type:' ) ); ?></label>
			<select class='widefat' id="<?php echo $this->get_field_id('type'); ?>" name="<?php echo $this->get_field_name('type'); ?>" type="text">
				<option value='small'<?php echo ($type=='small')?'selected':''; ?>>Small posts</option>
				<option value='small-two'<?php echo ($type=='small-two')?'selected':''; ?>>Small posts (Two Columns)</option>
				<option value='normal'<?php echo ($type=='normal')?'selected':''; ?>>Normal posts</option>
				<option value='normal-two'<?php echo ($type=='normal-two')?'selected':''; ?>>Normal posts (Two Columns)</option>
				<option value='normal-right'<?php echo ($type=='normal-right')?'selected':''; ?>>Normal posts (Right Text)</option>
				<option value='normal-right-small'<?php echo ($type=='normal-right-small')?'selected':''; ?>>Normal posts (Right Text) Small</option>
				<option value='carousel-post-slider'<?php echo ($type=='carousel-post-slider')?'selected':''; ?>>Carousel post slider</option>
			</select>
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'item_nr' ) ); ?>"><?php _e( esc_attr( 'Item Nr:' ) ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'item_nr' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'item_nr' ) ); ?>" type="text" value="<?php echo esc_attr( $item_nr ); ?>">
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'offset' ) ); ?>"><?php _e( esc_attr( 'Offset:' ) ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'offset' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'offset' ) ); ?>" type="text" value="<?php echo esc_attr( $offset ); ?>">
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
			<label for="<?php echo esc_attr( $this->get_field_id( 'taxonomy' ) ); ?>"><?php _e( esc_attr( 'Taxonomy:' ) ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'taxonomy' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'taxonomy' ) ); ?>" type="text" value="<?php echo esc_attr( $taxonomy ); ?>">
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'taxonomy_term' ) ); ?>"><?php _e( esc_attr( 'Taxonomy Term:' ) ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'taxonomy_term' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'taxonomy_term' ) ); ?>" type="text" value="<?php echo esc_attr( $taxonomy_term ); ?>">
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'orderby' ) ); ?>"><?php _e( esc_attr( 'OrderBy:' ) ); ?></label>
			<select class='widefat' id="<?php echo $this->get_field_id('orderby'); ?>" name="<?php echo $this->get_field_name('orderby'); ?>" type="text">
				<option value='date'<?php echo ($orderby=='date')?'selected':''; ?>>Date</option>
				<option value='popular'<?php echo ($orderby=='popular')?'selected':''; ?>>Most Viewed</option>
				<option value='comment_count'<?php echo ($orderby=='comment_count')?'selected':''; ?>>Comment Count</option>
				<option value='rand'<?php echo ($orderby=='rand')?'selected':''; ?>>Random</option>
				<option value='title'<?php echo ($orderby=='title')?'selected':''; ?>>Title</option>
				<option value='shares'<?php echo ($orderby=='shares')?'selected':''; ?>>Shares</option>
			</select>
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php _e( esc_attr( 'Title:' ) ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'title_type' ) ); ?>"><?php _e( esc_attr( 'Title Type:' ) ); ?></label>
			<select class='widefat' id="<?php echo $this->get_field_id('title_type'); ?>" name="<?php echo $this->get_field_name('title_type'); ?>" type="text">
				<option value='center'<?php echo ($title_type=='center')?'selected':''; ?>>Center</option>
				<option value='left'<?php echo ($title_type=='left')?'selected':''; ?>>Left</option>
				<option value='right'<?php echo ($title_type=='right')?'selected':''; ?>>Right</option>
			</select>
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'pagination' ) ); ?>"><?php _e( esc_attr( 'Pagination:' ) ); ?></label>
			<select class='widefat' id="<?php echo $this->get_field_id('pagination'); ?>" name="<?php echo $this->get_field_name('pagination'); ?>" type="text">
				<option value='off'<?php echo ($pagination=='off')?'selected':''; ?>>Off</option>
				<option value='on'<?php echo ($pagination=='on')?'selected':''; ?>>On</option>
			</select>
		</p>


		<?php
	}

	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['type'] = ( ! empty( $new_instance['type'] ) ) ? strip_tags( $new_instance['type'] ) : '';
		$instance['item_nr'] = ( ! empty( $new_instance['item_nr'] ) ) ? strip_tags( $new_instance['item_nr'] ) : '';
		$instance['offset'] = ( ! empty( $new_instance['offset'] ) ) ? strip_tags( $new_instance['offset'] ) : '';
		$instance['category'] = ( ! empty( $new_instance['category'] ) ) ? strip_tags( $new_instance['category'] ) : '';
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
		$instance['title_type'] = ( ! empty( $new_instance['title_type'] ) ) ? strip_tags( $new_instance['title_type'] ) : '';
		$instance['orderby'] = ( ! empty( $new_instance['orderby'] ) ) ? strip_tags( $new_instance['orderby'] ) : '';
		$instance['pagination'] = ( ! empty( $new_instance['pagination'] ) ) ? strip_tags( $new_instance['pagination'] ) : '';
		$instance['tag'] = ( ! empty( $new_instance['tag'] ) ) ? strip_tags( $new_instance['tag'] ) : '';
		$instance['author'] = ( ! empty( $new_instance['author'] ) ) ? strip_tags( $new_instance['author'] ) : '';
		$instance['taxonomy'] = ( ! empty( $new_instance['taxonomy'] ) ) ? strip_tags( $new_instance['taxonomy'] ) : '';
		$instance['taxonomy_term'] = ( ! empty( $new_instance['taxonomy_term'] ) ) ? strip_tags( $new_instance['taxonomy_term'] ) : '';
		return $instance;
	}

}

function register_posts_widget() {
    register_widget( 'Posts_Widget' );
}
add_action( 'widgets_init', 'register_posts_widget' );
?>
