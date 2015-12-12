<?php

/**
 * add Foundation Classes
 */
// Main layouts - Genesis attr class related
add_action('genesis_before', 'ygf_off_canvas_container_open');
add_action('genesis_after', 'ygf_off_canvas_container_close');
add_filter( 'genesis_attr_site-container', 'ygf_off_canvas_site_container_class');
add_filter( 'genesis_attr_title-area',         'ygf_add_titlearea_class' );
add_filter( 'genesis_attr_header-widget-area',         'ygf_add_header_widgetarea_class');
add_filter( 'genesis_attr_structural-wrap',         'ygf_add_row_wrap_class');
add_filter( 'genesis_attr_entry-image', 'ygf_featured_image_class' );

add_filter( 'genesis_attr_content-sidebar-wrap','ygf_add_markup_class', 10, 2 );
add_filter( 'genesis_attr_content',             'ygf_add_markup_class', 10, 2 );
add_filter( 'genesis_attr_sidebar-primary',     'ygf_add_markup_class', 10, 2 );
add_filter( 'genesis_attr_sidebar-secondary',     'ygf_add_markup_class', 10, 2 );
add_filter( 'genesis_attr_archive-pagination',  'ygf_pagination_markup', 10, 2 );
add_filter( 'genesis_attr_footer-widgets',         'ygf_add_markup_class', 10, 2 );
add_filter( 'genesis_attr_site-footer',         'ygf_add_markup_class', 10, 2 );
// modify genesis classes based on genesis_site_layout on foundation
add_filter('ygf-classes-to-add', 'ygf_modify_classes_based_on_template', 10, 3);


// Comments - section
add_filter( 'comment_form_defaults', 'ygf_change_comments_button_class' );

/* OffCanvas, not yet supported */
// Add the external div for off canvas(if menu is active)
function ygf_off_canvas_container_open(){
      if ( has_nav_menu('mobile-off-canvas') ) {
          echo '<div class="off-canvas-wrapper"><div class="off-canvas-wrapper-inner" data-off-canvas-wrapper>';
      }
}
function ygf_off_canvas_container_close(){
      if ( has_nav_menu('mobile-off-canvas') ) {
          echo '</div></div>';
      }
}

// Site Container Class
function ygf_off_canvas_site_container_class($attributes){
      if ( has_nav_menu('mobile-off-canvas') ) {
          $attributes['class'] .= ' off-canvas-content';
          $attributes['data-off-canvas-content'] = 'data-off-canavas-content';
      }
      return $attributes;
}
/* End of Offcanvas */

// Header Title Area
function ygf_add_titlearea_class($attributes){
    $attributes['class'] = 'title-area top-bar-left float-left menu';
    return $attributes;
}
// Header Widgets Area
function ygf_add_header_widgetarea_class($attributes){
    $attributes['class'] = 'top-bar-right float-right';
    return $attributes;
}

// Add row to wrappers
function ygf_add_row_wrap_class($attributes){
    $attributes['class'] .= ' row';
    return $attributes;
}

// Archive page featured image class
function ygf_featured_image_class( $attributes ) {
    $attributes['class'] = 'th';
    return $attributes;

}

// Pagination
function ygf_pagination_markup($attributes){
    $attributes['class'] .= '-centered';
    return $attributes;
}

function ygf_add_markup_class( $attr, $context ) {
    // default classes to add
    $classes_to_add = apply_filters ('ygf-classes-to-add',
        array(
        	'content-sidebar-wrap'       => 'row',
        	'sidebar-content-wrap'       => 'row',
                'content'   => 'columns',
                'sidebar-primary'   => 'columns',
                'sidebar-secondary'   => 'columns',
        ),
        $context,
        $attr
    );

    // populate $classes_array based on $classes_to_add
    $value = isset( $classes_to_add[ $context ] ) ? $classes_to_add[ $context ] : array();

    if ( is_array( $value ) ) {
        $classes_array = $value;
    } else {
        $classes_array = explode( ' ', (string) $value );
    }

    // apply any filters to modify the class
    $classes_array = apply_filters( 'ygf-add-class', $classes_array, $context, $attr );

    $classes_array = array_map( 'sanitize_html_class', $classes_array );

    // append the class(es) string (e.g. 'span9 custom-class1 custom-class2')
    $attr['class'] .= ' ' . implode( ' ', $classes_array );

    return $attr;
}

// remove unused layouts
// genesis_unregister_layout( 'content-sidebar-sidebar' );
genesis_unregister_layout( 'sidebar-sidebar-content' );
//genesis_unregister_layout( 'sidebar-content-sidebar' );

function ygf_layout_options_modify_classes_to_add( $classes_to_add ) {

    $layout = genesis_site_layout();



    // full-width-content       // supported

    // content-sidebar          // default
    if ( 'content-sidebar' === $layout ) {
	$classes_to_add['content'] .= ' small-12 medium-7 large-8 xlarge-9';
	$classes_to_add['sidebar-primary'] .= ' small-12 medium-5 large-4 xlarge-3';
    }

    // sidebar-content
    if ( 'sidebar-content' === $layout ) {
        $classes_to_add['content'] .= ' small-12 medium-7 medium-push-5 large-8 large-push-4 xlarge-9 xlarge-push-3';
        $classes_to_add['sidebar-primary'] .= ' small-12 medium-5 medium-pull-7 large-4 large-pull-8 xlarge-3 xlarge-pull-9';
    }

    // content-sidebar-sidebar
     if ( 'content-sidebar-sidebar' === $layout ) {
        $classes_to_add['content'] .= ' small-12 medium-4 large-6 xlarge-8';
        $classes_to_add['sidebar-primary'] .= ' small-12 medium-4 large-3 xlarge-2';
        $classes_to_add['sidebar-secondary'] .= ' small-12 medium-4 large-3 xlarge-2';
    }

    // sidebar-sidebar-content  // not yet supported
     if ( 'sidebar-sidebar-content' === $layout ) {
        $classes_to_add['content'] .= ' small-12 medium-4 medium-push-8 large-6 large-push-6 xlarge-8 xlarge-push-4';
        $classes_to_add['sidebar-primary'] .= ' small-12 medium-4 medium-pull-4 large-3 large-pull-6 xlarge-2 xlarge-pull-8';
        $classes_to_add['sidebar-secondary'] .= ' small-12 medium-4 medium-pull-4 large-3 large-pull-6 xlarge-2 xlarge-pull-8';
    }

    // sidebar-content-sidebar
     if ( 'sidebar-content-sidebar' === $layout ) {
        $classes_to_add['content'] .= ' small-12 medium-4 medium-push-4 large-6 large-push-3 xlarge-8 xlarge-push-2';
        $classes_to_add['sidebar-primary'] .= ' small-12 medium-4 medium-pull-4 large-3 large-pull-6 xlarge-2 xlarge-pull-8';
        $classes_to_add['sidebar-secondary'] .= ' small-12 medium-4 large-3 xlarge-2';
    }

    return $classes_to_add;
};

function ygf_modify_classes_based_on_template( $classes_to_add, $context, $attr ) {
    $classes_to_add = ygf_layout_options_modify_classes_to_add( $classes_to_add );

    return $classes_to_add;
}


function ygf_change_comments_button_class( $arg ) {
    $arg['class_submit'] = 'button';
    // return the modified array
    return $arg;
}

