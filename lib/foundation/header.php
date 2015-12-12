<?php


remove_action( 'genesis_header', 'genesis_do_header');
add_action( 'genesis_header', 'ygf_do_header' );
/**
 * Echo the default header, including the #title-area div, along with #title and #description, as well as the .widget-area.
 *
 * Does the `genesis_site_title`, `genesis_site_description` and `genesis_header_right` actions.
 *
 * @since 1.0.2
 *
 * @global $wp_registered_sidebars Holds all of the registered sidebars.
 *
 * @uses genesis_markup() Apply contextual markup.
 */
function ygf_do_header() {

	global $wp_registered_sidebars;

  if(has_nav_menu('mobile-off-canvas')){
      echo '<div class="show-for-medium"><nav class="top-bar">';
  }else{
      echo '<nav class="top-bar">';
  }

	genesis_markup( array(
		'html5'   => '<ul %s>',
		'xhtml'   => '<div id="title-area">',
		'context' => 'title-area',
	) );
	do_action( 'genesis_site_title' );
	do_action( 'genesis_site_description' );
	genesis_markup( array(
		'html5'   => '</ul>',
		'xhtml'   => '</div>',
  ));

	if ( ( isset( $wp_registered_sidebars['header-right'] ) && is_active_sidebar( 'header-right' ) ) || has_action( 'genesis_header_right' ) ) {
		genesis_markup( array(
			'html5'   => '<aside %s>',
			'xhtml'   => '<div class="widget-area header-widget-area">',
			'context' => 'header-widget-area',
		) );

			do_action( 'genesis_header_right' );
			add_filter( 'wp_nav_menu_args', 'genesis_header_menu_args' );
			add_filter( 'wp_nav_menu', 'genesis_header_menu_wrap' );
			dynamic_sidebar( 'header-right' );
			//remove_filter( 'wp_nav_menu_args', 'genesis_header_menu_args' );
			//remove_filter( 'wp_nav_menu', 'genesis_header_menu_wrap' );

		genesis_markup( array(
			'html5' => '</aside>',
			'xhtml' => '</div>',
		) );
	}

  if(has_nav_menu('mobile-off-canvas')){
    echo '</nav></div><div class="show-for-small-only"><nav class="title-bar">';

    genesis_markup( array(
      'html5' => '<section class="title-bar-left"><button class="menu-icon" data-toggle="offCanvas"><span></span></button>',
      'xhtml' => '<div class="title-bar-left"><button class="menu-icon" data-toggle="offCanvas"><span></span></button>'
    ));


      // Set what goes inside the wrapping tags
      $inside = sprintf( '%s', get_bloginfo( 'name' ) );

      // Determine which wrapping tags to use
      $wrap = is_home() && 'title' === genesis_get_seo_option( 'home_h1_on' ) ? 'h1' : 'h1';

      // A little fallback, in case an SEO plugin is active
      $wrap = is_home() && ! genesis_get_seo_option( 'home_h1_on' ) ? 'h1' : $wrap;

      // And finally, $wrap in h1 if HTML5 & semantic headings enabled
      $wrap = genesis_html5() && genesis_get_seo_option( 'semantic_headings' ) ? 'h1' : $wrap;

      $title  = genesis_html5() ? sprintf( "<{$wrap} %s>", genesis_attr( 'title-bar-title' ) ) : sprintf( '<%s id="title">%s</%s>', $wrap, $inside, $wrap );
      $title .= genesis_html5() ? "{$inside}</{$wrap}>" : '';

      echo apply_filters( 'genesis_seo_title', $title, $inside, $wrap );

    genesis_markup( array(
      'html5' => '</section>',
      'xhtml' => '</div>'
    ));

    genesis_markup( array(
      'html5' => '<section class="title-bar-right">',
      'xhtml' => '<div class="title-bar-right">'
    ));


    genesis_markup( array(
      'html5' => '</section>',
      'xhtml' => '</div>'
    ));

    echo '</nav></div>';
  }

}

remove_action( 'genesis_site_title', 'genesis_seo_site_title' );
add_action( 'genesis_site_title', 'ygf_seo_site_title' );
/**
 * Echo the site title into the header.
 *
 * Depending on the SEO option set by the user, this will either be wrapped in an `h1` or `p` element.
 *
 * Applies the `genesis_seo_title` filter before echoing.
 *
 * @since 1.1.0
 *
 * @uses genesis_get_seo_option() Get SEO setting value.
 * @uses genesis_html5()          Check or HTML5 support.
 */
function ygf_seo_site_title() {

        // Set what goes inside the wrapping tags
        $inside = sprintf( '<a href="%s" class="menu-text">%s</a>', trailingslashit( home_url() ), get_bloginfo( 'name' ) );

        // Determine which wrapping tags to use
        $wrap = is_home() && 'title' === genesis_get_seo_option( 'home_h1_on' ) ? 'h1' : 'h1';

        // A little fallback, in case an SEO plugin is active
        $wrap = is_home() && ! genesis_get_seo_option( 'home_h1_on' ) ? 'h1' : $wrap;

        // And finally, $wrap in h1 if HTML5 & semantic headings enabled
        $wrap = genesis_html5() && genesis_get_seo_option( 'semantic_headings' ) ? 'h1' : $wrap;

        // Build the title
        $title  = genesis_html5() ? sprintf( "<li class='name'><{$wrap} %s>", genesis_attr( 'site-title' ) ) : sprintf( '<%s id="title">%s</%s>', $wrap, $inside, $wrap );
        $title .= genesis_html5() ? "{$inside}</{$wrap}></li>" : '';


        if(!has_nav_menu('mobile-off-canvas'))
          $title .= '<li class="toggle-topbar menu-icon"><a href="#"><span>Menu</span></a></li>';

        // Echo (filtered)
        echo apply_filters( 'genesis_seo_title', $title, $inside, $wrap );

}
