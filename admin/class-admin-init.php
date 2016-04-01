<?php
namespace WP_Orginized_Media_Uploads\Admin;
use WP_Orginized_Media_Uploads\Admin\Controller as Controller;

/**
 * Admin Instantiate
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

if( !class_exists( 'Admin_Init' ) ) {
  class Admin_Init {

    /**
     * Initialize the class
     *
     * @since 1.0.0
     */
    public function __construct() {
      $this->settings();
    } // end __construct

    /**
     * Settings
     *
     * @since  0.0.1
     * @return void
     */
    protected function settings() {
      new Controller\SettingsController();
    } // end settings

  }
} // end Admin_Init