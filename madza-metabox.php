<?php
function header_settings_metabox() {
	$prefix = 'madzaplug_';

	/**
	 * Sample metabox to demonstrate each field type included
	 */
	$settings = new_cmb2_box( array(
		'id'            => $prefix . 'metabox_header',
		'title'         => esc_html__( 'Header Settings', 'magazin' ),
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

	$settings->add_field( array(
    'name'    => 'Title Background Image',
    'desc'    => 'Upload an image for title background',
    'id'      => $prefix . 'title_bg',
    'type'    => 'file',
    // Optional:
    'options' => array(
        'url' => false, // Hide the text input for the url
    ),
    'text'    => array(
        'add_upload_file_text' => 'Add Background Image' // Change upload button text. Default: "Add or Upload File"
    )
	));


}
add_action( 'cmb2_admin_init', 'header_settings_metabox' );
?>
