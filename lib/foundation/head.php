<?php

add_action('wp_head', 'ygf_add_responsive_meta', 2);

function ygf_add_responsive_meta(){
  echo '<meta class="foundation-mq"/>';
}
