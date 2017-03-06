<?php
function magazin_customize_general($wp_customize){

  $wp_customize->add_section( 'magazin_activate', array(
    'priority'       => 999,
    'capability'     => 'edit_theme_options',
    'theme_supports' => '',
    'title'    	=> esc_html__('Activate License Key', 'magazin'),
    'description'    => esc_html__('Unlock All Theme Features', 'magazin'),
  ));

  $wp_customize->add_setting('envato_username', array(
      'default'        => '',
      'capability'     => 'edit_theme_options',
      'type'           => 'option',
      'sanitize_callback' => 'esc_attr',
  ));
  $wp_customize->add_control('envato_username', array(
      'label'    	=> esc_html__('Username', 'magazin'),
      'section'    => 'magazin_activate',
      'settings'   => 'envato_username',
  ));

  $wp_customize->add_setting('envato_license', array(
      'default'        => '',
      'capability'     => 'edit_theme_options',
      'type'           => 'option',
      'sanitize_callback' => 'esc_attr',
  ));
  $wp_customize->add_control('envato_license', array(
      'label'    	=> esc_html__('Item Purchase Code', 'magazin'),
      'section'    => 'magazin_activate',
      'settings'   => 'envato_license',
  ));

  $wp_customize->add_panel( 'magazin_general', array(
    'priority'       => 300,
    'capability'     => 'edit_theme_options',
    'theme_supports' => '',
    'title'    	=> esc_html__('General', 'magazin'),
    'description'    => '',
  ));

  $wp_customize->add_section('mt_post_meta', array(
    'title'    	=> esc_html__('Post Meta', 'magazin'),
    'panel'  => 'magazin_posts'
  ));

  $wp_customize->add_section('mt_shema', array(
    'title'    	=> esc_html__('schema.org for SEO', 'magazin'),
    'panel'  => 'magazin_general'
  ));

  $wp_customize->add_setting('mt_shema_publisher', array(
      'default'        => '',
      'capability'     => 'edit_theme_options',
      'type'           => 'option',
      'sanitize_callback' => 'esc_attr',
  ));
  $wp_customize->add_control('mt_shema_publisher', array(
      'label'    	=> esc_html__('Publisher Name', 'magazin'),
      'section'    => 'mt_shema',
      'settings'   => 'mt_shema_publisher',
  ));


  Kirki::add_field( 'magazin_option[post_meta_excerpt]', array(
  'type'        => 'select',
  'settings'    => 'magazin_option[post_meta_excerpt]',
  'label'       => esc_attr__( 'Post Excerpt Source', 'magazin' ),
  'section'     => 'mt_post_meta',
  'default'     => '1',
  'option_type' => 'option',
  'priority'    => 10,
  'multiple'    => 1,
  'choices'     => array(
    '1' => esc_attr__( 'First Article Text', 'magazin' ),
    '2' => esc_attr__( 'Default WP Excerpt', 'magazin' ),
    '3' => esc_attr__( 'mt Excerpt', 'magazin' ),
    '4' => esc_attr__( 'mt Subtitle', 'magazin' ),
  ),
  ));

  Kirki::add_field( 'mt_post_meta_author', array(
     	'type'        => 'switch',
     	'settings'    => 'mt_post_meta_author',
     	'label'       => esc_attr__( 'Author in Post Lists', 'magazin' ),
     	'section'     => 'mt_post_meta',
     	'default'     => '1',
     	'priority'    => 10,
     	'choices'     => array(
     		'on'  => esc_attr__( 'ON', 'magazin' ),
     		'off' => esc_attr__( 'OFF', 'magazin' ),
     	),
   ) );
   Kirki::add_field( 'mt_post_meta_date', array(
      	'type'        => 'switch',
      	'settings'    => 'mt_post_meta_date',
      	'label'       => esc_attr__( 'Date in Post Lists', 'magazin' ),
      	'section'     => 'mt_post_meta',
      	'default'     => '1',
      	'priority'    => 10,
      	'choices'     => array(
          'on'  => esc_attr__( 'ON', 'magazin' ),
       		'off' => esc_attr__( 'OFF', 'magazin' ),
      	),
    ) );

    Kirki::add_field( 'mt_post_meta_cat', array(
  	'type'        => 'select',
  	'settings'    => 'mt_post_meta_cat',
  	'label'       => esc_attr__( 'Category in Post Lists', 'magazin' ),
  	'section'     => 'mt_post_meta',
  	'default'     => '1',
  	'priority'    => 10,
  	'multiple'    => 1,
  	'choices'     => array(
  		'1' => esc_attr__( 'Max One', 'magazin' ),
  		'2' => esc_attr__( 'Max Two', 'magazin' ),
  		'3' => esc_attr__( 'Max Three', 'magazin' ),
      '4' => esc_attr__( 'None', 'magazin' ),
  	),
    ));

    Kirki::add_field( 'mt_post_meta_author_post', array(
       	'type'        => 'switch',
       	'settings'    => 'mt_post_meta_author_post',
       	'label'       => esc_attr__( 'Author in Post Single', 'magazin' ),
       	'section'     => 'mt_post_meta',
       	'default'     => '1',
       	'priority'    => 10,
       	'choices'     => array(
          'on'  => esc_attr__( 'ON', 'magazin' ),
       		'off' => esc_attr__( 'OFF', 'magazin' ),
       	),
     ) );

     Kirki::add_field( 'mt_post_meta_author_post_img', array(
        	'type'        => 'switch',
        	'settings'    => 'mt_post_meta_author_post_img',
        	'label'       => esc_attr__( 'Remove Author Image in Post Single', 'magazin' ),
        	'section'     => 'mt_post_meta',
        	'default'     => '1',
        	'priority'    => 10,
        	'choices'     => array(
            'on'  => esc_attr__( 'ON', 'magazin' ),
         		'off' => esc_attr__( 'OFF', 'magazin' ),
        	),
      ) );

      Kirki::add_field( 'mt_post_meta_date_post', array(
         	'type'        => 'switch',
         	'settings'    => 'mt_post_meta_date_post',
         	'label'       => esc_attr__( 'Date in Post Single', 'magazin' ),
         	'section'     => 'mt_post_meta',
         	'default'     => '1',
         	'priority'    => 10,
         	'choices'     => array(
            'on'  => esc_attr__( 'ON', 'magazin' ),
         		'off' => esc_attr__( 'OFF', 'magazin' ),
         	),
       ) );

       Kirki::add_field( 'mt_post_meta_share_post', array(
            'type'        => 'switch',
            'settings'    => 'mt_post_meta_share_post',
            'label'       => esc_attr__( 'Share Count in Post Single', 'magazin' ),
            'section'     => 'mt_post_meta',
            'default'     => '1',
            'priority'    => 10,
            'choices'     => array(
             'on'  => esc_attr__( 'ON', 'magazin' ),
              'off' => esc_attr__( 'OFF', 'magazin' ),
            ),
        ) );
        Kirki::add_field( 'mt_post_meta_view_post', array(
             'type'        => 'switch',
             'settings'    => 'mt_post_meta_view_post',
             'label'       => esc_attr__( 'View Count in Post Single', 'magazin' ),
             'section'     => 'mt_post_meta',
             'default'     => '1',
             'priority'    => 10,
             'choices'     => array(
              'on'  => esc_attr__( 'ON', 'magazin' ),
               'off' => esc_attr__( 'OFF', 'magazin' ),
             ),
         ) );

  $wp_customize->add_section('facebook_excerpt', array(
    'title'    	=> esc_html__('Other', 'magazin'),
    'priority'       => 701,
    'panel'  => 'magazin_posts'
  ));

  Kirki::add_field( 'magazin_facebook_description', array(
  	'type'        => 'number',
  	'settings'    => 'magazin_facebook_description',
  	'label'       => esc_attr__( 'Post Share Description Length', 'boomnews' ),
  	'section'     => 'facebook_excerpt',
  	'default'     => 55,
    'option_type' => 'option',
  	'choices'     => array(
  		'min'  => 1,
  		'max'  => 55,
  		'step' => 1,
  	),
  ) );


  $wp_customize->add_section('css_settings', array(
    'title'    	=> esc_html__('Custom CSS', 'magazin'),
    'panel'  => 'magazin_general'
  ));

  Kirki::add_field( 'custom_css', array(
      'type'        => 'code',
    	'settings'    => 'custom_css',
    	'label'       => esc_html__( 'Custom CSS', 'magazin' ),
    	'section'     => 'css_settings',
    	'default'     => 'body { background: #fff; }',
    	'priority'    => 10,
      'option_type' => 'option',
    	'choices'     => array(
    		'language' => 'css',
    		'theme'    => 'monokai',
    		'height'   => 250,
    	),
  ) );

  $wp_customize->add_section('performance', array(
    'title'    	=> esc_html__('Performance', 'magazin'),
    'panel'  => 'magazin_general'
  ));

  Kirki::add_field( 'sticky_sidebar', array(
    'type'        => 'radio-buttonset',
    'settings'    => 'sticky_sidebar',
    'label'       => esc_html__( 'Sticky Sidebar', 'magazin' ),
    'section'     => 'performance',
    'default'     => '1',
    'priority'    => 1,
    'option_type'           => 'option',
    'choices'     => array(
      '1'   => esc_attr__( 'ON', 'magazin' ),
      '2' => esc_attr__( 'OFF', 'magazin' ),
    ),
 ));

 Kirki::add_field( 'share_time', array(
  	'type'        => 'select',
  	'settings'    => 'share_time',
  	'label'       => esc_attr__( 'Share Count Check', 'magazin' ),
  	'section'     => 'performance',
  	'default'     => '36000',
    'option_type' => 'option',
  	'priority'    => 10,
  	'multiple'    => 1,
  	'choices'     => array(
      '10' => esc_attr__( 'Every 10 sec', 'magazin' ),
      '20' => esc_attr__( 'Every 20 sec', 'magazin' ),
      '30' => esc_attr__( 'Every 30 sec', 'magazin' ),
      '60' => esc_attr__( 'Every 1 min', 'magazin' ),
      '120' => esc_attr__( 'Every 2 min', 'magazin' ),
      '180' => esc_attr__( 'Every 3 min', 'magazin' ),
      '300' => esc_attr__( 'Every 5 min', 'magazin' ),
      '600' => esc_attr__( 'Every 10 min', 'magazin' ),
      '900' => esc_attr__( 'Every 15 min', 'magazin' ),
      '1800' => esc_attr__( 'Every 30 min', 'magazin' ),
      '3600' => esc_attr__( 'Every 1h', 'magazin' ),
      '7200' => esc_attr__( 'Every 2h', 'magazin' ),
      '18000' => esc_attr__( 'Every 5h', 'magazin' ),
  		'36000' => esc_attr__( 'Every 10h', 'magazin' ),
      '86400' => esc_attr__( 'Every 24h', 'magazin' ),
      '172800' => esc_attr__( 'Every 48h', 'magazin' ),
  	),
    ));

 Kirki::add_field( 'carousel_autoplay', array(
   'type'        => 'radio-buttonset',
   'settings'    => 'carousel_autoplay',
   'label'       => esc_html__( 'Carousel Autoplay', 'magazin' ),
   'section'     => 'performance',
   'default'     => '1',
   'priority'    => 1,
   'option_type'           => 'option',
   'choices'     => array(
     '1'   => esc_attr__( 'ON', 'magazin' ),
     '2' => esc_attr__( 'OFF', 'magazin' ),
   ),
));






  $wp_customize->add_section('social_widget', array(
    'title'    	=> esc_html__('Social Widget Settings', 'magazin'),
    'panel'  => 'magazin_general'
  ));

  $wp_customize->add_setting('facebook_username', array(
      'default'        => '',
      'capability'     => 'edit_theme_options',
      'type'           => 'option',
      'sanitize_callback' => 'esc_attr',
  ));
  $wp_customize->add_control('facebook_username', array(
      'label'    	=> esc_html__('Facebook username', 'magazin'),
      'section'    => 'social_widget',
      'settings'   => 'facebook_username',
  ));

  $wp_customize->add_setting('facebook_token', array(
      'default'        => '',
      'capability'     => 'edit_theme_options',
      'type'           => 'option',
      'sanitize_callback' => 'esc_attr',
  ));
  $wp_customize->add_control('facebook_token', array(
      'label'    	=> esc_html__('Facebook token', 'magazin'),
      'section'    => 'social_widget',
      'settings'   => 'facebook_token',
  ));

  $wp_customize->add_setting('twitter_username', array(
      'default'        => '',
      'capability'     => 'edit_theme_options',
      'type'           => 'option',
      'sanitize_callback' => 'esc_attr',
  ));
  $wp_customize->add_control('twitter_username', array(
      'label'    	=> esc_html__('Twitter username', 'magazin'),
      'section'    => 'social_widget',
      'settings'   => 'twitter_username',
  ));

  $wp_customize->add_setting('youtube_username', array(
      'default'        => '',
      'capability'     => 'edit_theme_options',
      'type'           => 'option',
      'sanitize_callback' => 'esc_attr',
  ));
  $wp_customize->add_control('youtube_username', array(
      'label'    	=> esc_html__('YouTube username', 'magazin'),
      'section'    => 'social_widget',
      'settings'   => 'youtube_username',
  ));


}

add_action('customize_register', 'magazin_customize_general');
?>
