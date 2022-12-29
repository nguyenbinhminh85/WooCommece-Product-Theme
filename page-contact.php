<?php get_header(); ?>

    <div class="container">

    <section class="contact-page">
    
            <?php if ( have_posts() ) : ?>
                <?php while ( have_posts() ) : the_post() ?>
                
                   
                    
                    <div class="contact-page-content">

                        <?php the_content(); ?>
                        
                    </div>

               <?php endwhile; ?>

            <?php endif; ?>
    </section>

    </div>


<?php get_footer(); ?>