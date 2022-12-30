<?php get_header(); ?>

<!-- ======================Best Seller============================= -->
<?php if(class_exists( 'WooCommerce' )): ?>
        <section class="best_seller_section">

        <?php 

                $query = new WC_Product_Query( array(
                    'limit' => 4,
                    'orderby'   => array( 'meta_value_num' => 'DESC', 'title' => 'ASC' ),
                    'meta_key'  => 'total_sales',
                ) );
                $best_products = $query->get_products();  
                
                // echo "<pre>";
                //     print_r( $products);    
                // echo "</pre>";

              
        ?>
           <div class="container">
                <?php
                
                    $service_title = get_theme_mod("font_page_section_title_bestSeller_setting_id", "");

                    $service_title_color = get_option("font_page_section_title_text_color_bestSeller_setting_id",""); 
                    $sideBar_color = get_option("font_page_section_title_sideBar_color_bestSeller_setting_id",""); 
                    $service_sideBar_color = $sideBar_color != "" ? "border-left: 0.5rem solid $sideBar_color":"border-left: none";

                ?>
                
                    <?php if(!empty($service_title)): ?>
                        <div class="section_title" style="<?=$service_sideBar_color?>;">
                            <h3 style="color:<?=$service_title_color?>;"><?= $service_title?></h3>
                        </div>
                    <?php endif; ?>
                  
                <div class="best_seller_product row row-cols-1 row-cols-md-2 row-cols-lg-4 g-5">
                    <?php if(!empty($best_products)): ?>
                        <?php foreach($best_products as $product):?>
                        
                           <?php get_template_part("templates/archive-page/product", null, array("id" => $product->get_id())) ?>

                        <?php endforeach; ?>   
                    <?php endif; ?>
                </div>
                <div class="view_all_product">
                    <div class="_blank"></div>
                    <div class="view_all_product_sign"><span><i class="fa-solid fa-chevron-right"></i></span></div>
                    <a href="<?php echo site_url() ?>/shop"><div class="view_all_product_text"><p>View all</p></div></a>
                </div>
           </div>
        </section>
<!-- ====================== New Arrival============================= -->
        <section class="new_arrival_section">

                <?php 

                    $query = new WC_Product_Query( array(
                        'limit' => 4,
                        'orderby' => 'date',
                        'order' => 'DESC',
                    ) );
                    $new_products = $query->get_products();  
                    
                ?>
           <div class="container">

                <?php
                    
                    $newArrival_title = get_theme_mod("font_page_section_title_newArrival_setting_id", "");

                    $newArrival_title_color = get_option("font_page_section_title_text_color_newArrival_setting_id",""); 

                    $newArrival_color = get_option("font_page_section_title_sideBar_color_newArrival_setting_id",""); 
                    $newArrival_sideBar_color = $newArrival_color != "" ? "border-left: 0.5rem solid $newArrival_color":"border-left: none";

                ?>
            
                <?php if(!empty($newArrival_title)): ?>
                    <div class="section_title" style="<?=$newArrival_sideBar_color?>;">
                        <h3 style="color:<?=$newArrival_title_color?>;"><?=$newArrival_title?></h3>
                    </div>
                <?php endif; ?>

                <div class="new_arrival_product row row-cols-1 row-cols-md-2 row-cols-lg-4 g-5">

                    <?php if($new_products): ?>
                        <?php foreach($new_products as $product):?>

                            <?php get_template_part("templates/archive-page/product", null, array("id" => $product->get_id())) ?>

                        <?php endforeach; ?>   
                    <?php endif; ?>
                </div>
                <div class="view_all_product">
                    <div class="_blank"></div>
                    <div class="view_all_product_sign"><span><i class="fa-solid fa-chevron-right"></i></span></div>
                    <a href="<?php echo site_url() ?>/shop"><div class="view_all_product_text"><p>View all</p></div></a>
                </div>
            </div>
        </section>

<!-- ====================== News Information============================= -->
<?php
        $news_cats = get_terms('news_cat');
        $add_terms = [];
?>

        <section class="news_section">
            <div class="container news-wrapper">
                
                <?php
                    
                    $news_title = get_theme_mod("font_page_section_title_News_setting_id", "");

                    $news_title_color = get_option("font_page_section_title_text_color_News_setting_id",""); 

                    $news_color = get_option("font_page_section_title_sideBar_color_News_setting_id",""); 
                    $news_sideBar_color = $news_color != "" ? "border-left: 0.5rem solid $news_color":"border-left: none";

                ?>
            
                <?php if(!empty($news_title)): ?>
                    <div class="section_title" style="<?=$news_sideBar_color?>;">
                        <h3 style="color:<?=$news_title_color?>;"><?=$news_title?></h3>
                    </div>
                <?php endif; ?>

                <div class="news">
                    <div class="news_nav">
                            <div></div>
                            <ul class="news_nav_list">
                                <a href="#all"><li class="news_nav_item active">All</li></a>
                                <?php if(!empty($news_cats)): ?>
                                    <?php foreach($news_cats as $news_cat): ?>
                                        <a href="#<?=$news_cat->slug?>"><li class="news_nav_item"><?=$news_cat->name?></li></a>
                                        <?php $add_terms[] = $news_cat->slug?>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </ul>
                            <select name="news_nav_list_small" class="news_nav_list_small">
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
                                $args = [
                                    'post_type'         => 'news',
                                    'posts_per_page'    => 5,
                                    'post_status'       => 'publish'
                                ];

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
                                    <!-- pagination here -->

                                    <?php wp_reset_postdata(); ?>

                                <?php else : ?>
                                    <p><?php _e( 'Sorry, no posts matched your criteria.' ); ?></p>
                            <?php endif; ?>
                        </div>
                        <?php foreach($add_terms as $add_term): ?>
                            <div class="news_list_" id="<?=$add_term?>" >
                                <?php
                                // the query
                                $args = [
                                    'post_type'         => 'news',
                                    'posts_per_page'    => 5,
                                    'post_status'       => 'publish',
                                    'tax_query'         => array(
                                        array(
                                            'taxonomy'  => 'news_cat',
                                            'field'     => 'slug',
                                            'terms'     => $add_term,
                                        )
                                    )
                                ];

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
                                    <!-- pagination here -->

                                    <?php wp_reset_postdata(); ?>

                                <?php else : ?>
                                    <p><?php _e( 'Sorry, no posts matched your criteria.' ); ?></p>
                                <?php endif; ?>
                            </div>  
                        <?php endforeach; ?>
                    </div>     
                </div>
                <div class="view_all_product">
                    <div class="_blank"></div>
                    <div class="view_all_product_sign"><span><i class="fa-solid fa-chevron-right"></i></span></div>
                    <a href="<?php echo site_url() ?>/news"><div class="view_all_product_text"><p>View all</p></div></a>
                </div>                   
            </div>

        </section>

<!-- ====================== Collection Product ============================= -->
        <section class="favourite_collection_section">
            <?php 

                $products = wc_get_products( array(
                    'limit' => -1,
                    'post_status' => 'public',
                    'post_type' => 'product',
                    'taxonomy' => 'field-cat',
                ) );
                

            ?>
            <div class="container">

                <?php
                    
                    $collection_title = get_theme_mod("font_page_section_title_Collection_setting_id", "");

                    $collection_title_color = get_option("font_page_section_title_text_color_Collection_setting_id",""); 

                    $collection_color = get_option("font_page_section_title_sideBar_color_Collection_setting_id",""); 
                    $collection_sideBar_color = $collection_color != "" ? "border-left: 0.5rem solid $collection_color":"border-left: none";

                ?>
            
                <?php if(!empty($collection_title)): ?>

                    <div class="section_title" style="<?=$collection_sideBar_color?>;">
                        <h3 style="color:<?=$collection_title_color?>;"><?=$collection_title?></h3>
                    </div>

                <?php endif; ?>

                    <?php

                        $values = get_theme_mod("font_page_collection_product_setting_id");
                       
                        $datas = maybe_unserialize($values);

                        $field_terms = get_terms("field-cat");

                        // echo "<pre>";
                        //     print_r($field_term);    
                        // echo "</pre>";
                                  
                    ?>
                <?php if(!empty($datas) && is_array($datas)): ?>
                       
                       
                    <div class="favourite_collection_product mx-auto row row-cols-1 row-cols-md-2 row-cols-lg-4 g-5"> 

                            <?php foreach($datas as $data): ?>
                            <?php

                                $field_title = esc_attr($data['title']);
                                $field_text = esc_attr($data['text']);
                                $field_slug = esc_attr($data['slug']);
                                $field_img_id =  esc_attr($data['image_id']);
                                $image_url = wp_get_attachment_url($field_img_id);
                                $field_id = "";

                                foreach($field_terms as $field_term){
                                    if($field_term->slug == $field_slug){
                                        $field_id = $field_term->term_id;
                                    }
                                }

                               $field_url = get_category_link( $field_id ); 


                            ?>

                               <div class="col d-flex justify-content-center">
                                    <div class="collection-product-item">
                                            <div class="collection-product-image">
                                                <img src="<?=$image_url?>" alt="collection-image">
                                            </div>
                                            <div class="field_title">
                                                <h4><?=$field_title?></h4>
                                            </div>
                                            <div>
                                                <a href="<?=$field_url?>"><button class="field-button"><?= $field_text?></button></a>
                                            </div>
                                    </div> 
                               </div> 
                            <?php endforeach; ?> 
                    </div>
                <?php endif; ?> 
                <div class="view_all_product">
                    <div class="_blank"></div>
                    <div class="view_all_product_sign"><span><i class="fa-solid fa-chevron-right"></i></span></div>
                    <a href="<?php echo site_url() ?>/shop"><div class="view_all_product_text"><p>View all</p></div></a>
                </div>   
            </div>  
        </section>

<!-- ====================== Distributor ============================= -->

        <section class="distributor-section">
                <div class="container">

                <?php
                    
                    $authorized_title = get_theme_mod("font_page_section_title_Authorized_setting_id", "");

                    $authorized_title_color = get_option("font_page_section_title_text_color_Authorized_setting_id",""); 

                    $authorized_color = get_option("font_page_section_title_sideBar_color_Authorized_setting_id",""); 
                    $authorized_sideBar_color = $authorized_color != "" ? "border-left: 0.5rem solid $authorized_color":"border-left: none";

                ?>
            
                <?php if(!empty($authorized_title)): ?>

                    <div class="section_title" style="<?=$authorized_sideBar_color?>;">
                        <h3 style="color:<?=$authorized_title_color?>;"><?=$authorized_title?></h3>
                    </div>

                <?php endif; ?>
                    
                    <?php

                        $values = get_theme_mod("front_page_authorized_setting_id", "Nothing");
                       
                        $datas = maybe_unserialize($values);

                                  
                    ?>
                    <?php if(!empty($datas) && is_array($datas)): ?>

                        <div class="authorized_distributor row row-cols-1 row-cols-md-5 g-5"> 
                            <?php foreach($datas as $data): ?>
                                <?php

                                    $field_img_id =  esc_attr($data['image_id']);
                                    $image_url = wp_get_attachment_url($field_img_id);
                                   
                                ?>
                                <div class="col d-flex justify-content-center align-items-center">
                                    <div class="authorized_distributor_item">
                                        <img src="<?=$image_url?>" class="card-img-top">
                                    </div>
                                </div> 
                            <?php endforeach; ?>   
                        </div>

                    <?php endif; ?> 
          
                </div>                
        </section>

<!-- ====================== Value Service To Customer ============================= -->

        <?php

            $service_bg_color = get_option("front_page_service_bg_color_setting_id","#fff"); 
            $service_icon_color = get_option("front_page_service_Icon_color_setting_id","#0099ff");                    

            $service_title = get_theme_mod("front_page_service_text_setting_id", "");
            $service_content = get_theme_mod("front_page_service_text_content_setting_id", "");
            $service_text_color = get_option("front_page_service_text_content_color_setting_id");     

            $service_item_text_color = get_option("front_page_service_text_color_setting_id"); 
            
            $service_item_bg_color = get_option("front_page_service_item_bg_color_setting_id"); 
          
        ?>

        <section class="service-provide-section" style="background-color: <?=$service_bg_color?>;">
                <div class="container pt-5" >

                        <div class="service-provide-info">

                            <?php if(!empty($service_title)): ?>
                                <h3 class="service-provide-title" style="color: <?=$service_text_color?>"><?=$service_title?></h3>
                            <?php endif; ?> 

                            <?php if(!empty($service_content)): ?>
                                <p class="service-provide-content" style="color: <?=$service_text_color?>"><?=$service_content?></p>
                            <?php endif; ?> 

                        </div>   
                    
                        <?php

                            $values_service = get_theme_mod("front_page_service_setting_id", "Nothing");
                        
                            $datas = maybe_unserialize($values_service);

                            //print_r( $datas);
                            
                            //$service_num = count($datas);
                                    
                        ?>
                        <?php if(!empty($datas) && is_array($datas)): ?>

                            <div class="service-provide mx-auto row row-cols-1 row-cols-md-2 row-cols-lg-4 g-5"> 
                                <?php foreach($datas as $data): ?>
                                
                                    <div class="col d-flex justify-content-center">
                                        <div class="card h-100" style="background-color: <?=$service_item_bg_color?>">
                                            <div class="service service-item">
                                                <div class="service-image">
                                                    <p style="color: <?=$service_icon_color?>"><i class="<?=$data["icon"]?>"></i></p>
                                                </div>
                                                <div class="card-body text-center">
                                                    <h5 class="card-title" style="color: <?=$service_item_text_color?>"><?=$data["title"]?></h5>
                                                    <p class="card-text" style="color: <?=$service_item_text_color?>"><?=$data["content"]?></p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                <?php endforeach; ?>   
                            </div>

                        <?php endif; ?> 
                              
                </div>                
        </section>                        


    </main>

<?php get_footer(); ?>

<?php else: ?>

<h1>Only with Woocommerce be activated</h1>

<?php endif; ?>