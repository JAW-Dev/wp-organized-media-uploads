<?php
namespace WP_Orginized_Media_Uploads\Includes\Controller;
use WP_Orginized_Media_Uploads\Includes\Model as Model;

/**
 * Settings Controller
 *
 * @package     WP_Orginized_Media_Uploads
 * @subpackage  WP_Orginized_Media_Uploads/Includes/Classes
 * @author      Jason Witt <contact@jawittdesigns.com>
 * @copyright   Copyright (c) 2016, Jason Witt
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since       1.0.0
 */

// If this file is called directly, abort.
if( !defined( 'WPINC' ) ) { die; }

if( !class_exists( 'CustomDirectoriesController' ) ) {
  class CustomDirectoriesController {

    /**
     * Initialize the class
     *
     * @since 1.0.0
     * @uses  add_filter()
     */
    public function __construct() { 
      add_filter( 'wp_handle_upload_prefilter', array( $this, 'pre_upload' ) );
      add_filter( 'wp_handle_upload', array( $this, 'post_upload' ) );
    } // end __construct

    /**
     * Pre Upload
     *
     * @since  1.0.0
     * @uses   add_filter()
     * @return array $file Reference to a single element of $_FILES
     */
    public function pre_upload( $file ) {
      $controler = new Model\CustomDirectoriesModel();
      add_filter( 'upload_dir', array( $controler, 'custom_dir' ) );
      return $file;
    } // end pre_upload

    /**
     * Post Upload
     *
     * @since  1.0.0
     * @uses   add_filter()
     * @return array $file Reference to a single element of $_FILES
     */
    public function post_upload( $fileinfo ) {
      $controler = new Model\CustomDirectoriesModel();
      remove_filter( 'upload_dir', array( $controler, 'custom_dir' ) );
      return $fileinfo;
    } // end post_upload

  }
} // end CustomDirectoriesController