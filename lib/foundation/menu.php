<?php

/**
 * Remove the primary and secondary menus
 *
 * @since 2.0.9
 */
// remove_action( 'genesis_after_header', 'genesis_do_nav' );
//remove_action( 'genesis_after_header', 'genesis_do_subnav' );
add_action( 'genesis_header_right', 'ygf_top_bar_r');
//


/**
 * Unregister default Genesis menus and add your own
 *
 * @since 2.0.18
 */

remove_theme_support( 'genesis-menus' );
add_theme_support(
        'genesis-menus',
        array(
                'top-bar-l' => 'Left Top Bar', // registers the menu in the WordPress admin menu editor
                'top-bar-r' => 'Right Top Bar',
                'mobile-off-canvas' => 'Mobile - Off Canvas',

        )
);

/**
 * Left top bar
 * http://codex.wordpress.org/Function_Reference/wp_nav_menu
 */
if ( ! function_exists( 'ygf_top_bar_l' ) ) {
  function ygf_top_bar_l() {
      wp_nav_menu(array(
          'container' => false,                           // remove nav container
          'container_class' => 'top-bar-left float-left',                        // class of container
          'menu' => '',                                   // menu name
          'menu_class' => 'vertical medium-horizontal menu',            // adding custom nav class
          'items_wrap' => '<ul id=%1$s class="%2$s" data-responsive-menu="accordion medium-dropdown">%3$s</ul>',
          'theme_location' => 'top-bar-l',                // where it's located in the theme
          'before' => '',                                 // before each link <a>
          'after' => '',                                  // after each link </a>
          'link_before' => '',                            // before each link text
          'link_after' => '',                             // after each link text
          'depth' => 5,                                   // limit the depth of the nav
          'fallback_cb' => false,                         // fallback function (see below)
          'walker' => new Ygf_Top_Bar_Walker()
      ));
  }
}

/**
 * Right top bar
 */
if ( ! function_exists( 'ygf_top_bar_r' ) ) {
  function ygf_top_bar_r() {
      wp_nav_menu(array(
          'container' => false,                           // remove nav container
          'container_class' => '',                        // class of container
          'menu' => '',                                   // menu name
          'menu_class' => 'vertical medium-horizontal menu',           // adding custom nav class
          'items_wrap' => '<ul id="%1$s" class="%2$s" data-responsive-menu="accordion medium-dropdown">%3$s</ul>',
          'theme_location' => 'top-bar-r',                // where it's located in the theme
          'before' => '',                                 // before each link <a>
          'after' => '',                                  // after each link </a>
          'link_before' => '',                            // before each link text
          'link_after' => '',                             // after each link text
          'depth' => 5,                                   // limit the depth of the nav
          'fallback_cb' => false,                         // fallback function (see below)
          'walker' => new Ygf_Top_Bar_Walker()
      ));
  }
}

/**
 * Mobile off-canvas
 */
if ( ! function_exists( 'ygf_mobile_off_canvas' ) ) {
  function ygf_mobile_off_canvas() {
      wp_nav_menu(array(
          'container' => false,                           // remove nav container
          'container_class' => '',                        // class of container
          'items_wrap' => '<ul id="%1$s" class="%2$s" data-accordion-menu><li><label>Navigation</label></li>%3$s</ul>',
          'menu_class' => 'vertical menu',                                   // menu name
          'theme_location' => 'mobile-off-canvas',        // where it's located in the theme
          'before' => '',                                 // before each link <a>
          'after' => '',                                  // after each link </a>
          'link_before' => '',                            // before each link text
          'link_after' => '',                             // after each link text
          'depth' => 5,                                   // limit the depth of the nav
          'fallback_cb' => false,                         // fallback function (see below)
          'walker' => new Ygf_Offcanvas_Walker()
      ));
  }
}

if ( ! function_exists( 'ygf_mobile_off_canvas_display' ) ) {
  function ygf_mobile_off_canvas_display() {
      if ( has_nav_menu('mobile-off-canvas') ) {
          echo '<aside class="off-canvas position-left" id="offCanvas" data-off-canvas>';
              ygf_mobile_off_canvas();
          echo '</aside>';
      }
    }
    add_action( 'genesis_before', 'ygf_mobile_off_canvas_display');

}



// Add Foundation 'active' class for the current menu item
if ( ! function_exists( 'ygf_active_nav_class' ) ) :
function ygf_active_nav_class( $classes, $item ) {
  if ( 1 == $item->current || true == $item->current_item_ancestor ) {
    $classes[] = 'active';
  }
  return $classes;
}
add_filter( 'nav_menu_css_class', 'ygf_active_nav_class', 10, 2 );
endif;

/**
 * Use the active class of ZURB Foundation on wp_list_pages output.
 * From required+ Foundation http://themes.required.ch
 */
if ( ! function_exists( 'ygf_active_list_pages_class' ) ) :
function ygf_active_list_pages_class( $input ) {

  $pattern = '/current_page_item/';
  $replace = 'current_page_item active';

  $output = preg_replace( $pattern, $replace, $input );

  return $output;
}
add_filter( 'wp_list_pages', 'ygf_active_list_pages_class', 10, 2 );
endif;





