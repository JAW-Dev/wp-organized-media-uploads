<?php
namespace WP_Organized_Media_Uploads;

/**
 * Activation
 *
 * Called on plugin activation
 *
 * @package    Package
 * @subpackage Package/SubPackage
 * @author     Jason Witt <contact@jawittdesigns.com>
 * @copyright  Copyright (c) 2016, Jason Witt
 * @license    http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since      1.0.0
 */

// If this file is called directly, abort.
if ( !defined( 'WPINC' ) ) { die; }

if( !class_exists( 'WPOMU_Activation' ) ) {
  class WPOMU_Activation {

    /**
     * Initialize the class
     *
     * @since 1.0.0
     */
    public function init() {
      $this->add_options();
      flush_rewrite_rules();
    } // end init

    /**
     * Add Options
     *
     * @since      0.0.1
     * @return     void
     */
    public function add_options() {
      $options = WPOMU_OPTIONS;
      $option = array(
        WPOMU_PRE_FIX . '_images_dir'        => 'images',
        WPOMU_PRE_FIX . '_video_dir'         => 'video',
        WPOMU_PRE_FIX . '_audio_dir'         => 'audio',
        WPOMU_PRE_FIX . '_documents_dir'     => 'documents',
        WPOMU_PRE_FIX . '_applications_dir'  => 'applications',
        WPOMU_PRE_FIX . '_miscellaneous_dir' => 'miscellaneous',
      );
      update_option( $options, $option, 'no' );
    } // end add_options

  }
} // end WPOMU_Activation
$activation = new WPOMU_Activation();
register_activation_hook( WPOMU_PLUGIN_FILE, array( $activation, 'init' ) );