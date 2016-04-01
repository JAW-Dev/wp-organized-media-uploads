<?php
namespace WP_Organized_Media_Uploads\Admin\Model;

/**
 * Settings Model
 *
 * @package     WP_Organized_Media_Uploads
 * @subpackage  WP_Organized_Media_Uploads/Admin/Model
 * @author      Jason Witt <contact@jawittdesigns.com>
 * @copyright   Copyright (c) 2016, Jason Witt
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since       1.0.0
 */

// If this file is called directly, abort.
if( !defined( 'WPINC' ) ) { die; }

if( !class_exists( 'SettingsModel' ) ) {
  class SettingsModel {
    
    /**
     * Option
     *
     * @since  0.0.1
     * @var    array $options The settings option array
     */
    private $options;

    /**
     * Media Types
     *
     * @since  0.0.1
     * @var    array $media_types the media types
     */
    protected $media_types;

    /**
     * Initialize the class
     *
     * @since 0.0.1
     * @uses  get_option()
     * @uses  add_action()
     */
    public function __construct() {
      $this->options = get_option( WPOMU_OPTIONS . '_settings' );
      $this->media_types = array(
        'images',
        'video',
        'audio',
        'documents',
        'applications',
        'miscellaneous'
      );
      add_action( 'admin_menu', array( $this, 'settings_page' ) );
      add_action( 'admin_init', array( $this, 'settings_init' ) );
    }

    /**
     * Settings Page
     *
     * @since  0.0.1
     * @uses   add_options_page()
     * @return void
     */
    public function settings_page() {
      $this->options_page = add_options_page(
        'WPOMU Settings',
        'WPOMU',
        'manage_options',
        'ordered-uploads',
        array( $this, 'render_settings_page' )
      );
    }

    /**
     * Render Settings Page
     *
     * @since  0.0.1
     * @uses   settings_fields()
     * @uses   do_settings_sections()
     * @uses   submit_button()
     * @return void
     */
    public function render_settings_page() {
      ?>
      <div class="wrap">
        <h2><?php echo esc_html( get_admin_page_title() ); ?></h2>
        <form method="post" action="options.php">
          <?php
            settings_fields( WPOMU_OPTIONS . '_option_group' );
            do_settings_sections( WPOMU_OPTIONS . '_folder_names_settings_section_page' );
            do_settings_sections( WPOMU_OPTIONS . '_add_mimes_settings_section_page' );
            submit_button();
          ?>
        </form>
      </div>
    <?php 
    }

    /**
     * Settings Init
     *
     * @since  0.0.1
     * @uses   register_setting()
     * @uses   add_settings_section()
     * @uses   add_settings_field()
     * @return void
     */
    public function settings_init() {
      register_setting(
        WPOMU_OPTIONS . '_option_group',
        WPOMU_OPTIONS . '_settings',
        array( $this, 'sanitize_values' )
      );
      add_settings_section(
        WPOMU_OPTIONS . '_folder_names_setting_section',
        __( 'Folder Names', 'wpomu' ),
        array( $this, 'folder_names_info' ),
        WPOMU_OPTIONS . '_folder_names_settings_section_page'
      );
      foreach( $this->media_types as $media_type ) {
        add_settings_field(
          WPOMU_PRE_FIX . '_' . $media_type . '_dir',
          __( ucwords( $media_type ), 'wpomu' ),
          array( $this, 'folder_names_callback' ),
          WPOMU_OPTIONS . '_folder_names_settings_section_page',
          WPOMU_OPTIONS . '_folder_names_setting_section',
          array(
            'label_for' => WPOMU_PRE_FIX . '_' . $media_type . '_dir',
            'name'      => WPOMU_OPTIONS . '_settings[' . WPOMU_PRE_FIX . '_' . $media_type . '_dir]',
            'value'     => ( isset( $this->options[WPOMU_PRE_FIX . '_' . $media_type . '_dir'] ) ? esc_attr( $this->options[WPOMU_PRE_FIX . '_' . $media_type . '_dir'] ) : $media_type ),
          )
        );
      }
    }

    /**
     * Folder Names Callback
     *
     * @since  0.0.1
     * @return void
     */
    public function folder_names_info() {
      ?><p><?php _e( 'Customize the folder\'s names for each media type', 'wpomu' ); ?></p><?php
    }

    /**
     * Folder Names Callback
     *
     * @since  0.0.1
     * @return void
     */
    public function folder_names_callback( $args ) {
      printf( '<input type="text" name="%2$s" id="%1$s" value="%3$s" class="all-options">', $args['label_for'], $args['name'], $args['value'] );
    } // end folder_names_callback

    /**
     * Sanitize input values
     *
     * @since  0.0.1
     * @param  string $input the input value
     * @uses   sanitize_text_field()
     * @return array  $sanitary_values the sanitized values
     */
    public function sanitize_values( $input ) {
      $sanitary_values = array();
      foreach( $this->media_types as $media_type ) {
        if ( isset( $input[WPOMU_PRE_FIX . '_' . $media_type . '_dir'] ) ) {
          $sanitary_values[WPOMU_PRE_FIX . '_' . $media_type . '_dir'] = sanitize_text_field( strtolower( $input[WPOMU_PRE_FIX . '_' . $media_type . '_dir'] ) );
        }
      }
      return $sanitary_values;
    }
  }
} // end SettingsModel