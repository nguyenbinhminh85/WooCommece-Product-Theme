<?php get_header(); ?>

        <section class="index-section">
           
            <div class="container">
                
                <div class="section-inner thin error 404-content">

                    <h1 class="entry-title"><?php _e( 'Page Not Found' ); ?></h1>

                    <div class="intro-text"><p><?php _e( 'The page you were looking for could not be found. It might have been removed, renamed, or did not exist in the first place.' ); ?></p></div>

                    <?php
                        get_search_form(
                            array(
                                'aria_label' => __( '404 not found', 'twentytwenty' ),
                            )
                        );
                    ?>

                </div><!-- .section-inner -->

            </div>

        </section>
   

<?php get_footer(); ?>
