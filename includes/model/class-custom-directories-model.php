<?php
namespace WP_Orginized_Media_Uploads\Includes\Model;

/**
 * Settings Controller
 *
 * @package     WP_Orginized_Media_Uploads
 * @subpackage  WP_Orginized_Media_Uploads/Includes/Model
 * @author      Jason Witt <contact@jawittdesigns.com>
 * @copyright   Copyright (c) 2016, Jason Witt
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since       1.0.0
 */

// If this file is called directly, abort.
if( !defined( 'WPINC' ) ) { die; }

if( !class_exists( 'CustomDirectoriesModel' ) ) {
  class CustomDirectoriesModel {

    /**
     * Custom Dir
     *
     * @since  0.0.1
     * @uses   wp_check_filetype()
     * @uses   get_option()
     * @uses   apply_filters()
     * @return array $upload the custom upload paths 
     */
    public function custom_dir( $upload ) {
      $post_id     = $_REQUEST['post_id'];
      $post_title  = strtolower( str_replace( ' ', '-', get_the_title( $post_id ) ) );
      $sub_dir     = ( $post_id ? $post_title : 'media' );
      $file_type   = wp_check_filetype( $_POST['name'] );
      $file_ext    = ( $file_type['ext'] ) ? $file_type['ext'] : '';
      $option      = get_option( 'wpomu_options' );
      $image_dir   = $option['wpomu_images_dir'];
      $audio_dir   = $option['wpomu_audio_dir'];
      $video_dir   = $option['wpomu_video_dir'];
      $doc_dir     = $option['wpomu_documents_dir'];
      $app_dir     = $option['wpomu_applications_dir'];
      $misc_dir    = $option['wpomu_miscellaneous_dir'];
      $cust_dir    = '';
      if( in_array( strtolower( $file_ext ),       apply_filters( 'wpomu_image_type_filter', array( 'jpg', 'jpeg', 'jpe', 'gif', 'png', 'bmp', 'tif', 'tiff', 'ico' ) ) ) ) {
          $cust_dir = $image_dir;
      } elseif( in_array( strtolower( $file_ext ), apply_filters( 'wpomu_audio_type_filter', array( 'mp3', 'm4a', 'm4b', 'ra', 'ram', 'wav', 'ogg', 'oga', 'mid', 'midi', 'wma', 'wax', 'mka' ) ) ) ) {
          $cust_dir = $audio_dir;
      } elseif( in_array( strtolower( $file_ext ), apply_filters( 'wpomu_video_type_filter', array( 'asf', 'asx', 'wmv', 'wmx', 'wm', 'avi', 'divx', 'flv', 'mov', 'qt', 'mpeg', 'mpg', 'mpe', 'mp4', 'm4v', 'ogv', 'webm', 'mkv' ) ) ) ) {
          $cust_dir = $video_dir;
      } elseif( in_array( strtolower( $file_ext ), apply_filters( 'wpomu_doc_type_filter'  , array( 'txt', 'asc', 'c', 'cc', 'h', 'csv', 'tsv', 'ics', 'rtx', 'css', 'htm', 'html', 'doc', 'pot', 'pps', 'ppt', 'wri', 'xla', 'xls', 'xlt', 'xlw', 'mdb', 'mpp', 'docx', 'docm', 'dotx', 'dotm', 'xlsx', 'xlsm', 'xlsb', 'xltx', 'xltm', 'xlam', 'pptx', 'pptm', 'ppsx', 'ppsm', 'potx', 'potm', 'ppam', 'sldx', 'sldm', 'onetoc', 'onetoc2', 'onetmp', 'onepkg', 'odt', 'odp', 'ods', 'odg', 'odc', 'odb', 'odf', 'wp','wpd', 'key', 'numbers', 'pages', 'pdf', 'rtf' ) ) ) ) {
          $cust_dir = $doc_dir;
      } elseif( in_array( strtolower( $file_ext ), apply_filters( 'wpomu_app_type_filter'  , array( 'js',  'swf', 'class', 'tar', 'zip', 'gz', 'gzip', 'rar', '7z', 'exe' ) ) ) ) {
          $cust_dir = $app_dir;
      } else {
          $cust_dir = $misc_dir;
      }
      // remove default subdir (year/month)
      $upload['path']   = str_replace( $upload['subdir'], '', $upload['path'] );
      $upload['url']    = str_replace( $upload['subdir'], '', $upload['url'] );
      // update paths
      $upload['subdir'] = '';
      $upload['path']  .= '/' . $cust_dir . '/' . $sub_dir . '/' . $file_type['ext'];
      $upload['url']   .= WP_CONTENT_URL . '/uploads/' . $cust_dir . '/' . $sub_dir . '/' . $file_type['ext'];
      return $upload;
    } // end custom_dir
  }
} // end CustomDirectoriesModel