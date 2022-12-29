<?php get_header(); ?>

<?php 

        $term_slug = get_query_var( 'term' );


        if(has_term($term_slug,'product_cat')){

            $products = wc_get_products( array(
                'post_type'     => 'product',
                'limit'         => -1,
                'post_status'   => 'publish',
                 'category'     => array($term_slug),
            ) );
            
        }

        if(has_term($term_slug,'product_tag')){
            
            $products = wc_get_products( array(
                'post_type'     => 'product',
                'limit'         => -1,
                'post_status'   => 'publish',
                 'tag'     => array($term_slug),
            ) );

        }

       
        if(has_term($term_slug,'field-cat')){
            
            $products = wc_get_products( array(
                'post_type'     => 'product',
                'limit'         => -1,
                'post_status'   => 'publish',
                 'tax_query'    => array(
                    array(
                        'taxonomy' => 'field-cat',
                         'field'  => 'slug',
                         'terms'   => array($term_slug),
                    )
                ),
            ) );

        }

        $filter_values = filter_var_array($_GET);


        // echo "<pre>";
        //     print_r($products);
        // echo "</pre>";

    
?>

        <?php if(!empty($products)): ?>
            <?php  $variation_ids = []; $key_filter_w = []; ?>
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
    // echo "<pre>";
    //      print_r($key_filter_w);
    // echo "</pre>";
?>

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

<section class="shop_section">
    <div class="container">
        <div class="section_title mb-5">
            <h3><?=ucfirst($term_slug)?></h3>
        </div>

        <div class="shop_page_filter_nav row">
            <?php if(!empty($key_filter_w)): ?> 
                  
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
                        foreach($products as $product){ 
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
                <?php for($i = 0; $i < 5 - count($key_filter_w); $i ++):?>
                    <div class="shop_page_nav_item_blank col">
                    </div>
                <?php endfor; ?> 

            <?php endif; ?>                 
        </div>
                  
            
        <div class="archive_page_product row row-cols-1 row-cols-md-4 g-5">

            <?php if(!empty($variation_ids)): ?>    
                    
                <?php foreach($variation_ids as $variation_id):?>

                    <?php get_template_part( "templates/archive-page/product", null, ["id" => $variation_id] )?>

                <?php endforeach; ?>  
                
            <?php else: ?>
        
                <?php if(!empty($products)): ?>

                    <?php if(!empty($filter_values)):?>

                            <div><h4>Product Not Available!</h4></div>

                    <?php else: ?>

                        <?php foreach($products as $product):?>

                            <?php get_template_part( "templates/archive-page/product", null, ["id" => $product->get_id()] )?>

                        <?php endforeach; ?>  

                    <?php endif; ?>
                <?php endif; ?>
            
            <?php endif; ?>

        </div>    
    </div>
</section>
  
      
<?php get_footer(); ?>
