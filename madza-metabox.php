<?php

if(!empty($mt_o['mt_rewrite_doctor'])) { $mt_cpt_doctor = $mt_o['mt_rewrite_doctor']; } else { $mt_cpt_doctor = "our-staff";}
if(!empty($mt_o['mt_rewrite_services'])) { $mt_cpt_services = $mt_o['mt_rewrite_services']; } else { $mt_cpt_services = "our-services";}
if(!empty($mt_o['mt_rewrite_causes'])) { $mt_cpt_causes = $mt_o['mt_rewrite_causes']; } else { $mt_cpt_causes = "our-causes";}
if(!empty($mt_o['mt_rewrite_portfolio'])) { $mt_cpt_portfolio = $mt_o['mt_rewrite_portfolio']; } else { $mt_cpt_portfolio = "portfolio";}

function madza_services() {
global $mt_cpt_services;
  $labels = array(
    'name' => esc_html_x('Services', 'post type general name', 'madza_builder69'),
    'singular_name' => esc_html_x('Services', 'post type singular name', 'madza_builder69'),
    'add_new' => esc_html_x('Add Service', 'Partner Item', 'madza_builder69'),
    'add_new_item' => esc_html__('Add New Service', 'madza_builder69'),
    'edit_item' => esc_html__('Edit Service', 'madza_builder69'),
    'new_item' => esc_html__('New Service', 'madza_builder69'),
    'view_item' => esc_html__('View Service Details', 'madza_builder69'),
    'search_items' => esc_html__('Search Service', 'madza_builder69'),
    'not_found' =>  esc_html__('No Service were found with that criteria', 'madza_builder69'),
    'not_found_in_trash' => esc_html__('No Service found in the Trash with that criteria', 'madza_builder69'),
    'view' =>  esc_html__('View Service', 'madza_builder69')
  );

  $args = array(
    'labels' => $labels,
    'label' => esc_html__('Service', 'madza_builder69'),
    'singular_label' => esc_html__('Service', 'madza_builder69'),
    'public' => true,
    'show_ui' => true,
    '_builtin' => false,
    'capability_type' => 'post',
    'exclude_from_search' => true,
    'hierarchical' => true,
    'rewrite' => array('slug' => $mt_cpt_services),
    'menu_position' => 30,
    'menu_icon' => 'dashicons-index-card',
    'supports' => array('title', 'editor','thumbnail', 'revisions')
  );

  register_post_type('our-services',$args);

$labels = array(
  'name' => esc_html__('Categories', 'madza_builder69'),
  'singular_name' => esc_html__('Categories', 'madza_builder69'),
  'search_items' =>  esc_html__('Search', 'madza_builder69'),
  'popular_items' => esc_html__('Popular things', 'madza_builder69'),
  'all_items' => esc_html__( 'Everything' , 'madza_builder69'),
  'parent_item' => esc_html__( 'Parent Categories', 'madza_builder69' ),
  'parent_item_colon' => esc_html__( 'Parent Categories:' , 'madza_builder69'),
  'edit_item' => esc_html__( 'Edit' , 'madza_builder69'),
  'update_item' => esc_html__( 'Update' , 'madza_builder69'),
  'add_new_item' => esc_html__( 'Add New' , 'madza_builder69'),
  'new_item_name' => esc_html__( 'New Name' , 'madza_builder69')
);


register_taxonomy($mt_cpt_services.'_cat', array('our-services'),
	array(
	'hierarchical' => true,
	'labels' => $labels,
	'show_ui' => true,
	'query_var' => true,
	'rewrite' => array('slug' => 'service_categories')
));


}
add_action('init', 'madza_services');



add_action( 'admin_init', 'mt_service_metabox' );

function mt_service_metabox() {

  $mt_service_metabox = array(
    'id'        => 'mt_services_metabox',
    'title'     => 'Service Item Options',
    'desc'      => '',
    'pages' => array('our-services'),
    'context'   => 'normal',
    'priority'  => 'high',
    'fields'    => array(
     	array(
     	'id'          => 'mt_short_text',
        'label'       => 'Short Text',
        'std'         => '',
        'type'        => 'text',
        'class'       => '',
        'choices'     => array()
         ),
		 array(
        'id'          => 'mt_icon',
        'label'       => 'Icon',
        'std'         => '',
        'type'        => 'text',
        'class'       => '',
        'choices'     => array()
         ),

         array(
        'id'          => 'mt_portfolio_slider_height',
        'label'       => 'Slider Height (px)',
        'desc'        => '',
        'std'         => '230',
        'type'        => 'numeric_slider',
        'min_max_step'=> '100,1000,10',
          )
        ,

      array(
        'id'          => 'layout_sidebar',
        'label'       => 'Sidebar',
        'desc'        => '',
        'std'         => '',
         'post_type'   => 'mt_sidebar',
        'type'        => 'sidebar-select',
        'class'       => '',
        'choices'     => array(
					        array(
					        'value'   => 'sidebar_off',
					        'label'   => esc_html__( 'Sidebar Off', 'madza_builder69' )
					      )
        )
      ),
      array(
        'id'          => 'mb_page_sections_in',
        'label'       => 'Page Sections',
        'desc'        => '',
        'std'         => '',
        'type'        => 'list-item',
        'choices'     => array(),
        'settings'    => array(
          array(
            'id'      => 'section',
            'label'   => 'Page Section',
            'desc'    => '',
            'std'     => '',
            'type'        => 'custom-post-type-select',
            'post_type'   => 'mt_section',
            'class'   => '',
            'choices' => array()
          )
        )
        ),



)

  );

  if (  class_exists( 'OT_Loader' ) ) { ot_register_meta_box( $mt_service_metabox ); }

}


/*-----------------------------------------------------------------------------------*/
/*	EVENT Staff Post  -------------------------------------------------------------*/
/*---------------------------------------------------------------------------------*/

function madza_staff() {
global $mt_cpt_doctor;
  $labels = array(
    'name' => esc_html_x('Our Staff', 'post type general name', 'madza_builder69'),
    'singular_name' => esc_html_x('Staff', 'post type singular name', 'madza_builder69'),
    'add_new' => esc_html_x('Add Staff', 'Staff Item', 'madza_builder69'),
    'add_new_item' => esc_html__('Add New Staff', 'madza_builder69'),
    'edit_item' => esc_html__('Edit Staff', 'madza_builder69'),
    'new_item' => esc_html__('New Staff', 'madza_builder69'),
    'view_item' => esc_html__('View Staff Details', 'madza_builder69'),
    'search_items' => esc_html__('Search Staff', 'madza_builder69'),
    'not_found' =>  esc_html__('No Staff were found with that criteria', 'madza_builder69'),
    'not_found_in_trash' => esc_html__('No Staff found in the Trash with that criteria', 'madza_builder69'),
    'view' =>  esc_html__('View Staff', 'madza_builder69')
  );

  $args = array(
    'labels' => $labels,
    'label' => esc_html__('Staff', 'madza_builder69'),
    'singular_label' => esc_html__('Staff', 'madza_builder69'),
    'public' => true,
    'show_ui' => true,
    '_builtin' => false,
    'capability_type' => 'page',
    'exclude_from_search' => true,
    'hierarchical' => true,
    'rewrite' => array('slug' => $mt_cpt_doctor),
    'menu_position' => 30,
    'menu_icon' => 'dashicons-id-alt',
    'supports' => array('title', 'editor','thumbnail', 'revisions')
  );

  register_post_type('our-staff',$args);



$labels = array(
  'name' => esc_html__('Categories', 'madza_builder69'),
  'singular_name' => esc_html__('Categories', 'madza_builder69'),
  'search_items' =>  esc_html__('Search', 'madza_builder69'),
  'popular_items' => esc_html__('Popular things', 'madza_builder69'),
  'all_items' => esc_html__( 'Everything' , 'madza_builder69'),
  'parent_item' => esc_html__( 'Parent Categories', 'madza_builder69' ),
  'parent_item_colon' => esc_html__( 'Parent Categories:' , 'madza_builder69'),
  'edit_item' => esc_html__( 'Edit' , 'madza_builder69'),
  'update_item' => esc_html__( 'Update' , 'madza_builder69'),
  'add_new_item' => esc_html__( 'Add New' , 'madza_builder69'),
  'new_item_name' => esc_html__( 'New Name' , 'madza_builder69')
);


register_taxonomy($mt_cpt_doctor.'_cat', array('our-staff'),
	array(
	'hierarchical' => true,
	'labels' => $labels,
	'show_ui' => true,
	'query_var' => true,
	'rewrite' => array('slug' => 'doctor_categories')
));

}
add_action('init', 'madza_staff');


add_action( 'admin_init', 'mt_staff_metabox' );

function mt_staff_metabox() {

  $mt_staff_metabox = array(
    'id'        => 'mt_staff_metabox',
    'title'     => 'Staff Item Options',
    'desc'      => '',
    'pages' => array('our-staff'),
    'context'   => 'normal',
    'priority'  => 'high',
    'fields'    => array(
     	array(
	        'id'          => 'mt_doctor_education',
	        'label'       => 'Staff Education',
	        'std'         => '',
	        'type'        => 'text',
	        'class'       => '',
	        'choices'     => array()
         ),
         array(
	        'id'          => 'mt_doctor_twitter',
	        'label'       => 'Staff Twitter',
	        'std'         => '',
	        'type'        => 'text',
	        'class'       => '',
	        'choices'     => array()
         ),
         array(
	        'id'          => 'mt_doctor_facebook',
	        'label'       => 'Staff Facebook',
	        'std'         => '',
	        'type'        => 'text',
	        'class'       => '',
	        'choices'     => array()
         ),
         array(
	        'id'          => 'mt_doctor_google',
	        'label'       => 'Staff Google Plus',
	        'std'         => '',
	        'type'        => 'text',
	        'class'       => '',
	        'choices'     => array()
         ),
         array(
	        'id'          => 'mt_doctor_linked',
	        'label'       => 'Staff LinkedIn',
	        'std'         => '',
	        'type'        => 'text',
	        'class'       => '',
	        'choices'     => array()
         ),



          array(
        'id'          => 'mt_portfolio_slider_height',
        'label'       => 'Image Height (px)',
        'desc'        => '',
        'std'         => '400',
        'type'        => 'numeric_slider',
        'min_max_step'=> '100,1000,10',
        'class'       => '',
        'choices'     => array()
          )
        ,

      array(
        'id'          => 'mb_page_sections_in',
        'label'       => 'Page Sections',
        'desc'        => '',
        'std'         => '',
        'type'        => 'list-item',
        'choices'     => array(),
        'settings'    => array(
          array(
            'id'      => 'section',
            'label'   => 'Page Section',
            'desc'    => '',
            'std'     => '',
            'type'        => 'custom-post-type-select',
            'post_type'   => 'mt_section',
            'class'   => '',
            'choices' => array()
          )
        )
        ),



)

  );

  if (  class_exists( 'OT_Loader' ) ) { ot_register_meta_box( $mt_staff_metabox ); }

}


?>
