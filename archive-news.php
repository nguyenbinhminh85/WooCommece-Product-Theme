<?php get_header(); ?>


<?php
        $news_cats = get_terms('news_cat');

        global $wp;
        $curr_url = home_url(add_query_arg(array(), $wp->request));
        
        $filter_values = filter_var_array($_GET);
        
?>

        <section class="news_section">
            <div class="container news-wrapper">
                <!-- <div class="section_title">
                    <h3>News</h3>
                </div> -->
                <div class="news">
                    <div class="news_nav">
                            <?php echo wp_nonce_field("news_info_action", "news_info_nonce") ?>
                            <input type="hidden" value="<?=$curr_url?>" class="current_news_url">
                           

                            <?php if ( empty($filter_values['info']) ): ?>
                                <div class="active_item d-flex align-items-center" data-active-value="all"><h5>All</h5></div>
                            <?php else: ?> 
                                <div class="active_item d-flex align-items-center" data-active-value="<?=$filter_values['info']?>"><h5><?=ucfirst($filter_values['info'])?></h5></div>
                            <?php endif; ?> 

                            <ul class="news_nav_list">
                                <li class="news_nav_item_page" data-value="all">All</li>
                                <?php if(!empty($news_cats)): ?>
                                    <?php foreach($news_cats as $news_cat): ?>
                                        <li class="news_nav_item_page" data-value="<?=$news_cat->slug?>"><?=$news_cat->name?></li>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </ul>
                            <select name="news_nav_list_small" class="news_nav_list_small_page">
                                <option value="all" selected>All</option>
                                <?php if(!empty($news_cats)): ?>

                                    <?php foreach($news_cats as $news_cat): ?>
                                        <option value="<?=$news_cat->slug?>"><?=$news_cat->name?></option>
                                    <?php endforeach; ?>

                                <?php endif; ?>
                            </select>
                    </div>  
                    <div class="news_list">

                        <div class="news_list_ is_active" id="all" >
                            <?php
                                // the query
                                $paged = ( get_query_var( 'paged' ) ) ? absint( get_query_var( 'paged' ) ) : 1;

                                if(!empty($filter_values['info'])){

                                    if($filter_values['info'] == 'all'){

                                        $args = [
                                            'post_type'         => 'news',
                                            'posts_per_page'    => 10,
                                            'post_status'       => 'publish',
                                            'paged' => $paged,
                            
                                        ];

                                    }else{

                                        $args = [
                                            'post_type'         => 'news',
                                            'posts_per_page'    => 10,
                                            'post_status'       => 'publish',
                                            'paged' => $paged,
                                            'tax_query'         => array(
                                                array(
                                                    'taxonomy'  => 'news_cat',
                                                    'field'     => 'slug',
                                                    'terms'     => $filter_values['info'],
                                                )
                                            )
                                        ];
        
                                    }
                                }else{
                                    $args = [
                                        'post_type'         => 'news',
                                        'posts_per_page'    => 10,
                                        'post_status'       => 'publish',
                                        'paged' => $paged,
                        
                                    ];
                                }
                               
                                $the_query = new WP_Query( $args ); 
                
                            ?>
                            <?php if ( $the_query->have_posts() ) : ?>

                                    <!-- pagination here -->
                                    <ul class="news_list_info">
                                    <!-- the loop -->
                                        <?php while ( $the_query->have_posts() ) : $the_query->the_post(); ?>
                                    
                                            <li class="news_list_item row">
                                                <span class="col-lg-3 col-md-6 mb-3"><?php echo get_the_date() ?></span>
                                                <div class="news_list_item_term col-lg-3 col-md-6 mb-3"><?php $term = (get_the_terms(get_the_ID(), 'news_cat')) ? (get_the_terms(get_the_ID(), 'news_cat')):""; echo $term[0]->name ?></div>
                                                <a class="col-lg-6 col-md-12 mb-3" href="<?php echo get_permalink() ?>"><p><?php the_title(); ?></p></a>
                                            </li>
                                    
                                        <?php endwhile; ?>
                                    <!-- end of the loop -->
                                    </ul>    
                                    <div class="news_page_pagination">
                                                <?php  

                                                    global $wp_query; global $wp_rewrite;
                                                    $args =  [
                                                        'base'    => add_query_arg('paged', '%#%'),
                                                        'format'  => '',
                                                        'current' => $paged,
                                                        'show_all'  => false,
                                                        'type'    => 'array',
                                                        'total'   => $the_query->max_num_pages,
                                                    
                                                    ];

                                    
            
                                                    if(!empty($filter_values['info'])){
                                                        $link = esc_url(remove_query_arg(['info'], get_pagenum_link(1)));
                                                        $link = user_trailingslashit(trailingslashit($link)."page/%#%", 'paged');
                                                        $args['base'] = $link;
                                                        $args['add_args'] = ['info' => $filter_values['info']];
                                                    }
                           
                                                    $paginations = paginate_links($args);
                                                ?>
                                                
                                                <?php if(!empty($paginations)):?>  

                                                    <nav aria-label="Page navigation">

                                                        <ul class="pagination">
                                                            <?php foreach($paginations as $key=>$pagination): ?>
                                                                <?php
                                                                    $page_link = str_replace("page-numbers", "page-link", $pagination);
                                                                ?>
                                                                <?php if(strpos($page_link, "current") !== false): ?>
                                                                    <li class="page-item active"><?php echo $page_link ?></li>
                                                                <?php else: ?>
                                                                    <li class="page-item"><?php echo $page_link ?></li>
                                                                <?php endif; ?>
                                                            <?php endforeach; ?>
                                                        
                                                        </ul>

                                                    </nav>

                                                <?php endif; ?>     
                                            </div>

                                    <?php wp_reset_postdata(); ?>


                                <?php else : ?>
                                    <p><?php _e( 'Sorry, no posts matched your criteria.' ); ?></p>
                            <?php endif; ?>
                        </div>
                      
                    </div>     
                </div>

            </div>

        </section>
        
<?php get_footer(); ?>