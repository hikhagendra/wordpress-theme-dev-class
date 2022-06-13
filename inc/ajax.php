<?php

// @package sunsettheme
//     =======================
//     AJAX FUNCTIONs
//     =======================

add_action( 'wp_ajax_nopriv_sunset_load_more', 'sunset_load_more' );
add_action( 'wp_ajax_sunset_load_more', 'sunset_load_more' );

function sunset_load_more() {
    
    $paged = $_POST['page']+1;
    $query = new WP_Query( array(
        'post_type'     =>  'post',
        'post_status'   =>  'publish',
        'paged'         =>  $paged
    ) );

    if ( $query->have_posts() ) :
        $i = 1;
        while ( $query->have_posts() ) : $query->the_post();

            get_template_part( 'template-parts/content', get_post_format() );

        $i++;
        endwhile;

    endif;

    wp_reset_postdata();

    die();
}