<?php

add_filter( 'the_content_more_link', 'ygf_more_tag_excerpt_link' );
/**
 * Customize the excerpt text, when using the <!--more--> tag
 *
 * See: http://my.studiopress.com/snippets/post-excerpts/
 *
 * @since 2.0.16
 */
function ygf_more_tag_excerpt_link() {

	return ' <p><a class="more-link button flat" href="' . get_permalink() . '">'.__("Read More", 'genesis-foundation-child-theme' ).'</a></p>';

}

add_filter( 'excerpt_more', 'ygf_truncated_excerpt_link' );
add_filter( 'get_the_content_more_link', 'ygf_truncated_excerpt_link' );
/**
 * Customize the excerpt text, when using automatic truncation
 *
 * See: http://my.studiopress.com/snippets/post-excerpts/
 *
 * @since 2.0.16
 */
function ygf_truncated_excerpt_link() {

	return '... <p><a class="more-link waves-effect waves-light" href="' . get_permalink() . '">'.__("Read More", 'genesis-foundation-child-theme' ).'</a></p>';

}


/**
 *
 * Add class .th to single post featured images
 *
 **/
add_action( 'genesis_entry_content', 'single_post_featured_image', 5 );

function single_post_featured_image() {
	if(is_single()){
		if(has_post_thumbnail()){
			the_post_thumbnail('large', array('class' => 'th') );
		}
	}
}

/**
 *
 * Add flex-video wrapper to oembeded items
 *
 **/

function ygf_embed_filter( $html, $url, $attr ) {
    $yt = "/(?:https?:\\/\\/)?(?:www\\.)?(?:youtu\\.be\\/|youtube\\.com\\/(?:embed\\/|v\\/|playlist\\?|watch\\?v=|watch\\?.+(?:&|&#38;);v=))([a-zA-Z0-9\\-_]{11})?(?:(?:\\?|&|&#38;)index=((?:\\d){1,3}))?(?:(?:\\?|&|&#38;)?list=([a-zA-Z\\-_0-9]{34}))?(?:\\S+)?/"; 

    $vm = "/(?:https?:\/\/)?(?:www\.)?(?:vimeo\.com\/)((?:\d){1,3})?(?:\S+)?/";
 
    if(preg_match_all($yt, $url, $matches))
       $html = '<div class="flex-video">'. $html .'</div>';
    if(preg_match_all($vm, $url, $matches))
       $html = '<div class="flex-video vimeo">'. $html .'</div>';

    return $html;
}
add_filter('embed_oembed_html', 'ygf_embed_filter', 90, 3 );


/**
 *
 * Add author box on single posts
 *
 **/
add_filter( 'get_the_author_genesis_author_box_single', '__return_true' );


/**
 *
 * Add Next Previous Pagination
 *
 **/
add_action( 'genesis_after_entry_content', 'ygf_prev_next_post_nav', 5 );
function ygf_prev_next_post_nav(){

	if ( ! is_singular( 'post' ) )
		return;

	genesis_markup( array(
		'html5'   => '<ul %s>',
		'xhtml'   => '<ul class="pagination navigation">',
		'context' => 'adjacent-entry-pagination',
	) );

	echo '<li class="arrow pagination-previous alignleft">';
	previous_post_link('%link', '&#x000AB; %title');
	echo '</li>';

	echo '<li class="arrow pagination-next alignright">';
	next_post_link('%link', '%title &#x000BB;');
	echo '</li>';

	echo '</ul>';
}

