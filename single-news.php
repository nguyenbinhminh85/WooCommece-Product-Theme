<?php get_header(); ?>

<?php

$slug = wp_basename(get_the_permalink());

?>

    <section class="news_single_section">

        <div class="container">
            <?php
                // the query
                $args = [
                    'post_type'         => 'news',
                    'post_status'       => 'public',
                    'name'              => $slug
                ];

                $news_query = new WP_Query( $args ); 
            ?>

            <?php if ( $news_query->have_posts() ) : ?>

            <!-- pagination here -->

                <!-- the loop -->
                <?php while ( $news_query->have_posts() ) : $news_query->the_post(); ?>
                    <p><?php the_content(); ?></p>
                <?php endwhile; ?>
                <!-- end of the loop -->

            <!-- pagination here -->

                <?php wp_reset_postdata(); ?>

            <?php else : ?>
                <p><?php _e( 'Sorry, no posts matched your criteria.' ); ?></p>
            <?php endif; ?>
        </div>

    </section>
        
<?php get_footer(); ?>
