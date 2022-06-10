<?php

// @package sunsettheme

get_header(); ?>

    <div id="primary" class="content-area">

        <main id="main" class="site-main" role="main">

            <div class="container">

                <?php

                    if ( have_posts() ) :
                        $i = 1;
                        while ( have_posts() && $i < 6 ) : the_post();

                            get_template_part( 'template-parts/content', get_post_format() );

                        $i++;
                        endwhile;

                    endif;

                ?>

            </div> <!-- .container -->

        </main>

    </div> <!-- #primary -->

<?php get_footer(); ?>