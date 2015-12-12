<?php

/**
 *
 * Add class .th to all images in the_content();
 *
 **/
function ygf_content_images_class($content) {
   global $post;
   $pattern ="/<img(.*?)class=\"(.*?)\"(.*?)>/i";
   $replacement = '<img$1class="$2 th"$3>';
   $content = preg_replace($pattern, $replacement, $content);
   return $content;
}
add_filter('the_content', 'ygf_content_images_class');


