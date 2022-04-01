<?php
/**
 * Plugin Name:       Pixolin Directory Listing
 * Description:       Shortcode prints directory content of a subdirectory in wp-content/uploads
 * License:           GPL v2 or later
 * Version:           0.1.0
 * Requires at least: 5.2
 * Requires PHP:      7.4
 * Author:            Bego Mario Garde <pixolin@pixolin.de>
 * Author URI:        https://pixolin.de
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       directory
 * Domain Path:       /languages
 */

namespace Pixolin\Directory;

/* Exit if accessed directly */
if ( ! defined( 'ABSPATH' ) ) {
	return;
}

add_shortcode( 'dirlisting', 'Pixolin\Directory\dirlisting_shortcode' );

/**
 * dirlisting_shortcode()
 *
 * Defines Shortcode dirlisting
 *
 * Usage: [dirlisting name="mydocuments"], where mydocuments is a
 * subfolder of wp-content/uploads
 *
 * @param  array $atts Shortcode attributes
 * @return string $out Content being rendered in front end
 */
function dirlisting_shortcode( $atts ) {
	$atts = shortcode_atts( array( 'name' => '' ), $atts, 'directory' );

	$upload_dir = wp_upload_dir();
	$folder     = $upload_dir['basedir'] . '/' . esc_attr( $atts['name'] );

	$out = '<h2>Error: directory not found</h2>';
	if ( ! is_dir( $folder ) ) {
		return $out;
	}

	$files = scandir( $folder );
	$url   = WP_CONTENT_URL . '/uploads/' . esc_attr( $atts['name'] );

	// You can add more styling to the list here.
	$out = '<ul style="list-style-type: none">';

	foreach ( $files as $file ) {
		if ( ! in_array( $file, array( '.', '..' ), true ) ) {
			$out .= '<li><a href="' . esc_url( $url ) . '/' . esc_attr( $file ) . '">';
			$out .= esc_attr( $file );
			$out .= '</a></li>';
		}
	}

	$out .= '</ul>';
	return $out;
}
