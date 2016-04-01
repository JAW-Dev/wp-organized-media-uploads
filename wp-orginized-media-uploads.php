<?php
/**
 * Search and Replace
 * 
 * WP_Orginized_Media_Uploads
 * WP Orginized Media Uploads
 * WPOMU
 * wpomu
 * https://github.com/jawittdesigns/WP-Orginized-Media-Uploads
 * Jason Witt
 * contact@jawittdesigns.com
 * http://jawittdesigns.com
 * 2016
 *
 * Delete When Done!!!!
 */
namespace WP_Orginized_Media_Uploads;
use WP_Orginized_Media_Uploads\Helpers as Helpers;
use WP_Orginized_Media_Uploads\Admin as Admin;
use WP_Orginized_Media_Uploads\Publics as Publics;
use WP_Orginized_Media_Uploads\Includes as Includes;
/**
 * WP_Orginized_Media_Uploads
 * 
 * @package     WP Orginized Media Uploads
 * @author      Jason Witt <contact@jawittdesigns.com>
 * @copyright   Copyright (c) 2016, Jason Witt
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since       1.0.0
 * 
 * @wordpress-plugin
 * Plugin Name:       WP Orginized Media Uploads
 * Plugin URI:        https://github.com/jawittdesigns/WP-Orginized-Media-Uploads
 * Description:       A WordPress plugin for orginizing the media uploads directory
 * Version:           1.0.0
 * Author:            Jason Witt
 * Author URI:        http://jawittdesigns.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       wpomu
 * Domain Path:       /languages
 * GitHub Plugin URI: https://github.com/jawittdesigns/WP-Orginized-Media-Uploads
 * GitHub Branch:     master
 */

// If this file is called directly, abort.
if ( !defined( 'WPINC' ) ) { die; }

if( !class_exists( 'WPOMU' ) ) {
  class WPOMU {
    
    /**
     * Instance of the class
     *
     * @since 1.0.0
     * @var Instance of WPOMU class
     */
    private static $instance;

    /**
     * Instance of the plugin
     *
     * @since 1.0.0
     * @static
     * @staticvar array 
     * @return Instance
     */
    public static function instance() {
      if ( !isset( self::$instance ) && ! ( self::$instance instanceof WPOMU ) ) {
        self::$instance = new WPOMU;
        self::$instance->define_constants();
        add_action( 'plugins_loaded', array( self::$instance, 'load_textdomain' ) );
        self::$instance->includes();
        self::$instance->init = new Includes\Includes_Init();
        if( !is_admin() ) {
          self::$instance->public_init = new Publics\Public_Init();
        }
        if( is_admin() ) {
          self::$instance->admin_init = new Admin\Admin_Init();
        }
      }
    return self::$instance;
    }

    /**
     * Define the plugin constants
     *
     * @since  1.0.0
     * @access private
     * @return void
     */
    private function define_constants() {
      // Plugin Version
      if ( !defined( 'WPOMU_VERSION' ) ) {
        define( 'WPOMU_VERSION', '1.0.0' );
      }
      // Prefix
      if ( !defined( 'WPOMU_PRE_FIX' ) ) {
        define( 'WPOMU_PRE_FIX', 'wpomu' );
      }
      // Options
      if ( !defined( 'WPOMU_OPTIONS' ) ) {
        define( 'WPOMU_OPTIONS', 'wpomu_options' );
      }
      // Plugin Directory
      if ( !defined( 'WPOMU_PLUGIN_DIR' ) ) {
        define( 'WPOMU_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
      }
      // Plugin URL
      if ( !defined( 'WPOMU_PLUGIN_URL' ) ) {
        define( 'WPOMU_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
      }
      // Plugin Root File
      if ( !defined( 'WPOMU_PLUGIN_FILE' ) ) {
        define( 'WPOMU_PLUGIN_FILE', __FILE__ );
      }
    }

    /**
     * Load the required files
     *
     * @since  1.0.0
     * @access private
     * @return void
     */
    private function includes() {
      // Autoloader
      if ( file_exists( WPOMU_PLUGIN_DIR . 'helpers/class-autoloader.php' ) ) {
        require_once WPOMU_PLUGIN_DIR . 'helpers/class-autoloader.php';
      }
      // Includes
      Helpers\wpomu_autoloader( 'includes/controller' );
      Helpers\wpomu_autoloader( 'includes/model' );
      if ( file_exists( WPOMU_PLUGIN_DIR . 'includes/class-includes-init.php' ) ) {
        include WPOMU_PLUGIN_DIR . 'includes/class-includes-init.php';
      }
      // Admin
      if( is_admin() ) {
        Helpers\wpomu_autoloader( 'admin/controller' );
        Helpers\wpomu_autoloader( 'admin/model' );
        if ( file_exists( WPOMU_PLUGIN_DIR . 'admin/class-admin-init.php' ) ) {
          include WPOMU_PLUGIN_DIR . 'admin/class-admin-init.php';
        }
      }
      // Activation
      if ( file_exists( WPOMU_PLUGIN_DIR . 'admin/class-admin-init.php' ) ) {
        include WPOMU_PLUGIN_DIR . 'activation.php';
      }
    }

    /**
     * Load the plugin text domain for translation.
     *
     * @since  1.0.0
     * @return void
     */
    public function load_textdomain() {
      $wpomu_lang_dir = dirname( plugin_basename( WPOMU_PLUGIN_FILE ) ) . '/languages/';
      $wpomu_lang_dir = apply_filters( 'wpomu_lang_dir', $wpomu_lang_dir );
      $locale = apply_filters( 'plugin_locale',  get_locale(), 'textdomain' );
      $mofile = sprintf( '%1-%2.mo', 'textdomain', $locale );
      $mofile_local  = $wpomu_lang_dir . $mofile;
      if ( file_exists( $mofile_local ) ) {
        load_textdomain( 'textdomain', $mofile_local );
      } else {
        load_plugin_textdomain( 'textdomain', false, $wpomu_lang_dir );
      }
    }

    /**
     * Throw error on object clone
     *
     * @since  1.0.0
     * @return void
     */
    public function __clone() {
      _doing_it_wrong( __FUNCTION__, __( 'Cheatin&#8217; huh?', 'textdomain' ), '1.6' );
    }

    /**
     * Disable unserializing of the class
     *
     * @since  1.0.0
     * @return void
     */
    public function __wakeup() {
      _doing_it_wrong( __FUNCTION__, __( 'Cheatin&#8217; huh?', 'textdomain' ), '1.6' );
    }

  }
} // end WPOMU
/**
 * Return the instance 
 *
 * @since 1.0.0
 * @return object The Safety Links instance
 */
function WPOMU_Run() {
  return WPOMU::instance();
} // end WPOMU_Run
WPOMU_Run();