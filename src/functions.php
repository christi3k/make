<?php
/**
 * @package Make
 */

/**
 * The current version of the theme.
 */
define( 'TTFMAKE_VERSION', '1.6.7' );

/**
 * The minimum version of WordPress required for Make.
 */
define( 'TTFMAKE_MIN_WP_VERSION', '4.2' );

/**
 * The suffix to use for scripts.
 */
if ( ( defined( 'SCRIPT_DEBUG' ) && true === SCRIPT_DEBUG ) ) {
	define( 'TTFMAKE_SUFFIX', '' );
} else {
	define( 'TTFMAKE_SUFFIX', '.min' );
}

// Activation
require_once get_template_directory() . '/inc/activation.php';

// Autoloader
require_once get_template_directory() . '/inc/autoload.php';

// Globals
global $content_width, $Make;

// Initial content width.
if ( ! isset( $content_width ) ) {
	$content_width = 960;
}

// Load API
$Make = new MAKE_API;

/**
 * Action: Fire when the Make API has finished loading.
 *
 * @since x.x.x.
 *
 * @param MAKE_API $Make
 */
do_action( 'make_api_loaded', $Make );

// Template tags
require_once get_template_directory() . '/inc/template-tags.php';

/**
 * Get the global Make API object.
 *
 * @since x.x.x.
 *
 * @return MAKE_API|null
 */
function Make() {
	global $Make;

	if ( ! did_action( 'make_api_loaded' ) || ! $Make instanceof MAKE_APIInterface ) {
		trigger_error(
			__( 'The Make() function should not be called before the make_api_loaded action has fired.', 'make' ),
			E_USER_WARNING
		);

		return null;
	}

	return $Make;
}