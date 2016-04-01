<?php
namespace WP_Organized_Media_Uploads;

/**
 * Unistall
 *
 * Called on plugin activation
 *
 * @package    Package
 * @subpackage Package/SubPackage
 * @author     Author <contact@jawittdesigns.com>
 * @copyright  Copyright (c) 2016, Author
 * @license    http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since      1.0.0
 */

// If this file is called directly, abort.
if ( !defined( 'WPINC' ) ) { die; }

// If uninstall is not called from WordPress, exit.
if ( !defined( 'WP_UNINSTALL_PLUGIN' ) ) { exit(); }

if( !class_exists( 'WPOMU_Unistall' ) ) {
  class WPOMU_Unistall {

    /**
     * Initialize the class
     *
     * @since 1.0.0
     */
    public function init() {
      flush_rewrite_rules();
    } // end init

  }
} // end WPOMU_Unistall