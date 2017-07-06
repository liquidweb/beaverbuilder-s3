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
 * Keep custom Beaver Builder icons on the local filesystem.
 *
 * Since PHP's glob() can't work properly on remote files, custom icon sets fail when S3 is in the
 * mix. This filter undoes the S3 rewriting when calling FLBuilderModel::get_cache_dir( 'icons' ).
 *
 * @link http://kb.wpbeaverbuilder.com/article/110-enable-disable-or-import-new-icon-sets
 *
 * @param array $dirs Array of upload directory data with keys of 'path', 'url', 'subdir,
 *                    'basedir', and 'error'.
 */
function beaverbuilders3_get_icon_dir( $dirs ) {

	// Something's odd, let's not mess it up further.
	if ( ! isset( $dirs['path'] ) ) {
		return $dirs;
	}

	// Only operate on paths that end in '/icons/'.
	if ( '/icons/' !== substr( trailingslashit( $dirs['path'] ), -7 ) ) {
		return $dirs;
	}

	/*
	 * Determine where Beaver Builder icon fonts should be stored.
	 *
	 * By default, this will be in wp-content/icons, but if you would like to preserve the default
	 * wp-content/uploads/bb-plugin/icons path, use something like this in your filter:
	 *
	 *   $path = wp_parse_url( $dirs['path'], PHP_URL_PATH );
	 *
	 * @param string $path The path relative to the wp-content directory.
	 */
	$path = apply_filters( 'beaverbuilders3_icon_path', '/icons/' );
	$path = trailingslashit( $path );

	$dirs['path'] = WP_CONTENT_DIR . $path;
	$dirs['url']  = content_url( $path );

	return $dirs;
}
add_filter( 'fl_builder_get_cache_dir', 'beaverbuilders3_get_icon_dir' );
