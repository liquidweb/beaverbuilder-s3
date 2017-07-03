<?php
/**
 * Plugin Name: Beaver Builder + Amazon S3
 * Plugin URI:  https://github.com/liquidweb/beaverbuilder-s3
 * Description: Ensures compatibility between Beaver Builder and Human Made's S3 Uploads plugin.
 * Version:     0.1.0
 * Author:      Liquid Web
 * Author URI:  https://www.liqudweb.com
 * Text Domain: beaverbuilder-s3
 *
 * @package LiquidWeb\BeaverBuilderS3
 * @author  Liquid Web
 */

/**
 * Use the local filesystem rather than Amazon S3 for Beaver Builder's cache directory.
 *
 * The S3 Uploads plugin filters adds S3_Uploads::filter_upload_dir() onto the upload_dir filter,
 * which can have adverse effects on Beaver Builder's cache since it's not intended to be written
 * to an object store like S3.
 *
 * Fortunately, the S3 Uploads plugin exposes a method to retrieve the original, unmodified values
 * from wp_upload_dir().
 *
 * @param array $dirs Array of upload directory data with keys of 'path', 'url', 'subdir,
 *                    'basedir', and 'error'.
 * @return array The filtered $dirs array.
 */
function beaverbuilders3_get_upload_dir( $dirs ) {

	// Return early if the S3 Uploads class doesn't exist.
	if ( ! class_exists( 'S3_Uploads' ) || ! method_exists( 'S3_Uploads', 'get_instance' ) ) {
		return $dirs;
	}

	$s3 = S3_Uploads::get_instance();

	return $s3->get_original_upload_dir();
}
add_filter( 'fl_builder_get_upload_dir', 'beaverbuilders3_get_upload_dir' );
