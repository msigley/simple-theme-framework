<?php 
if ( have_posts() ) {
		the_post();
		$attachment = wp_get_attachment_image_src(get_the_ID(), 'full', false);
		wp_redirect($attachment[0], 301);
}