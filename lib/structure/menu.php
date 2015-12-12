<?php

/**
 * Add support for buttons in the top-bar menu:
 * 1) In WordPress admin, go to Apperance -> Menus.
 * 2) Click 'Screen Options' from the top panel and enable 'CSS CLasses' and 'Link Relationship (XFN)'
 * 3) On your menu item, type 'has-form' in the CSS-classes field. Type 'button' in the XFN field
 * 4) Save Menu. Your menu item will now appear as a button in your top-menu
*/
if ( ! function_exists( 'ygf_add_menuclass' ) ) {
  function ygf_add_menuclass($ulclass) {
      $find = array('/<a rel="button"/', '/<a title=".*?" rel="button"/');
      $replace = array('<a rel="button" class="button"', '<a rel="button" class="button"');

      return preg_replace( $find, $replace, $ulclass, 1 );
  }
  add_filter( 'wp_nav_menu','ygf_add_menuclass' );
}


// Add mini cart to menu if on a shop page

// add_action('genesis_header_right', 'ygf_add_mini_cart');

function ygf_add_mini_cart(){
	global $woo_options;
	global $woocommerce;
	if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) && is_woocommerce()) :

		$mini_cart ='<a href="'.esc_url( $woocommerce->cart->get_cart_url() ).'" class="mini-cart"><span>'.$woocommerce->cart->cart_contents_count.'</span></a>';
		echo $mini_cart;
	endif;
}

// Handle cart in header fragment for ajax add to cart
// add_filter('add_to_cart_fragments', 'ygf_ajax_mini_cart');
function ygf_ajax_mini_cart( $fragments ) {
	global $woocommerce;
	global $theretailer_theme_options;
	ob_start();
	?>

      	<a href="<?php echo esc_url( $woocommerce->cart->get_cart_url() );?>" class="mini-cart"><span><?php echo $woocommerce->cart->cart_contents_count;?></span></a>

	<?php
	$fragments['.mini-cart'] = ob_get_clean();
	return $fragments;
}
