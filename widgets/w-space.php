<?php
class Space_Widget extends WP_Widget {

	function __construct() {
		parent::__construct(
			'space_widget',
			__( 'mt Space', 'tophot' ),
			array( 'description' => esc_html__( 'Space Widget', 'tophot' ), )
		);
	}

	public function widget( $args, $instance ) {
		echo $args['before_widget'];

		$size = "10";

		if ( ! empty( $instance['size'] ) ) { $size = $instance['size']; }

		echo do_shortcode("[space size='$size']");

		echo $args['after_widget'];
	}

	public function form( $instance ) {
		$size = ! empty( $instance['size'] ) ? $instance['size'] : esc_html__( '40', 'tophot' );
		?>
		<p>
		<label for="<?php echo esc_attr( $this->get_field_id( 'size' ) ); ?>"><?php _e( esc_attr( 'Size:' ) ); ?></label>
		<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'size' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'size' ) ); ?>" type="text" value="<?php echo esc_attr( $size ); ?>">
		</p>

		<?php
	}

	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['size'] = ( ! empty( $new_instance['size'] ) ) ? strip_tags( $new_instance['size'] ) : '';

		return $instance;
	}

}

function register_space_widget() {
    register_widget( 'Space_Widget' );
}
add_action( 'widgets_init', 'register_space_widget' );



?>
