<?php
function magazin_customize_posts($wp_customize){

  $wp_customize->add_panel( 'magazin_posts', array(
    'priority'       => 300,
    'capability'     => 'edit_theme_options',
    'theme_supports' => '',
    'title'    	=> esc_html__('Posts', 'magazin'),
    'description'    => '',
  ));


  $wp_customize->add_section('posts_category_settings', array(
    'title'    	=> esc_html__('Category Layouts', 'magazin'),
    'priority'       => 501,
    'panel'  => 'magazin_posts'
  ));

  $wp_customize->add_section('posts_default_settings', array(
    'title'    	=> esc_html__('Post Layouts', 'magazin'),
    'priority'       => 301,
    'panel'  => 'magazin_posts'
  ));


  Kirki::add_field( 'magazin_theme_options[category_grid_style]', array(
    'type'        => 'radio-image',
    'settings'    => 'magazin_theme_options[category_grid_style]',
    'label'       => esc_html__( 'Category Grid Style', 'magazin' ),
    'section'     => 'posts_category_settings',
    'default'     => '4',
    'option_type' => 'option',
    'priority'    => 20,
    'choices'     => array(
        '1'   => get_template_directory_uri() . '/inc/img/grid_style_1.png',
        '2' => get_template_directory_uri() . '/inc/img/grid_style_2.png',
        '3'   => get_template_directory_uri() . '/inc/img/grid_style_3.png',
        '4' => get_template_directory_uri() . '/inc/img/grid_style_4.png',
       ),
  ));

  Kirki::add_field( 'magazin_theme_options[category_post_style]', array(
    'type'        => 'radio-image',
    'settings'    => 'magazin_theme_options[category_post_style]',
    'label'       => esc_html__( 'Category Post Style', 'magazin' ),
    'section'     => 'posts_category_settings',
    'default'     => '4',
    'option_type' => 'option',
    'priority'    => 20,
    'choices'     => array(
        '1'   => get_template_directory_uri() . '/inc/img/c_post_style_1.png',
        '2' => get_template_directory_uri() . '/inc/img/c_post_style_2.png',
        '3'   => get_template_directory_uri() . '/inc/img/c_post_style_3.png',
        '4' => get_template_directory_uri() . '/inc/img/c_post_style_4.png',
       ),
  ));

} add_action('customize_register', 'magazin_customize_posts');

?>
