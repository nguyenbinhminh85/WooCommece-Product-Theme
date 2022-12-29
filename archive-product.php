<?php get_header(); ?>

<?php if(class_exists("woocommerce")):?>

<?php if(is_shop()):?>
    <?php if(!is_search()):?>
        <?php 

            $paged = get_query_var('paged')? (int)get_query_var('paged'):1;
        
            $query = wc_get_products(array(
                'post_status'       => 'publish',
                'limit'             => 10,
                'paginate'          =>true,
                'page'              => $paged,
                'orderby'           => 'date',
                'order'             => 'DESC',
                
            ));

            $products = $query->products;
            $filter_values = filter_var_array($_GET);

            
        ?>

            <?php  $variation_ids = []; $key_filter_w = []; ?>

            <?php if(!empty($products)): ?>

                <?php foreach($products as $product):?>
                
                    <?php if($product->get_type() == "variable"): ?>
                        <?php
                            $avail_variations = $product->get_available_variations();
                            $selection = [];
                            
                            foreach($avail_variations as $key => $variation){
                                
                                foreach($variation['attributes'] as $key=>$value){
                                    $current_attr = str_replace("attribute_pa_", "", $key);
                                    if(!in_array($current_attr, $key_filter_w)){
                                        array_push($key_filter_w, $current_attr);
                                    }

                                    if(!empty($filter_values)){

                                        $filter_keys_ = array_keys($filter_values);
                                        $filter_values_ = array_values($filter_values);

                                    
                                        if(in_array($current_attr, $filter_keys_)){

                                            if(!in_array($current_attr, $selection)){
                                                array_push($selection, $current_attr);
                                            }

                                        }

                                    }
                                
                                }
                                
                                
                                $success = [];
                                if(!empty($selection))
                                {
                                    foreach($selection as $select){

                                        $current_val = strtolower($variation['attributes']["attribute_pa_".$select]);
                                    
                                        foreach($filter_values_ as $key => $filter_value){

                                            if(strpos($filter_value, ",")){
                                                $filter_value_ = explode(",", strtolower($filter_value));
                                                foreach($filter_value_ as $key => $value_){
                                                    if(strpos($value_, " ")){
                                                        $value_ = trim($value_);
                                                        $filter_value_[$key] = str_replace(" ", "-", $value_);
                                                    }
                                                }

                                                if( in_array($current_val, $filter_value_) ){
                                                    $success[] = "add";
                                                }
                                            }else{

                                                if(strpos($filter_value, " ")){
                                                    $filter_value = trim($filter_value);
                                                    $filter_value = str_replace(" ", "-", $filter_value);
                                                }
                                            
                                                if( $current_val == strtolower($filter_value) ){
                                                    $success[] = "add";
                                                }
                                            }   
                                        }
                                        
                                    }
                                }

                                // echo "<pre>";
                                //     print_r($success);
                                // echo "</pre>";
                                // echo count($success);
                                // echo "<br>";
                                // echo count($selection);
                                // echo "<br>";
                            
                                if( count($success) > 0 && count($success) == count($selection)){
                                    $variation_id = $variation['variation_id'];
                                    if(!in_array($variation_id, $variation_ids)){
                                        array_push($variation_ids, $variation_id);
                                    }
                                }
                                        
                            }
                            
                        ?>
                    <?php endif; ?>
                <?php endforeach; ?> 

            <?php endif; ?>
 
        <?php

            $nav_products = wc_get_products(array(
                'post_status'       => 'publish',
                'orderby'           => 'date',
                'order'             => 'DESC',
                'limit'             => -1
            ));

            $categories = [];
            foreach($nav_products as $pro){
                if(!in_array($pro->get_categories(),$categories)){
                    array_push($categories, $pro->get_categories());
                } 
            } 

        ?>
        
            <section class="shop_section">
                <?php 
                    global $wp;
                    $current_url = home_url(add_query_arg(array(), $wp->request)); 
                
                ?>
                <input type="hidden" class="current_url" value="<?=$current_url?>">
                <?php wp_nonce_field('add_filter_nonce_action', 'add_filter_nonce_name');?>

                <?php if(!empty($filter_values)): ?>    
                    <div class="selected_data" style="display: none;">
                        <?php foreach($filter_values as $key => $value): ?>
                            <input class="select_filter_var" type="text" data-selected-key="<?=$key?>" value="<?=$value?>">
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>     

                <div class="container">
                    
                    <div class="shop_page_filter_nav row">
                        
                        <div class="shop_page_nav_item col">
                            <h6>Category <span><i class="fa-solid fa-chevron-down"></i></span></h6>
                            <div class="shop_page_list_content">
                                <?php if(!empty($categories)): ?>
                                    <?php foreach($categories as $cat):?>
                                        <p class="shop_product_item"><?=$cat?></p>
                                    <?php endforeach; ?> 
                                <?php endif; ?>
                            </div>
                        </div>

                        <?php foreach($key_filter_w as $word): ?>

                            <?php

                                $find_ = strpos($word, "-"); 
                                $attr_name = "";
                                if($find_){
                                    $current_w = explode("-", $word);
                                    foreach($current_w as $wor){
                                        $attr_name .= $wor." ";
                                    }
                                }else{
                                    $attr_name = $word;
                                }   
                                
                                $attr_name = ucfirst($attr_name);

                                $attr_values = [];
                                foreach($nav_products as $product){ 
                                    $attrs =  $product->get_attribute("$attr_name");
                                    
                                
                                    if(!empty($attrs)){
                                        $attrs = explode(",", $attrs);
                            
                                        if(is_array( $attrs)){
                                            foreach($attrs as $attr){
                                                if(!in_array(trim($attr), $attr_values)){
                                                    array_push($attr_values, trim($attr));
                                                }
                                            
                                            }
                                        }
                                    }        
                                }

                            ?>

                            <div class="shop_page_nav_item col">
                                <h6><?=$attr_name?><span><i class="fa-solid fa-chevron-down"></i></span></h6>
                                <div class="shop_page_list_content">
                                
                                    <?php if(!empty($attr_values)): ?>
                                        <?php foreach($attr_values as $attr):?>
                                            
                                            <div class="shop_product_item">
                                                <input type="checkbox" class="attr_product_item" value="<?=$attr?>" data-attr-key = "<?=$word?>">
                                                <label><?=$attr?></label>
                                            </div>

                                        <?php endforeach; ?> 
                                    <?php endif; ?>

                                </div>
                            </div>

                        <?php endforeach; ?>
                                    
                    </div>
                                        
                
                        <?php if(!empty($variation_ids)): ?>    

                            <div class="archive_page_product row row-cols-1 row-cols-md-2 row-cols-lg-4 g-5">
                            
                                <?php foreach($variation_ids as $variation_id):?>

                                    <?php get_template_part( "templates/archive-page/product", null, ["id" => $variation_id] )?>

                                <?php endforeach; ?> 

                            </div> 
                        
                        <?php else: ?>
                            
                                <?php if(!empty($products)): ?>

                                    <?php if(!empty($filter_values)):?>

                                        <div class="none-info">
                                            <div class="non-info-message">
                                                <p><?php esc_html_e( 'It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.'); ?></p>
                                                <h1>Shop</h1>
                                            </div>
                                            <?php get_search_form(); ?>
                                        </div>

                                            
                                    <?php else: ?>

                                        <div class="archive_page_product row row-cols-1 row-cols-md-2 row-cols-lg-4 g-5">

                                            <?php foreach($products as $product):?>
                                                

                                                <?php get_template_part( "templates/archive-page/product", null, ["id" => $product->get_id()] )?>

                                            <?php endforeach; ?>  

                                        </div>

                                        <?php if(empty($variation_id)):?>   
                                            <div class="shop_page_pagination">
                                                <?php  
                                                    $paginations = paginate_links( [
                                                        'base'    => get_pagenum_link( 1 ) . '%_%',
                                                        'format'  => 'page/%#%',
                                                        'current' => $paged,
                                                        'type'    => 'array',
                                                        'total'   => $query->max_num_pages,
                                                    
                                                    ])
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
                                         <?php endif; ?>

                                    <?php endif; ?>

                                <?php endif; ?>
                                
                        <?php endif; ?>

                    

                </div>
            </section>
       
    <?php elseif(is_search()):?>
       
        <section class="shop_section" id="search_result">

            <div class="container">    
                    <?php

                        $s = get_query_var('s');
                       
                        $args = [
                            'post_status'       => 'publish',
                            'limit'             => 10,
                             's'                => $s,
                            'paginate'          =>true,
                            'page'              => $paged,
                            
                        ];

                        $query = wc_get_products($args);
                        $products = $query->products;

                    ?>
                
                    <?php if(!empty($s)): ?>
                       
                        <?php if(!empty($products)): ?>
                            <header class="search_header">
                                <h3 class="page-title">
                                    <?php
                                    printf(
                                        /* translators: %s: Search term. */
                                        esc_html__( 'Results for "%s"', 'twentytwentyone' ),
                                        '<span class="page-description search-term">' . esc_html( get_search_query() ) . '</span>'
                                    );
                                    ?>
                                </h3>
                            </header><!-- .page-header -->
                            <div class="search-result-count">
                                <?php
                                    printf(
                                        esc_html(
                                            /* translators: %d: The number of search results. */
                                            _n(
                                                'We found %d result for your search.',
                                                'We found %d results for your search.',
                                                (int) $wp_query->found_posts,
                                                
                                            )
                                        ),
                                        (int) $wp_query->found_posts
                                    );
                                ?>
                            </div><!-- .search-result-count -->
                            
                            <div class="search_page_product row row-cols-1 row-cols-md-2 row-cols-lg-4 g-5">

                                <?php foreach($products as $product): ?>
                                    <?php 
                                        $product_id = $product->get_id();
                                        
                                        get_template_part( "templates/archive-page/product", null, ["id" => $product->get_id()] );
                                    ?>

                                <?php endforeach; ?>   
                               
                            </div> 
                                <div class="shop_page_pagination">
                                    <?php  

                                        global $wp_query; global $wp_rewrite;

                                        $paged = get_query_var('paged') > 1 ? get_query_var('paged'):1;

                                        $args =  [
                                            'base'    => add_query_arg('paged', '%#%'),
                                            'format'  => '',
                                            'current' => $paged,
                                            'show_all'  => false,
                                            'type'    => 'array',
                                            'total'   => $query->max_num_pages,
                                        
                                        ];

                                        if($wp_query->query_vars['s']){
                                            $link = esc_url(remove_query_arg(['s', 'post_type'], get_pagenum_link(1)));
                                            $link = strstr($link,"#", true);
                                            $link = user_trailingslashit(trailingslashit($link)."page/%#%", 'paged');
                                            $args['base'] = $link;
                                            $args['add_args'] = ['s' => get_query_var('s'), 'post_type' => 'product'];
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
                        
                        <?php else: ?> 

                            <div class="none-info">
                                <div class="non-info-message">
                                    <p><?php esc_html_e( 'It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.'); ?></p>
                                    <h1>Search</h1>
                                </div>
                                <?php get_search_form(); ?>
                            </div>
                                
                        <?php endif; ?> 

                    <?php endif; ?>
                            
               

            </div> 
        </section>
       
    <?php endif ?> 
<?php endif ?> 

<?php endif; ?>
<?php get_footer(); ?>

