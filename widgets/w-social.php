<?php
class Social_Widget extends WP_Widget {

	function __construct() {
		parent::__construct(
			'social_widget',
			__( 'mt Social', 'magazin' ),
			array( 'description' => esc_html__( 'A Social Widget', 'magazin' ), )
		);
	}

	public function widget( $args, $instance ) {
		echo $args['before_widget'];

		$position = "";
		$type = "";
		$title = esc_html__( 'Follow Us And get latest news', 'magazin' );

		if ( ! empty( $instance['title'] ) ) { $title = $instance['title'];	}

		echo do_shortcode("[social type='$type' position='$position' title='$title' ]");

		echo $args['after_widget'];
	}

	public function form( $instance ) {
		$title = ! empty( $instance['title'] ) ? $instance['title'] : esc_html__( '', 'magazin' );
		?>

		<p>
		<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php _e( esc_attr( 'Title:' ) ); ?></label>
		<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
		</p>
		<?php
	}

	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';

		return $instance;
	}

}

add_action( 'widgets_init', 'register_social_widget' );
function register_social_widget() {
    register_widget( 'Social_Widget' );
}
?>
