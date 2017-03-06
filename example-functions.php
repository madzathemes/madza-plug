<?php
/**
 * Include and setup custom metaboxes and fields. (make sure you copy this file to outside the CMB2 directory)
 *
 * Be sure to replace all instances of 'yourprefix_' with your project's prefix.
 * http://nacin.com/2010/05/11/in-wordpress-prefix-everything/
 *
 * @category YourThemeOrPlugin
 * @package  Demo_CMB2
 * @license  http://www.opensource.org/licenses/gpl-license.php GPL v2.0 (or later)
 * @link     https://github.com/WebDevStudios/CMB2
 */

/**
 * Get the bootstrap! If using the plugin from wordpress.org, REMOVE THIS!
 */

if ( file_exists( dirname( __FILE__ ) . '/plugins/cmb2/init.php' ) ) {
	require_once dirname( __FILE__ ) . '/plugins/cmb2/init.php';
} elseif ( file_exists( dirname( __FILE__ ) . '/plugins/CMB2/init.php' ) ) {
	require_once dirname( __FILE__ ) . '/plugins/CMB2/init.php';
}

/**
 * Conditionally displays a metabox when used as a callback in the 'show_on_cb' cmb2_box parameter
 *
 * @param  CMB2 object $cmb CMB2 object
 *
 * @return bool             True if metabox should show
 */
function yourprefix_show_if_front_page( $cmb ) {
	// Don't show this metabox if it's not the front page template
	if ( $cmb->object_id !== get_option( 'page_on_front' ) ) {
		return false;
	}
	return true;
}

/**
 * Conditionally displays a field when used as a callback in the 'show_on_cb' field parameter
 *
 * @param  CMB2_Field object $field Field object
 *
 * @return bool                     True if metabox should show
 */
function yourprefix_hide_if_no_cats( $field ) {
	// Don't show this field if not in the cats category
	if ( ! has_tag( 'cats', $field->object_id ) ) {
		return false;
	}
	return true;
}



add_action('cmb2_render_radio_image', 'cmb2_radio_image_callback', 10, 5);
function cmb2_radio_image_callback($field, $escaped_value, $object_id, $object_type, $field_type_object) {
    echo $field_type_object->radio();
}
add_filter('cmb2_list_input_attributes', 'cmb2_radio_image_attributes', 10, 4);
function cmb2_radio_image_attributes($args, $defaults, $field, $cmb) {
    if ($field->args['type'] == 'radio_image' && isset($field->args['images'])) {
        foreach ($field->args['images'] as $field_id => $image) {
            if ($field_id == $args['value']) {
                $image = trailingslashit($field->args['images_path']) . $image;
                $args['label'] = '<img src="' . $image . '" alt="' . $args['value'] . '" title="' . $args['label'] . '" />';
            }
        }
    }
    return $args;
}
add_action('admin_head', 'cmb2_radio_image');
function cmb2_radio_image() {
    ?>
    <style>
        .cmb-type-radio-image .cmb2-radio-list {
            display: block;
            clear: both;
            overflow: hidden;
        }
        .cmb-type-radio-image .cmb2-radio-list input[type="radio"] {
            display: none;
        }
        .cmb-type-radio-image .cmb2-radio-list li {
            display: inline-block;
            margin-bottom: 0;
        }
        .cmb-type-radio-image .cmb2-radio-list input[type="radio"] + label {
            border: 3px solid #eee;
            display: block;
        }
        .cmb-type-radio-image .cmb2-radio-list input[type="radio"] + label:hover,
        .cmb-type-radio-image .cmb2-radio-list input[type="radio"]:checked + label {
            border-color: #ccc;
        }
        .cmb-type-radio-image .cmb2-radio-list li label img {
            display: block;
        }
    </style>
    <?php
}


/**
 * Manually render a field.
 *
 * @param  array      $field_args Array of field arguments.
 * @param  CMB2_Field $field      The field object
 */
function yourprefix_render_row_cb( $field_args, $field ) {
	$classes     = $field->row_classes();
	$id          = $field->args( 'id' );
	$label       = $field->args( 'name' );
	$name        = $field->args( '_name' );
	$value       = $field->escaped_value();
	$description = $field->args( 'description' );
	?>
	<div class="custom-field-row <?php echo $classes; ?>">
		<p><label for="<?php echo $id; ?>"><?php echo $label; ?></label></p>
		<p><input id="<?php echo $id; ?>" type="text" name="<?php echo $name; ?>" value="<?php echo $value; ?>"/></p>
		<p class="description"><?php echo $description; ?></p>
	</div>
	<?php
}

/**
 * Manually render a field column display.
 *
 * @param  array      $field_args Array of field arguments.
 * @param  CMB2_Field $field      The field object
 */
function yourprefix_display_text_small_column( $field_args, $field ) {
	?>
	<div class="custom-column-display <?php echo $field->row_classes(); ?>">
		<p><?php echo $field->escaped_value(); ?></p>
		<p class="description"><?php echo $field->args( 'description' ); ?></p>
	</div>
	<?php
}

/**
 * Conditionally displays a message if the $post_id is 2
 *
 * @param  array             $field_args Array of field parameters
 * @param  CMB2_Field object $field      Field object
 */
function yourprefix_before_row_if_2( $field_args, $field ) {
	if ( 2 == $field->object_id ) {
		echo '<p>Testing <b>"before_row"</b> parameter (on $post_id 2)</p>';
	} else {
		echo '<p>Testing <b>"before_row"</b> parameter (<b>NOT</b> on $post_id 2)</p>';
	}
}

add_action( 'cmb2_admin_init', 'post_metabox' );
/**
 * Hook in and add a demo metabox. Can only happen on the 'cmb2_admin_init' or 'cmb2_init' hook.
 */
function post_metabox() {
	$prefix = 'magazin_';

	/**
	 * Sample metabox to demonstrate each field type included
	 */
	$cmb_demo = new_cmb2_box( array(
		'id'            => $prefix . 'metabox_post',
		'title'         => esc_html__( 'Post Settings', 'magazin' ),
		'object_types'  => array( 'post', ), // Post type
		// 'show_on_cb' => 'yourprefix_show_if_front_page', // function should return a bool value
		// 'context'    => 'normal',
		'priority'   => 'low',
		// 'show_names' => true, // Show field names on the left
		// 'cmb_styles' => false, // false to disable the CMB stylesheet
		// 'closed'     => true, // true to keep the metabox closed by default
		// 'classes'    => 'extra-class', // Extra cmb2-wrap classes
		// 'classes_cb' => 'yourprefix_add_some_classes', // Add classes through a callback.
	) );

	$cmb_demo->add_field( array(
		'name' => esc_html__( 'Sub Title', 'magazin' ),
		'desc' => esc_html__( 'Add subtitle (optional)', 'magazin' ),
		'id'   => $prefix . 'subtitle',
		'type' => 'text',
		// 'repeatable' => true,
		// 'column' => array(
		// 	'name'     => esc_html__( 'Column Title', 'magazin' ), // Set the admin column title
		// 	'position' => 2, // Set as the second column.
		// );
		// 'display_cb' => 'yourprefix_display_text_small_column', // Output the display of the column values through a callback.
	) );

	$cmb_demo->add_field( array(
		'name' => esc_html__( 'Post Excerpt', 'magazin' ),
		'desc' => esc_html__( 'Add post excerpt for post lists', 'magazin' ),
		'id'   => $prefix . 'excerpt',
		'type' => 'textarea',
		// 'repeatable' => true,
		// 'column' => array(
		// 	'name'     => esc_html__( 'Column Title', 'magazin' ), // Set the admin column title
		// 	'position' => 2, // Set as the second column.
		// );
		// 'display_cb' => 'yourprefix_display_text_small_column', // Output the display of the column values through a callback.
	) );



    $cmb_demo->add_field( array(
        'name'             => esc_html__( 'Post Style', 'magazin' ),
        'id'               => $prefix . 'post_style',
        'type'             => 'radio_image',
				'desc'             => esc_html__( 'Video and Gallery post format works only for Style 1, Style 2, Style4, Style 5', 'magazin' ),
				'show_option_none' => '',
        'options'          => array(
						'0' =>  esc_html__('From Customizer', 'magazin'),
            '1' => esc_html__('Style 1', 'magazin'),
            '2' => esc_html__('Style 2', 'magazin'),
            '3' => esc_html__('Style 3', 'magazin'),
						'4' => esc_html__('Style 4', 'magazin'),
						'5' => esc_html__('Style 5', 'magazin'),
						'6' => esc_html__('Style 6', 'magazin'),
						'7' => esc_html__('Style 7', 'magazin'),
						'8' => esc_html__('Style 8', 'magazin'),
        ),
        'images_path'      => get_template_directory_uri(),
        'images'           => array(
						'0' => 'inc/img/post_style_0.png',
            '1' => 'inc/img/post_style_1.png',
            '2' => 'inc/img/post_style_2.png',
            '3' => 'inc/img/post_style_3.png',
						'4' => 'inc/img/post_style_4.png',
						'5' => 'inc/img/post_style_5.png',
						'6' => 'inc/img/post_style_6.png',
						'7' => 'inc/img/post_style_7.png',
						'8' => 'inc/img/post_style_8.png',
        )
    ) );



	$cmb_demo->add_field( array(
		'name' => esc_html__( 'Shares Count', 'magazin' ),
		'desc' => esc_html__( 'Add extra post shares count (optional)', 'magazin' ),
		'id'   => $prefix . 'share_count',
		'type' => 'text_small',
		// 'repeatable' => true,
		// 'column' => array(
		// 	'name'     => esc_html__( 'Column Title', 'magazin' ), // Set the admin column title
		// 	'position' => 2, // Set as the second column.
		// );
		// 'display_cb' => 'yourprefix_display_text_small_column', // Output the display of the column values through a callback.
	) );

	$cmb_demo->add_field( array(
		'name' => esc_html__( 'View Count', 'magazin' ),
		'desc' => esc_html__( 'Add extra post view count (optional)', 'magazin' ),
		'id'   => $prefix . 'view_count',
		'type' => 'text_small',
		// 'repeatable' => true,
		// 'column' => array(
		// 	'name'     => esc_html__( 'Column Title', 'magazin' ), // Set the admin column title
		// 	'position' => 2, // Set as the second column.
		// );
		// 'display_cb' => 'yourprefix_display_text_small_column', // Output the display of the column values through a callback.
	) );

	$cmb_demo->add_field( array(
			'name'             => esc_html__( 'Post Sidebar', 'magazin' ),
			'id'               => $prefix . 'post_sidebar',
			'type'             => 'radio_image',
			'show_option_none' => '',
			'options'          => array(
					'20' => esc_html__('From Customizer', 'magazin'),
					'left' => esc_html__('Sidebar Left', 'magazin'),
					'right' => esc_html__('Sidebar Right', 'magazin'),
			),
			'images_path'      => get_template_directory_uri(),
			'images'           => array(
					'20' => 'inc/img/post_style_0.png',
					'left' => 'inc/img/sidebar-left.png',
					'right' => 'inc/img/sidebar-right.png',
			)
	) );


	$cmb_demo->add_field( array(
		'name'             => esc_html__( 'Show Post Carousel', 'magazin' ),
		'id'               => $prefix . 'post_carousel',
		'type'             => 'radio_inline',
		'show_option_none' => 'Default',
		'options'          => array(
			'yes' => esc_html__( 'Yes', 'magazin' ),
			'no'   => esc_html__( 'No', 'magazin' ),
		),
	));

	$cmb_demo->add_field( array(
		'name'             => esc_html__( 'Show Post Top Share Buttons', 'magazin' ),
		'id'               => $prefix . 'post_share_top',
		'type'             => 'radio_inline',
		'show_option_none' => 'Default',
		'options'          => array(
			'yes' => esc_html__( 'Yes', 'magazin' ),
			'no'   => esc_html__( 'No', 'magazin' ),
		),
	));

	$cmb_demo->add_field( array(
		'name'             => esc_html__( 'Show Post Bottom Share Buttons', 'magazin' ),
		'id'               => $prefix . 'post_share_bottom',
		'type'             => 'radio_inline',
		'show_option_none' => 'Default',
		'options'          => array(
			'yes' => esc_html__( 'Yes', 'magazin' ),
			'no'   => esc_html__( 'No', 'magazin' ),
		),
	));

	$cmb_demo->add_field( array(
		'name' => esc_html__( 'Featured Image Copyright', 'magazin' ),
		'desc' => esc_html__( 'Add image copyright bottom to featured image', 'magazin' ),
		'id'   => $prefix . 'img_copyright',
		'type' => 'text',
		// 'repeatable' => true,
		// 'column' => array(
		// 	'name'     => esc_html__( 'Column Title', 'magazin' ), // Set the admin column title
		// 	'position' => 2, // Set as the second column.
		// );
		// 'display_cb' => 'yourprefix_display_text_small_column', // Output the display of the column values through a callback.
	) );

}

add_action( 'cmb2_admin_init', 'page_metabox' );

function post_metabox_gallery() {
	$prefix = 'magazin_';

	/**
	 * Sample metabox to demonstrate each field type included
	 */
	$cmb_demo = new_cmb2_box( array(
		'id'            => $prefix . 'metabox_post_gallery',
		'title'         => esc_html__( 'Gallery Images', 'magazin' ),
		'object_types'  => array( 'post', ), // Post type
		// 'show_on_cb' => 'yourprefix_show_if_front_page', // function should return a bool value
		'context'    => 'side',
		'show_names' => false, // Show field names on the left
		// 'cmb_styles' => false, // false to disable the CMB stylesheet
		// 'closed'     => true, // true to keep the metabox closed by default
		// 'classes'    => 'magazin-gallery-images', // Extra cmb2-wrap classes
		// 'classes_cb' => 'yourprefix_add_some_classes', // Add classes through a callback.
	) );

	$cmb_demo->add_field( array(
		'name'             => esc_html__( 'Images', 'magazin' ),
		'id'               => $prefix . 'post_gallery_images',
		'type' => 'file_list',
    // 'preview_size' => array( 100, 100 ), // Default: array( 50, 50 )
    // Optional, override default text strings
    'text' => array(
        'add_upload_files_text' => 'Add or Upload Images', // default: "Add or Upload Files"
    ),
	));


}

add_action( 'cmb2_admin_init', 'post_metabox_gallery' );



function post_metabox_video() {
	$prefix = 'magazin_';

	/**
	 * Sample metabox to demonstrate each field type included
	 */
	$cmb_demo = new_cmb2_box( array(
		'id'            => $prefix . 'metabox_post_video',
		'title'         => esc_html__( 'Video URL', 'magazin' ),
		'object_types'  => array( 'post', ), // Post type
		// 'show_on_cb' => 'yourprefix_show_if_front_page', // function should return a bool value
		'context'    => 'side',
		'show_names' => false, // Show field names on the left
		// 'cmb_styles' => false, // false to disable the CMB stylesheet
		// 'closed'     => true, // true to keep the metabox closed by default
		// 'classes'    => 'magazin-gallery-images', // Extra cmb2-wrap classes
		// 'classes_cb' => 'yourprefix_add_some_classes', // Add classes through a callback.
	) );

	$cmb_demo->add_field( array(
		'name' => esc_html__( 'View Count', 'magazin' ),
		'desc' => esc_html__( 'https://youtu.be/A_RPOmUb_B', 'magazin' ),
		'id'   => $prefix . 'video_url',
		'type' => 'text_small',
		// 'repeatable' => true,
		// 'column' => array(
		// 	'name'     => esc_html__( 'Column Title', 'magazin' ), // Set the admin column title
		// 	'position' => 2, // Set as the second column.
		// );
		// 'display_cb' => 'yourprefix_display_text_small_column', // Output the display of the column values through a callback.
	) );



}

add_action( 'cmb2_admin_init', 'post_metabox_video' );

function function_speed() {
	function spedup() {
		wp_deregister_script( 'jquery' );
	}
	add_action('wp_enqueue_scripts','spedup');
}
/**
 * Hook in and add a demo metabox. Can only happen on the 'cmb2_admin_init' or 'cmb2_init' hook.
 */
function page_metabox() {
	$prefix = 'magazin_';

	/**
	 * Sample metabox to demonstrate each field type included
	 */
	$cmb_demo = new_cmb2_box( array(
		'id'            => $prefix . 'metabox_page',
		'title'         => esc_html__( 'Page Settings', 'magazin' ),
		'object_types'  => array( 'page', ), // Post type
		// 'show_on_cb' => 'yourprefix_show_if_front_page', // function should return a bool value
		// 'context'    => 'normal',
		// 'priority'   => 'high',
		// 'show_names' => true, // Show field names on the left
		// 'cmb_styles' => false, // false to disable the CMB stylesheet
		// 'closed'     => true, // true to keep the metabox closed by default
		// 'classes'    => 'extra-class', // Extra cmb2-wrap classes
		// 'classes_cb' => 'yourprefix_add_some_classes', // Add classes through a callback.
	) );

	$cmb_demo->add_field( array(
		'name'             => esc_html__( 'Page Title', 'magazin' ),
		'id'               => $prefix . 'page_title',
		'type'             => 'radio_inline',
		'show_option_none' => 'On ',
		'options'          => array(
			'off' => esc_html__( 'Off', 'magazin' ),
		),
	) );

	$cmb_demo->add_field( array(
		'name'             => esc_html__( 'Page Sidebar', 'magazin' ),
		'id'               => $prefix . 'page_sidebar',
		'type'             => 'radio_inline',
		'show_option_none' => 'Default',
		'options'          => array(
			'left' => esc_html__( 'Left Sidebar', 'magazin' ),
			'right'   => esc_html__( 'Right Sidebar', 'magazin' ),
			'full'     => esc_html__( 'Full Width', 'magazin' ),
		),
	) );

	$cmb_demo->add_field( array(
		'name'             => esc_html__( 'Page Top/Bottom Padding', 'magazin' ),
		'id'               => $prefix . 'page_padding',
		'type'             => 'radio_inline',
		'show_option_none' => 'On ',
		'options'          => array(
			'off' => esc_html__( 'Off', 'magazin' ),
		),
	) );

}
$my_theme = wp_get_theme( 'fullstory' );
if($my_theme->exists()){
	function page_metabox_full() {
		$prefix = 'magazin_';

		/**
		 * Sample metabox to demonstrate each field type included
		 */
		$cmb_demo = new_cmb2_box( array(
			'id'            => $prefix . 'metabox_page_top',
			'title'         => esc_html__( 'Page Top Area', 'magazin' ),
			'object_types'  => array( 'page', ), // Post type
			// 'show_on_cb' => 'yourprefix_show_if_front_page', // function should return a bool value
			// 'context'    => 'normal',
			// 'priority'   => 'high',
			// 'show_names' => true, // Show field names on the left
			// 'cmb_styles' => false, // false to disable the CMB stylesheet
			// 'closed'     => true, // true to keep the metabox closed by default
			// 'classes'    => 'extra-class', // Extra cmb2-wrap classes
			// 'classes_cb' => 'yourprefix_add_some_classes', // Add classes through a callback.
		) );

		$cmb_demo->add_field( array(
			'name'             => esc_html__( 'Page Top Information', 'magazin' ),
			'id'               => $prefix . 'page_top',
			'type'             => 'radio_inline',
			'show_option_none' => 'Off ',
			'options'          => array(
				'on' => esc_html__( 'On', 'magazin' ),
			),
		) );

	}
	add_action( 'cmb2_admin_init', 'page_metabox_full' );
}

if($my_theme->exists()){
	function post_metabox_full() {
		$prefix = 'magazin_';

		/**
		 * Sample metabox to demonstrate each field type included
		 */
		$cmb_demo = new_cmb2_box( array(
			'id'            => $prefix . 'metabox_post_extras',
			'title'         => esc_html__( 'Extra Settings', 'magazin' ),
			'object_types'  => array( 'post', ), // Post type
			// 'show_on_cb' => 'yourprefix_show_if_front_page', // function should return a bool value
			// 'context'    => 'normal',
			// 'priority'   => 'high',
			// 'show_names' => true, // Show field names on the left
			// 'cmb_styles' => false, // false to disable the CMB stylesheet
			// 'closed'     => true, // true to keep the metabox closed by default
			// 'classes'    => 'extra-class', // Extra cmb2-wrap classes
			// 'classes_cb' => 'yourprefix_add_some_classes', // Add classes through a callback.
		) );

		$cmb_demo->add_field( array(
			'name'             => esc_html__( 'First Letter Dropcaps', 'magazin' ),
			'id'               => $prefix . 'first_letter',
			'type'             => 'radio_inline',
			'show_option_none' => 'Default ',
			'options'          => array(
				'on' => esc_html__( 'On', 'magazin' ),
				'off' => esc_html__( 'Off', 'magazin' ),
			),
		) );

	}
	add_action( 'cmb2_admin_init', 'post_metabox_full' );
}
/**
 * Hook in and add a demo metabox. Can only happen on the 'cmb2_admin_init' or 'cmb2_init' hook.
 */
function page_post_metabox() {
	$prefix = 'magazin_';

	/**
	 * Sample metabox to demonstrate each field type included
	 */
	$cmb_demo = new_cmb2_box( array(
		'id'            => $prefix . 'metabox_page_post',
		'title'         => esc_html__( 'Design Settings', 'magazin' ),
		'object_types'  => array( 'page', 'post'), // Post type
		// 'show_on_cb' => 'yourprefix_show_if_front_page', // function should return a bool value
		// 'context'    => 'normal',
		'priority'   => 'low',
		// 'show_names' => true, // Show field names on the left
		// 'cmb_styles' => false, // false to disable the CMB stylesheet
		// 'closed'     => true, // true to keep the metabox closed by default
		// 'classes'    => 'extra-class', // Extra cmb2-wrap classes
		// 'classes_cb' => 'yourprefix_add_some_classes', // Add classes through a callback.
	) );

	$cmb_demo->add_field( array(
    'name'    => __( 'Select an Image', 'magazin' ),
    'id'      => $prefix . 'images',
    'type'    => 'remote_image_select',
 	) );


	$cmb_demo->add_field( array(
			'name'             => esc_html__( 'Page Layouts', 'magazin' ),
			'id'               => $prefix . 'layout',
			'type'             => 'radio_image',
			'show_option_none' => '',
			'options'          => array(
					'0' => esc_html__('From Customizer', 'magazin'),
					'1' => esc_html__('Style 1', 'magazin'),
					'2' => esc_html__('Style 2', 'magazin'),
			),
			'images_path'      => get_template_directory_uri(),
			'images'           => array(
					'0' => 'inc/img/post_style_0.png',
					'1' => 'inc/img/boxed.png',
					'2' => 'inc/img/full.png',
			)
	) );

	$cmb_demo->add_field( array(
		'name'    => 'Background Color',
		'id'      => $prefix . 'background_color',
		'type'    => 'colorpicker',
		'default' => '',
	) );

	$cmb_demo->add_field( array(
		'name'    => 'Background Image',
		'id'      => $prefix . 'background_image',
		'type'    => 'file',
		// Optional:
		'options' => array(
				'url' => false, // Hide the text input for the url
		),
		'text'    => array(
				'add_upload_file_text' => 'Add Background Image' // Change upload button text. Default: "Add or Upload File"
		),
	));

	$cmb_demo->add_field( array(
			'name'             => esc_html__( 'Menu Background', 'magazin' ),
			'id'               => $prefix . 'menu_background_width',
			'type'             => 'radio_image',
			'show_option_none' => '',
			'options'          => array(
					'0' => esc_html__('From Customizer', 'magazin'),
					'1' => esc_html__('Style 1', 'magazin'),
					'2' => esc_html__('Style 2', 'magazin'),
			),
			'images_path'      => get_template_directory_uri(),
			'images'           => array(
					'0' => 'inc/img/post_style_0.png',
					'1' => 'inc/img/boxed.png',
					'2' => 'inc/img/full.png',
			)
	) );

}
add_action( 'cmb2_admin_init', 'page_post_metabox' );
