<?php
/**
 * Class: EGF_Font_Control
 *
 * Google Font Options Theme Customizer Integration
 *
 * This file integrates the Theme Customizer for this Theme. 
 * All options in this theme are managed in the live customizer. 
 * We believe that themes should only alter the display of content 
 * and should not add any additional functionality that would be 
 * better suited for a plugin. Since all options are presentation 
 * centered, they should all be controllable by the Customizer.
 * 
 *
 * @package   Easy_Google_Fonts_Admin
 * @author    Sunny Johal - Titanium Themes <support@titaniumthemes.com>
 * @license   GPL-2.0+
 * @link      http://wordpress.org/plugins/easy-google-fonts/
 * @copyright Copyright (c) 2016, Titanium Themes
 * @version   1.4.1
 * 
 */
if ( ! class_exists( 'EGF_Font_Control' ) && class_exists( 'WP_Customize_Control' ) ) :
	class EGF_Font_Control extends WP_Customize_Control {

		/**
		 * Control type
		 * 
		 * @access public
		 * @var string
		 *
		 * @since 1.3.4
		 * @version 1.4.1
		 */
		public $type = 'egf_font';

		/**
		 * JSON statuses
		 * 
		 * @access public
		 * @var array
		 *
		 * @since 1.3.4
		 * @version 1.4.1
		 */
		public $statuses;

		protected $tabs = array();

		/**
		 * Constructor Function
		 * 
		 * Sets up the variables for this class
		 * instance.
		 *
		 * @since 1.3.4
		 * @version 1.4.1
		 * 
		 */
		function __construct( $manager, $id, $args = array() ) {
			$this->plugin_slug = 'easy-google-fonts';
			$this->manager     = $manager;
			$this->id          = $id;
			$this->args        = $args;

			// Call WP_Customize_Control parent constuctor.
			parent::__construct( $this->manager, $this->id, $this->args );

			// Define tabs for this font control.
			$this->add_tab( 'font-styles',      esc_html__( 'Styles', 'easy-google-fonts' ),      array( $this, 'get_style_controls' ), true );	
		}

		/**
		 * Add a tab to the control.
		 *
		 * @param string $id
		 * @param string $label
		 * @param mixed $callback
		 *
		 * @since 1.3.4
		 * @version 1.4.1
		 * 
		 */
		public function add_tab( $id, $label, $callback, $selected = false ) {
			$this->tabs[ $id ] = array(
				'label'    => $label,
				'callback' => $callback,
				'selected' => $selected,
			);
		}

		/**
		 * Remove a tab from the control.
		 *
		 * @param string $id
		 *
		 * @since 1.3.4
		 * @version 1.4.1
		 * 
		 */
		public function remove_tab( $id ) {
			unset( $this->tabs[ $id ] );
		}

		/**
		 * PHP Render Font Control
		 *
		 * Easy google fonts doesn't render the 
		 * control content from PHP, as it's 
		 * rendered via JS on load.
		 *
		 * @since 1.3.4
		 * @version 1.4.1
		 * 
		 */
		public function render_content() {
		}

		/**
		 * JS Render Font Control
		 *
		 * Render a JS template for the content 
		 * of this font control.
		 *
		 * @since 1.3.4
		 * @version 1.4.1
		 * 
		 */
		public function content_template() {
			// Get path to styles directory.
			$path = Easy_Google_Fonts::get_views_path() . '/customizer/control';

			// Include control elements.
			include( "{$path}/control-title.php" );
			include( "{$path}/control-start.php" );
			include( "{$path}/control-toggle.php" );
			include( "{$path}/properties-start.php" );
			include( "{$path}/control-tabs.php" );
			include( "{$path}/control-tab-panes.php" );
			include( "{$path}/properties-end.php" );
			include( "{$path}/control-end.php" );
		}

		/**
		 * Set Font Control JSON
		 * 
		 * Refresh the parameters passed to the 
		 * JavaScript via JSON.
		 * 
		 * @since 1.3.4
		 * @version 1.4.1
		 * 
		 */
		public function to_json() {
			parent::to_json();
			$this->json['id'] = $this->id;

			// Define additional json parameters.
			$this->json['egf_properties']      = $this->args['option']['properties'];
			$this->json['egf_defaults']        = $this->args['option']['default'];
			$this->json['egf_subsets']         = $this->get_subsets();
			$this->json['egf_text_decoration'] = $this->get_text_decoration_options();
			$this->json['egf_text_transform']  = $this->get_text_transform_options();
			$this->json['egf_display']         = $this->get_display_options();
			$this->json['egf_border_styles']   = $this->get_border_style_options();
		}

		/**
		 * Get Style Controls
		 * 
		 * Controls:
		 *     - Font Family
		 *     - Font Weight
		 *     - Text Decoration
		 *     - Text Transform
		 *     - Display
		 *
		 * @uses EGF_Font_Utilities::get_google_fonts() 	defined in includes\class-egf-font-utilities
		 * @uses EGF_Font_Utilities::get_default_fonts() 	defined in includes\class-egf-font-utilities
		 *
		 * @since 1.3.4
		 * @version 1.4.1
		 * 
		 */
		public function get_style_controls() {
			// Get path to styles directory.
			$path = Easy_Google_Fonts::get_views_path() . '/customizer/control/styles';
			
			// Include style controls.
			include( "{$path}/subsets.php" );
			include( "{$path}/font-family.php" );
			include( "{$path}/font-weight.php" );
			include( "{$path}/text-decoration.php" );
			include( "{$path}/text-transform.php" );
		}

		/**
		 * Get Appearance Controls
		 * 
		 * Controls:
		 *     - Font Color
		 *     - Background Color
		 *     - Font Size
		 *     - Line Height
		 *     - Letter Spacing
		 *
		 * @since 1.3.4
		 * @version 1.4.1
		 * 
		 */
		public function get_appearance_controls() {
			// Get path to styles directory.
			$path = Easy_Google_Fonts::get_views_path() . '/customizer/control/appearance';

			// Include appearance controls.
			include( "{$path}/font-color.php" );
			include( "{$path}/background-color.php" );
			include( "{$path}/font-size.php" );
			include( "{$path}/line-height.php" );
			include( "{$path}/letter-spacing.php" );		
		}

		/**
		 * Get Positioning Controls
		 *
		 * Controls:
		 *     - Border  ( Top, Bottom, Left, Right )
		 *     - Margin  ( Top, Bottom, Left, Right )
		 *     - Padding ( Top, Bottom, Left, Right )
		 * 
		 * @since 1.3.4
		 * @version 1.4.1
		 * 
		 */
		public function get_positioning_controls() {
			// Get path to styles directory.
			$path = Easy_Google_Fonts::get_views_path() . '/customizer/control/positioning';

			$folders    = array( 'margin', 'padding', 'border', 'border-radius' );
			$file_names = array( 'start', 'top', 'bottom', 'left', 'right', 'end' );

			// Include margin and padding controls.
			foreach ( $folders as $folder ) {
				foreach ($file_names as $file_name ) {
					include( "{$path}/{$folder}/{$file_name}.php" );
				}
			}

			// Include display control.
			include( "{$path}/display.php" );
		}		

		/**
		 * Get Subset Options
		 *
		 * Returns the array of subsets to be enqueued
		 * as a json object in the customizer.
		 *
		 * Custom Filters:
		 *     - tt_font_subset_options
		 *
		 * 
		 * @return array - Key/value array of available subsets.
		 *
		 * @since 1.3.4
		 * @version 1.4.1
		 * 
		 */
		public function get_subsets() {
			// Font subset options
			$font_subset_options = array(
				'all'          => esc_html__( 'All Subsets', 'easy-google-fonts' ),
				'latin'        => esc_html__( 'Latin', 'easy-google-fonts' ),
				'latin-ext'    => esc_html__( 'Latin Extended', 'easy-google-fonts' ),
				'arabic'       => esc_html__( 'Arabic', 'easy-google-fonts' ),
				'cyrillic'     => esc_html__( 'Cyrillic', 'easy-google-fonts' ),
				'cyrillic-ext' => esc_html__( 'Cyrillic Extended', 'easy-google-fonts' ),
				'devanagari'   => esc_html__( 'Devanagari', 'easy-google-fonts' ),
				'greek'        => esc_html__( 'Greek', 'easy-google-fonts' ),	
				'greek-ext'    => esc_html__( 'Greek Extended', 'easy-google-fonts' ),
				'khmer'        => esc_html__( 'Khmer', 'easy-google-fonts' ),
				'telugu'       => esc_html__( 'Telugu', 'easy-google-fonts' ),
				'vietnamese'   => esc_html__( 'Vietnamese', 'easy-google-fonts' ),
			);

			return apply_filters( 'tt_font_subset_options', $font_subset_options );
		}

		/**
		 * Get Text Decoration Options
		 *
		 * Returns the array of text decoration options 
		 * to be enqueued as a json object in the 
		 * customizer.
		 *
		 * Custom Filters:
		 *     - tt_font_text_decoration_options
		 *
		 * 
		 * @return array - Key/value array of available options.
		 *
		 * @since 1.3.4
		 * @version 1.4.1
		 * 
		 */
		public function get_text_decoration_options() {
			// Text decoration options
			$text_decoration_options = array(
				'none'			 => esc_html__( 'None', 'easy-google-fonts' ),
				'underline'		 => esc_html__( 'Underline', 'easy-google-fonts' ),
				'line-through' 	 => esc_html__( 'Line-through', 'easy-google-fonts' ),
				'overline'		 => esc_html__( 'Overline', 'easy-google-fonts' ),				
			);

			return apply_filters( 'tt_font_text_decoration_options', $text_decoration_options );	
		}

		/**
		 * Get Text Transform Options
		 * 
		 * @return [type] [description]
		 *
		 * @since 1.3.4
		 * @version 1.4.1
		 * 
		 */
		public function get_text_transform_options() {
			$text_transform_options = array(
				'none'			 => esc_html__( 'None', 'easy-google-fonts' ),
				'uppercase'		 => esc_html__( 'Uppercase', 'easy-google-fonts' ),
				'lowercase' 	 => esc_html__( 'Lowercase', 'easy-google-fonts' ),
				'capitalize'	 => esc_html__( 'Capitalize', 'easy-google-fonts' ),			
			);

			return apply_filters( 'tt_font_text_transform_options', $text_transform_options );
		}

		/**
		 * Get Display Options
		 * 
		 * @return [type] [description]
		 *
		 * @since 1.3.4
		 * @version 1.4.1
		 * 
		 */
		public function get_display_options() {
			$display_options = array(
				'block'        => esc_html__( 'Block', 'easy-google-fonts' ),
				'inline-block' => esc_html__( 'Inline Block', 'easy-google-fonts' ),
			);

			return apply_filters( 'tt_font_display_options', $display_options );			
		}

		/**
		 * Get Border Style Options
		 * 
		 * @return [type] [description]
		 *
		 * @since 1.3.4
		 * @version 1.4.1
		 * 
		 */
		public function get_border_style_options() {
			$styles = array(
				'none'   => esc_html__( 'None', 'easy-google-fonts' ),
				'solid'  => esc_html__( 'Solid', 'easy-google-fonts' ),
				'dashed' => esc_html__( 'Dashed', 'easy-google-fonts' ),
				'dotted' => esc_html__( 'Dotted', 'easy-google-fonts' ),
				'double' => esc_html__( 'Double', 'easy-google-fonts' ),
			);

			return apply_filters( 'tt_font_border_style_options', $styles );
		}
	}
endif;