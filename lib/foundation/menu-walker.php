<?php

/**
 * Customize the output of menus for Foundation top bar
 */
if ( ! class_exists( 'Ygf_Top_Bar_Walker' ) ) :
class Ygf_Top_Bar_Walker extends Walker_Nav_Menu {

  function display_element( $element, &$children_elements, $max_depth, $depth = 0, $args, &$output ) {
    $element->has_children = ! empty( $children_elements[ $element->ID ] );
    $element->classes[] = ( $element->current || $element->current_item_ancestor ) ? 'active' : '';
    $element->classes[] = ( $element->has_children && 1 !== $max_depth ) ? 'has-dropdown' : '';

    parent::display_element( $element, $children_elements, $max_depth, $depth, $args, $output );
  }

  function start_el( &$output, $object, $depth = 0, $args = array(), $current_object_id = 0 ) {
    $item_html = '';
    parent::start_el( $item_html, $object, $depth, $args );

    //$output .= ( 0 == $depth ) ? '<li class="divider"></li>' : '';

    $classes = empty( $object->classes ) ? array() : (array) $object->classes;

    if ( in_array( 'label', $classes ) ) {
      //$output .= '<li class="divider"></li>';
      $item_html = preg_replace( '/<a[^>]*>(.*)<\/a>/iU', '<label>$1</label>', $item_html );
    }

  if ( in_array( 'divider', $classes ) ) {
    $item_html = preg_replace( '/<a[^>]*>( .* )<\/a>/iU', '', $item_html );
  }

    $output .= $item_html;
  }

  function start_lvl( &$output, $depth = 0, $args = array() ) {
    $output .= "\n<ul class=\"menu sub-menu dropdown\">\n";
  }

}
endif;


/**
 * Customize the output of menus for Foundation off-canvas menu with multi-level support
 */
if ( ! class_exists( 'Ygf_Offcanvas_Walker' ) ) :
class Ygf_Offcanvas_Walker extends Walker_Nav_Menu {

  function display_element( $element, &$children_elements, $max_depth, $depth = 0, $args, &$output ) {
    $element->has_children = ! empty( $children_elements[ $element->ID ] );
    $element->classes[] = ( $element->current || $element->current_item_ancestor ) ? 'active' : '';
    $element->classes[] = ( $element->has_children && 1 !== $max_depth ) ? 'has-submenu' : '';

    parent::display_element( $element, $children_elements, $max_depth, $depth, $args, $output );
  }

  function start_el( &$output, $object, $depth = 0, $args = array(), $current_object_id = 0 ) {
    $item_html = '';
    parent::start_el( $item_html, $object, $depth, $args );

    $classes = empty( $object->classes ) ? array() : (array) $object->classes;

    if ( in_array( 'label', $classes ) ) {
      $item_html = preg_replace( '/<a[^>]*>(.*)<\/a>/iU', '<label>$1</label>', $item_html );
    }

    $output .= $item_html;
  }

  function start_lvl( &$output, $depth = 0, $args = array() ) {
    $output .= "\n<ul class=\"menu vertical\">\n";
  }

}
endif;


function wpclean_add_metabox_menu_posttype_archive() {
add_meta_box('wpclean-metabox-nav-menu-posttype', 'Custom Post Type Archives', 'wpclean_metabox_menu_posttype_archive', 'nav-menus', 'side', 'default');
}

function wpclean_metabox_menu_posttype_archive() {
$post_types = get_post_types(array('show_in_nav_menus' => true, 'has_archive' => true), 'object');

if ($post_types) :
    $items = array();
    $loop_index = 999999;

    foreach ($post_types as $post_type) {
        $item = new stdClass();
        $loop_index++;

        $item->object_id = $loop_index;
        $item->db_id = 0;
        $item->object = 'post_type_' . $post_type->query_var;
        $item->menu_item_parent = 0;
        $item->type = 'custom';
        $item->title = $post_type->labels->name;
        $item->url = get_post_type_archive_link($post_type->query_var);
        $item->target = '';
        $item->attr_title = '';
        $item->classes = array();
        $item->xfn = '';

        $items[] = $item;
    }

    $walker = new Walker_Nav_Menu_Checklist(array());

    echo '<div id="posttype-archive" class="posttypediv">';
    echo '<div id="tabs-panel-posttype-archive" class="tabs-panel tabs-panel-active">';
    echo '<ul id="posttype-archive-checklist" class="categorychecklist form-no-clear">';
    echo walk_nav_menu_tree(array_map('wp_setup_nav_menu_item', $items), 0, (object) array('walker' => $walker));
    echo '</ul>';
    echo '</div>';
    echo '</div>';

    echo '<p class="button-controls">';
    echo '<span class="add-to-menu">';
    echo '<input type="submit"' . disabled(1, 0) . ' class="button-secondary submit-add-to-menu right" value="' . __('Add to Menu', 'andromedamedia') . '" name="add-posttype-archive-menu-item" id="submit-posttype-archive" />';
    echo '<span class="spinner"></span>';
    echo '</span>';
    echo '</p>';

endif;
}

