<?php
namespace WP_Orginized_Media_Uploads\Admin\Controller;
use WP_Orginized_Media_Uploads\Admin\Model as Model;

/**
 * Settings Controller
 *
 * @package     WP_Orginized_Media_Uploads
 * @subpackage  WP_Orginized_Media_Uploads/Admin/Controller
 * @author      Jason Witt <contact@jawittdesigns.com>
 * @copyright   Copyright (c) 2016, Jason Witt
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since       1.0.0
 */

// If this file is called directly, abort.
if( !defined( 'WPINC' ) ) { die; }

if( !class_exists( 'SettingsController' ) ) {
  class SettingsController {

    /**
     * Initialize the class
     *
     * @since 1.0.0
     */
    public function __construct() { 
      $this->settings();
    } // end __construct

    /**
     * Admin Styles
     *
     * @since  1.0.0
     * @return void
     */
    public function settings() {
      new Model\SettingsModel();
    } // end settings
  }
} // end SettingsController