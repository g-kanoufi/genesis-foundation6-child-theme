<?php

/**
 * Theme Setup
 * @since 1.0.0
 *
 * This setup function attaches all of the site-wide functions
 * to the correct hooks and filters. All the functions themselves
 * are defined below this setup function.
 *
 */

add_action( 'genesis_setup','child_theme_setup', 15 );
function child_theme_setup() {

	/****************************************
	Define child theme version
	*****************************************/

	define( 'CHILD_THEME_VERSION', filemtime( get_stylesheet_directory() . '/style.css' ) );


	/****************************************
	Include Genesis base functions
	*****************************************/

	include_once( CHILD_DIR . '/lib/genesis.php' );

	/****************************************
	Include theme helper functions
	*****************************************/

	include_once( CHILD_DIR . '/lib/theme-helpers.php' );


	/****************************************
	Setup child theme functions
	*****************************************/

	include_once( CHILD_DIR . '/lib/theme-functions.php' );


	/****************************************
	Structure set up
	****************************************/


	// Structure (corresponds to Genesis's lib/structure)
        include_once( CHILD_DIR . '/lib/structure/archive.php' );
        include_once( CHILD_DIR . '/lib/structure/breadcrumbs.php' );
        include_once( CHILD_DIR . '/lib/structure/footer.php' );
        include_once( CHILD_DIR . '/lib/structure/gallery.php' );
        include_once( CHILD_DIR . '/lib/structure/head.php' );
        include_once( CHILD_DIR . '/lib/structure/header.php' );
        include_once( CHILD_DIR . '/lib/structure/loops.php' );
        include_once( CHILD_DIR . '/lib/structure/menu.php' );
        include_once( CHILD_DIR . '/lib/structure/post.php' );
        include_once( CHILD_DIR . '/lib/structure/scripts.php' );
        include_once( CHILD_DIR . '/lib/structure/search.php' );
        include_once( CHILD_DIR . '/lib/structure/sidebar.php' );

        // Foundation modifications
        include_once( CHILD_DIR . '/lib/foundation/footer.php' );
        include_once( CHILD_DIR . '/lib/foundation/head.php' );
        include_once( CHILD_DIR . '/lib/foundation/header.php' );
        include_once( CHILD_DIR . '/lib/foundation/markup.php' );
        include_once( CHILD_DIR . '/lib/foundation/menu-walker.php' );
        include_once( CHILD_DIR . '/lib/foundation/menu.php' );
        include_once( CHILD_DIR . '/lib/foundation/pagination.php' );
        include_once( CHILD_DIR . '/lib/foundation/search.php' );

	// Custom Post type
	// include_once( CHILD_DIR . '/lib/cpt/theme-cpt.php' );


}
add_action('after_setup_theme', 'ygf_theme_setup');
function ygf_theme_setup(){
    load_theme_textdomain('genesis-foundation-child-theme', get_stylesheet_directory() . '/languages');
}
