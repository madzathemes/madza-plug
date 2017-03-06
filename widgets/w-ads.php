<?php
class Ads_Widget extends WP_Widget {

	function __construct() {
		parent::__construct(
			'ad_widget',
			__( 'mt Ad', 'tophot' ),
			array( 'description' => esc_html__( 'A Ad Widget', 'tophot' ), )
		);
	}

	public function widget( $args, $instance ) {
		echo $args['before_widget'];

		$position = "center";
		$type = "";

		if ( ! empty( $instance['type'] ) ) { $type = $instance['type']; }
		if ( ! empty( $instance['position'] ) ) { $position = $instance['position'];	}

		echo do_shortcode("[ad type='$type' position='$position']");

		echo $args['after_widget'];
	}

	public function form( $instance ) {
		$type = ! empty( $instance['type'] ) ? $instance['type'] : esc_html__( 'middle', 'tophot' );
		$position = ! empty( $instance['position'] ) ? $instance['position'] : esc_html__( '', 'tophot' );
		?>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'type' ) ); ?>"><?php _e( esc_attr( 'Type:' ) ); ?></label>
			<select class='widefat' id="<?php echo $this->get_field_id('type'); ?>" name="<?php echo $this->get_field_name('type'); ?>" type="text">
	      <option value='custom-ad-1'<?php echo ($type=='custom-ad-1')?'selected':''; ?>>Custom ad 1</option>
	      <option value='custom-ad-2'<?php echo ($type=='custom-ad-2')?'selected':''; ?>>Custom ad 2</option>
				<option value='custom-ad-3'<?php echo ($type=='custom-ad-3')?'selected':''; ?>>Custom ad 3</option>
				<option value='custom-ad-4'<?php echo ($type=='custom-ad-4')?'selected':''; ?>>Custom ad 4</option>
				<option value='custom-ad-5'<?php echo ($type=='custom-ad-5')?'selected':''; ?>>Custom ad 5</option>
				<option value='custom-ad-6'<?php echo ($type=='custom-ad-6')?'selected':''; ?>>Custom ad 6</option>
				<option value='custom-ad-7'<?php echo ($type=='custom-ad-7')?'selected':''; ?>>Custom ad 7</option>
				<option value='custom-ad-8'<?php echo ($type=='custom-ad-8')?'selected':''; ?>>Custom ad 8</option>
				<option value='custom-ad-9'<?php echo ($type=='custom-ad-9')?'selected':''; ?>>Custom ad 9</option>
				<option value='sidebar-ad-top'<?php echo ($type=='sidebar-ad-top')?'selected':''; ?>>Sidebar top ad</option>
	      <option value='sidebar-ad-middle'<?php echo ($type=='sidebar-ad-middle')?'selected':''; ?>>Sidebar middle ad</option>
				<option value='sidebar-ad-bottom'<?php echo ($type=='sidebar-ad-bottom')?'selected':''; ?>>Sidebar bottom ad</option>
				<option value='article-ad-bottom'<?php echo ($type=='article-ad-bottom')?'selected':''; ?>>Article bottom ad</option>
				<option value='footer-ad-top'<?php echo ($type=='footer-ad-top')?'selected':''; ?>>Footer top ad</option>
	    </select>
		</p>
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
		$instance['type'] = ( ! empty( $new_instance['type'] ) ) ? strip_tags( $new_instance['type'] ) : '';
		$instance['position'] = ( ! empty( $new_instance['position'] ) ) ? strip_tags( $new_instance['position'] ) : '';

		return $instance;
	}

}

add_action( 'widgets_init', 'register_ads_widget' );
function register_ads_widget() {
    register_widget( 'Ads_Widget' );
}
?>
