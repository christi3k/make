<?php
/**
 * @package Make Child
 */

/**
 * The child theme version.
 *
 * This version number is used by the parent theme to determine how to handle
 * parent and child stylesheets. It is not used as a version parameter on the
 * child theme's stylesheet URL.
 *
 * @see MAKE_Setup_Scripts::enqueue_frontend_styles()
 */
define( 'TTFMAKE_CHILD_VERSION', '1.1.0' );

/**
 * Turn off the parent theme styles.
 *
 * If you would like to use this child theme to style Make from scratch, rather
 * than simply overriding specific style rules, remove the '//' from the
 * 'add_filter' line below. This will tell the theme not to enqueue the parent
 * stylesheet along with the child one.
 */
//add_filter( 'make_enqueue_parent_stylesheet', '__return_false' );

/**
 * Define a version number for the child theme's stylesheet.
 *
 * In order to prevent old versions of the child theme's stylesheet from loading
 * from a browser's cache, update the version number below each time changes are
 * made to the stylesheet.
 *
 * @uses MAKE_Setup_Scripts::update_version()
 */
function childtheme_style_version() {
	// Ensure the Make API is available.
	if ( ! function_exists( 'Make' ) ) {
		return;
	}

	// Version string to append to the child theme's style.css URL.
	$version = '1.0.0'; // <- Update this!

	Make()->scripts()->update_version( 'make-main', $version, 'style' );
}

add_action( 'wp_enqueue_scripts', 'childtheme_style_version', 20 );

function enqueue_editor_assets() {
	// Scripts.
	wp_enqueue_script(
		'make-gutenberg', // Handle.
		get_stylesheet_directory_uri() . '/js/gutenberg.js',
		array( 'wp-editor', 'wp-edit-post' ),
		TTFMAKE_VERSION
	);
}

add_action( 'enqueue_block_editor_assets', 'enqueue_editor_assets', 10 );

register_meta( 'page', 'use_make_builder', array(
	'object_subtype' => 'page',
	'show_in_rest' => true,
	'single' => true,
	'type' => 'string'
) );

//add_filter( 'use_block_editor_for_post', '__return_false' );

add_action( 'wp_ajax_use_gutenberg', 'use_gutenberg' );

function use_gutenberg() {
	$post_id = $_REQUEST['post_id'];
	update_post_meta( $post_id, '_use_gutenberg', 1 );

	wp_send_json_success();
}

function my_post_filter( $use_block_editor, $post ) {
	$use_block_editor = false;

	if ( 1 == get_post_meta( $post->ID, '_use_gutenberg', true ) ) {
		$use_block_editor = true;

		if ( isset( $_GET['use-make'] ) ) {
			update_post_meta( $post->ID, '_use_gutenberg', 0 );
			$use_block_editor = false;
		}
	}

	return $use_block_editor;
}

add_filter( 'use_block_editor_for_post', 'my_post_filter', 10, 2 );