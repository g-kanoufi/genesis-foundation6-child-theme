<?php

// Remove the genesis default form
remove_filter( 'get_search_form', 'genesis_search_form');

// Replace with same function with added markup for foundation
add_filter( 'get_search_form', 'ygf_search_form' );

function ygf_search_form() {
	$search_text = get_search_query() ? apply_filters( 'the_search_query', get_search_query() ) : apply_filters( 'genesis_search_text', __( 'Search this website', 'genesis-foundation-child-theme' ) . '&#x02026;' );

	$button_text = apply_filters( 'genesis_search_button_text', esc_attr__( 'Search', 'genesis-foundation-child-theme' ) );

	$onfocus = "if ('" . esc_js( $search_text ) . "' === this.value) {this.value = '';}";
	$onblur  = "if ('' === this.value) {this.value = '" . esc_js( $search_text ) . "';}";

	//* Empty label, by default. Filterable.
	$label = apply_filters( 'genesis_search_form_label', '' );

	$value_or_placeholder = ( get_search_query() == '' ) ? 'placeholder' : 'value';

	if ( genesis_html5() )
		$form = sprintf( '<form method="get" class="search-form" action="%s" role="search"><div class="row collapse">%s<div class="large-8 small-9 columns"><input type="search" name="s" %s="%s" /></div><div class="large-4 small-3 columns"><input type="submit" class="button" value="%s" /></div></div></form>', home_url( '/' ), esc_html( $label ), $value_or_placeholder, esc_attr( $search_text ), esc_attr( $button_text ) );
	else

		$form = sprintf( '<form method="get" class="search-form" action="%s" role="search"><div class="row collapse">%s<div class="large-8 small-9 columns"><input type="text" name="s" %s="%s" /></div><div class="large-4 small-3 columns"><input type="submit" class="button" value="%s" /></div></div></form>', home_url( '/' ), esc_html( $label ), $value_or_placeholder, esc_attr( $search_text ), esc_attr( $button_text ) );

	return apply_filters( 'ygf_search_form', $form, $search_text, $button_text, $label );

}

