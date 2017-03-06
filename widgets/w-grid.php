<?php
class Grid_Widget extends WP_Widget {

	function __construct() {
		parent::__construct(
			'grid_widget',
			__( 'mt Grid', 'tophot' ),
			array( 'description' => esc_html__( 'A Post Widget', 'tophot' ), )
		);
	}

	public function widget( $args, $instance ) {
		echo $args['before_widget'];

		$item_nr = "";
		$type = "normal";
		$offset = "";
		$category = "";
		$orderby = "";
		$author = "";
		$widget_id = "";
		$tag = "";
		$position = "";
		$title = "";
		$taxonomy = "";
		$taxonomy_term = "";

		if ( ! empty( $instance['type'] ) ) { $type = $instance['type']; }
		if ( ! empty( $instance['offset'] ) ) { $offset = $instance['offset'];	}
		if ( ! empty( $instance['category'] ) ) { $category = $instance['category'];	}
		if ( ! empty( $instance['orderby'] ) ) { $orderby = $instance['orderby'];	}
		if ( ! empty( $instance['tag'] ) ) { $tag = $instance['tag'];	}
		if ( ! empty( $instance['title'] ) ) { $title = $instance['title'];	}
		if ( ! empty( $instance['author'] ) ) { $author = $instance['author'];	}
		if ( ! empty( $instance['taxonomy'] ) ) { $taxonomy = $instance['taxonomy'];	}
		if ( ! empty( $instance['taxonomy_term'] ) ) { $taxonomy_term = $instance['taxonomy_term'];	}

		echo do_shortcode("[grid type='$type' tag='$tag' taxonomy='$taxonomy' taxonomy_term='$taxonomy_term' author='$author' title='$title' position='$position' offset='$offset' orderby='$orderby' category='$category']");

		echo $args['after_widget'];
	}

	public function form( $instance ) {
		$title = ! empty( $instance['title'] ) ? $instance['title'] : esc_html__( '', 'tophot' );
		$type = ! empty( $instance['type'] ) ? $instance['type'] : esc_html__( 'middle', 'tophot' );
		$offset = ! empty( $instance['offset'] ) ? $instance['offset'] : esc_html__( '', 'tophot' );
		$category = ! empty( $instance['category'] ) ? $instance['category'] : esc_html__( '', 'tophot' );
		$orderby = ! empty( $instance['orderby'] ) ? $instance['orderby'] : esc_html__( '', 'tophot' );
		$tag = ! empty( $instance['tag'] ) ? $instance['tag'] : esc_html__( '', 'tophot' );
		$author = ! empty( $instance['author'] ) ? $instance['author'] : esc_html__( '', 'tophot' );
		$taxonomy = ! empty( $instance['taxonomy'] ) ? $instance['taxonomy'] : esc_html__( '', 'tophot' );
		$taxonomy_term = ! empty( $instance['taxonomy_term'] ) ? $instance['taxonomy_term'] : esc_html__( '', 'tophot' );
		?>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php _e( esc_attr( 'Title:' ) ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'type' ) ); ?>"><?php _e( esc_attr( 'Style:' ) ); ?></label>
			<select class='widefat' id="<?php echo $this->get_field_id('type'); ?>" name="<?php echo $this->get_field_name('type'); ?>" type="text">
				<option value='1'<?php echo ($type=='1')?'selected':''; ?>>Style 1</option>
				<option value='2'<?php echo ($type=='2')?'selected':''; ?>>Style 2</option>
				<option value='3'<?php echo ($type=='3')?'selected':''; ?>>Style 3</option>
				<option value='4'<?php echo ($type=='4')?'selected':''; ?>>Style 4</option>
				<option value='5'<?php echo ($type=='5')?'selected':''; ?>>Style 5</option>
			</select>
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

		<?php
	}

	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['type'] = ( ! empty( $new_instance['type'] ) ) ? strip_tags( $new_instance['type'] ) : '';
		$instance['offset'] = ( ! empty( $new_instance['offset'] ) ) ? strip_tags( $new_instance['offset'] ) : '';
		$instance['category'] = ( ! empty( $new_instance['category'] ) ) ? strip_tags( $new_instance['category'] ) : '';
		$instance['tag'] = ( ! empty( $new_instance['tag'] ) ) ? strip_tags( $new_instance['tag'] ) : '';
		$instance['orderby'] = ( ! empty( $new_instance['orderby'] ) ) ? strip_tags( $new_instance['orderby'] ) : '';
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
		$instance['author'] = ( ! empty( $new_instance['author'] ) ) ? strip_tags( $new_instance['author'] ) : '';
		$instance['taxonomy'] = ( ! empty( $new_instance['taxonomy'] ) ) ? strip_tags( $new_instance['taxonomy'] ) : '';
		$instance['taxonomy_term'] = ( ! empty( $new_instance['taxonomy_term'] ) ) ? strip_tags( $new_instance['taxonomy_term'] ) : '';
		return $instance;
	}

}

function register_grid_widget() {
    register_widget( 'Grid_Widget' );
}
add_action( 'widgets_init', 'register_grid_widget' );
?>
