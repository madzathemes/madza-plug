<?php
class Subscribe_Widget extends WP_Widget {

	function __construct() {
		parent::__construct(
			'subscribe_widget',
			__( 'mt Subscribe', 'tophot' ),
			array( 'description' =>  esc_html__( 'A Subscribe Widget', 'tophot' ), )
		);
	}

	public function widget( $args, $instance ) {
		echo $args['before_widget'];

		$position = "center";
		$type = "";

		if ( ! empty( $instance['type'] ) ) { $type = $instance['type']; }
		if ( ! empty( $instance['position'] ) ) { $position = $instance['position'];	}

		echo do_shortcode("[subscribe position='$position']");

		echo $args['after_widget'];
	}

	public function form( $instance ) {
		$position = ! empty( $instance['position'] ) ? $instance['position'] : esc_html__( '', 'tophot' );
		?>

		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'position' ) ); ?>"><?php _e( esc_attr( 'Position:' ) ); ?></label>
			<select class='widefat' id="<?php echo $this->get_field_id('position'); ?>" name="<?php echo $this->get_field_name('position'); ?>" type="text">
	      <option value='center'<?php echo ($position=='center')?'selected':''; ?>>
	        center
	      </option>
	      <option value='right'<?php echo ($position=='right')?'selected':''; ?>>
	        right
	      </option>
	      <option value='left'<?php echo ($position=='left')?'selected':''; ?>>
	        left
	      </option>
	    </select>
		</p>
		<?php
	}

	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['position'] = ( ! empty( $new_instance['position'] ) ) ? strip_tags( $new_instance['position'] ) : '';

		return $instance;
	}

}

add_action( 'widgets_init', 'register_subscribe_widget' );
function register_subscribe_widget() {
    register_widget( 'Subscribe_Widget' );
}
?>
