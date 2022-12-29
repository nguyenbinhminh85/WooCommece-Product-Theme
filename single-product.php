<?php get_header(); ?>

<?php if(class_exists("woocommerce")):?>

<?php

    $name = wp_basename( get_the_permalink() );

    if(isset($_GET) && !empty($_GET)){

        foreach($_GET as $key => $value){
            if(strpos($key, "_pa_", 0) > 0){
                $product_variation = filter_var_array($_GET);
            }else{
                $filter_values = filter_var_array($_GET);
            }
        }

    }

   
    $query = new WC_Product_Query( array(
        'limit' => 1,
         'name' => $name
    ) );
    $products = $query->get_products();



    $cat_products = get_terms('product_cat');

    // if(isset($cats)){
    //     echo "<pre>";
    //         print_r($cats);
    //     echo "</pre>";
    // }

    $cat_str = "";
    if(!empty($cat_products)){
        foreach($cat_products as $cat_product){
           $cat_link = get_category_link($cat_product->term_id);
           $cat_str .=" <a href='$cat_link'><span>".$cat_product->name."</span>,</a>  ";
        }
    }

    $cat_str_ = substr_replace($cat_str, "", -2);


    $tags = get_terms( 'product_tag' );
    $tag_str_ = "";

    if(!empty($tags)){
        foreach($tags as $tag){
           $tag_link = get_tag_link($tag->term_id);
           $tag_str_ .= "<a href='$tag_link'>" .$tag->name."</a>, ";
        }
    }
    $tag_str_ = substr_replace($tag_str_, "", -2);
      
   
?>


        <section class="single_product_section">
           <div class="container">
           <div class="add_to_cart_notices"></div>
                <?php if(!empty($products)): ?>

                    <?php foreach($products as $product):?>

                        <?php if($product->get_type() == 'variable' && !empty($product_variation)): ?>

                            <?php
                                $avail_attributes = $product->get_available_variations();

                                foreach($avail_attributes as $key => $value){

                                    if(count(array_diff_assoc($value["attributes"], $product_variation)) == 0){
                                        $variation_id =  $value["variation_id"];
                                    }
                                    
                                }

                                $variation_product = wc_get_product( $variation_id );

                                // echo "<pre>";
                                //     print_r($variation_product);
                                // echo "</pre>";
                            ?>    
                         <?php elseif( $product->get_type() == 'variable' && empty($product_variation) ): ?> 

                            <?php

                                $avail_attributes = $product->get_available_variations();
                                $variation_names = [];
                                $variation_values = [];

                                $selections = [];

                                foreach($avail_attributes as $key =>$variation){

                                    foreach( $variation["attributes"] as $key => $value){

                                        $name = str_replace("attribute_pa_", "",  $key);

                                        if(!in_array(trim($name), $variation_names)){
                                            array_push($variation_names, trim($name));
                                        }

                                        if(strpos($value, "-")){
                                            $value = str_replace("-", " ",  $value);
                                            $value = trim(ucfirst( $value));
                                        }else{
                                            $value = trim(ucfirst( $value));
                                        }

                                     
                                        foreach($variation_values as $_key => $_value){
                                            if($_key == trim($name)){
                                                foreach($_value as $__key => $__value){
                                                    if($__value == $value){
                                                        unset($variation_values[$_key][$__key]);
                                                    }
                                                }
                                            }
                                        }

                                        $variation_values[trim($name)][] = trim($value);

                                     
                                         if(!empty($filter_values)){
                                                $filter_keys_ = array_keys($filter_values);

                                                if(in_array($name, $filter_keys_)){
                                                    if(!in_array(trim($name), $selections)){
                                                        array_push($selections, trim($name));
                                                    }
                                                }

                                         }
                                       
                                    }

                                    $success = [];
                                    if(!empty($selections)){
                                        foreach($selections as $selection){
                                            $current_value = strtolower($variation["attributes"]["attribute_pa_".$selection]);
                                            
                                            foreach($filter_values as $key => $value){

                                                if(strpos($value, " ") !== false){
                                                    $value = strtolower(str_replace(" ", "-", $value));
                                                }else{
                                                    $value = strtolower($value);
                                                }

                                                if(strpos($value, $current_value) !== false){
                                                    $success[] = "added";
                                                }
                                            }
                                            
                                        }
                                    }

                                    if( count($success) > 0 && count($success) == count($selections)){
                                         $variation_id = $variation['variation_id'];
                                    }
                                }

                            ?>    
                        <?php endif; ?>

                        <div class="single-product-info single-product-item">
                            <div class="row">
                                <div class="single-product-slider col-md-6 col-12">
                                    <?php          
                                           $gallary_ids = $product->get_gallery_image_ids();
                                           $single_img_id = $product->get_image_id();

                                           $image_num = count( $gallary_ids);
                                    ?>

                                    <?php if(!empty($gallary_ids)):?>
                                        <div class="single-product-chervon chervon-left"><span><i class="fa-solid fa-chevron-left"></i></span></div> 
                                        <div class="single-product-chervon chervon-right"><span><i class="fa-solid fa-chevron-right"></i></span></div>
                                    <?php endif;?> 

                                    <div class="single-product-gallary-slider-screen">
                                        <?php if(!empty($gallary_ids)):?>

                                                <div class="single-product-gallary-slider-move">
                                                    <?php foreach($gallary_ids as $key => $gallary_id): ?>
                                                        <div class="single-product-gallary-slider-image" data-id=<?=$key?>>
                                                            <img src="<?=wp_get_attachment_url($gallary_id)?>" alt="single-product-gallary-slider-image">
                                                        </div>
                                                    <?php endforeach; ?>
                                                </div>

                                        <?php else:?> 

                                                <div class="single-product-gallary-slider-image active">
                                                    <img src="<?=wp_get_attachment_url($single_img_id)?>" alt="single-product-gallary-slider-image">
                                                </div>

                                        <?php endif;?> 
                                    </div> 
                                       
                                    <div class="single-product-gallary-slider-thumbnail">
                                        <div class="row row-cols-<?=$image_num?>">
                                            <?php if(!empty($gallary_ids)):?>
                                                
                                                <?php foreach($gallary_ids as $key => $gallary_id): ?>
                                                    <div class="col">
                                                        <div class="single-product-gallary-slider-image-thumnail" id=<?=$key?>>
                                                            <img src="<?=wp_get_attachment_url($gallary_id)?>" alt="single-product-gallary-slider-image-thumbnail">
                                                        </div>
                                                    </div>
                                                <?php endforeach; ?>
                                              
                                            <?php endif; ?> 
                                        </div>
                                    </div>
                                    <div class="single-product-gallary-slider-full-size-image">
                                        <p><i class="fa-solid fa-maximize"></i></p>
                                    </div>
                                </div>

                                <div class="single-product-detail-info col-md-6 col-12 ps-5">

                                    <?php if(!empty($variation_product)): ?>

                                        <h3><?php echo $variation_product->get_name()?></h3>
                                        <?php
                                            $brand = get_post_meta($product->get_id(),"Brand", true );
                                            $model = get_post_meta($product->get_id(),"model_number", true );
                                        ?>

                                        <?php if(!empty($brand)): ?>
                                            <h5><span class="badge bg-success">Brand</span> <?=$brand?></h5>
                                        <?php endif;  ?>
                                        <?php if(!empty($model)): ?>
                                            <h5><span class="badge bg-success">Model No.</span> <?=$model?></h5>
                                        <?php endif;  ?>

                                        <div class="single-product-price my-4">
                                            <h5><?php echo $variation_product->get_price_html() ?></h5>
                                        </div>

                                        <?php if(!empty($variation_product->get_description())): ?>
                                            <div class="single-product-short-description">
                                                <p><?php echo $variation_product->get_description()?></p>
                                            </div>
                                        <?php else:  ?>
                                            <div class="single-product-short-description">
                                                <p><?php echo $product->get_short_description()?></p>
                                            </div>
                                        <?php endif;  ?>

                                        <div class="variations">
                                            <h5 class="mb-3">Product Variations: </h5>
                                            <div class="ps-3">
                                                <?php $variations = $variation_product->get_attributes(); ?>
                                                <?php foreach($variations as $key => $value): 
                                                    $name = str_replace("pa_", "", $key);
                                                    $name = str_replace("-", " ", $name );

                                                    if(strpos($value, "-")){
                                                        $value = str_replace("-", " ", $value);
                                                    }
                                                ?>
                                                    <p class="variation"><span>- </span><?=ucfirst($name)?>: <?=ucfirst($value)?></p>  

                                                <?php endforeach; ?>
                                            </div>
                                        </div>
                    
                                        <div class="single-product-add-to-cart">
                                            <form action="javascript:void(0)" id="add_to_cart">
                                                <?php echo wp_nonce_field('add_single_product_action', 'add_single_product_nonce') ?>
                                                <input type="number" class="product-quantity" name="product-quantity" step="1" min="1" placeholder="1">

                                                <input type="hidden" class="product-id" name="product-id" value="<?php echo $product->get_id(); ?>">
                                                <input type="hidden" class="variation-id" name="variation-id" value="<?php echo $variation_id; ?>">

                                                <button type="submit" class="btn-add-to-cart">Add to Cart</button>
                                                <button class="btn btn-add-to-cart loading" disabled style="display: none;">
                                                    <span class="spinner-border spinner-border-sm"></span>
                                                    Loading..
                                                </button>
                                            
                                            </form>
                                        </div>
                                    <?php else: ?> 

                                        <h3><?php echo $product->get_name()?></h3>

                                        <?php
                                            $brand = get_post_meta($product->get_id(),"Brand", true );
                                            $model = get_post_meta($product->get_id(),"model_number", true );
                                        ?>
                                        <?php if(!empty($brand)): ?>
                                            <h5><span class="badge bg-success">Brand</span> <?=$brand?></h5>
                                        <?php endif;  ?>
                                        <?php if(!empty($model)): ?>
                                            <h5><span class="badge bg-success">Model No.</span> <?=$model?></h5>
                                        <?php endif;  ?>

                                        <div class="single-product-price my-4">
                                            <h5><?php echo $product->get_price_html() ?></h5>
                                        </div>
                                        <div class="single-product-short-description">
                                            <p><?php echo $product->get_short_description()?></p>
                                        </div>

                                        <?php if(!empty($variation_names)):?>
                                            <div class="variations-single">

                                                <?php
                                                    global $wp;
                                                    $current_url = home_url(add_query_arg(array(), $wp->request))
                                                ?>
                                                <input type="hidden" class="single_page_url" value="<?=$current_url?>">
                                                <?php wp_nonce_field('add_single_page_nonce_action', 'add_single_page_nonce_name');?>

                                                <?php if(!empty($filter_values)): ?>    
                                                    <div class="single_selected_data" style="display: none;">
                                                        <?php foreach($filter_values as $key => $value): ?>
                                                            <input class="single_select_filter_var" type="text" data-selected-key="<?=$key?>" value="<?=$value?>">
                                                        <?php endforeach; ?>
                                                    </div>
                                                <?php endif; ?> 

                                                <div class="variable-alert alert alert-warning" role="alert" style="display: none;">
                                                </div>    
                                                <div class="row row-cols-1 row-cols-md-3">
                                                            
                                                    <?php foreach($variation_names as $variation_name):?>
                                                        
                                                        <?php
                                                                if(strpos($variation_name, "-")){
                                                                    $variation_name_ = str_replace("-", " ",  $variation_name);
                                                                    $variation_name_ = ucfirst( $variation_name_);
                                                                }else{
                                                                    $variation_name_ = $variation_name;
                                                                }
                                                        ?>
                                                        <div class="col">
                                                            <div class="variations-single-item">
                                                                <label for="<?=$variation_name?>"><h5><?php echo $variation_name_;?></h5></label>
                                                                <select class="variation" name="<?=$variation_name?>" id="<?=$variation_name?>">
                                                                    <option value="" selected data-variation = "<?=$variation_name?>">>Select a Option!</option>
                                                                    <?php foreach($variation_values[$variation_name] as $variation_value):?>
                                                                            <option value="<?=$variation_value?>" data-variation = "<?=$variation_name?>"><?=$variation_value?></option> 
                                                                    <?php endforeach;?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    <?php endforeach; ?>
                                                </div>
                                            </div>
                                        <?php endif; ?> 

                                        <?php if(!empty($variation_names)):?>
                                            <?php if(!empty($filter_values)): ?>    
                                                <?php if(!empty($variation_id)): ?>  
                                                        <?php
                                                            $variation_product = wc_get_product($variation_id);
                                                            $variation_price = $variation_product->get_price_html()
                                                        ?>
                                                        <div class="single-product-variation-price mb-0"><h5>Selected Product Price:</h5> <?=$variation_price?></div>
                                                <?php endif; ?> 
                                            <?php endif; ?> 
                                        <?php endif; ?> 

                                        <div class="single-product-add-to-cart">

                                            <form action="javascript:void(0)" id="add_to_cart">
                                                <?php echo wp_nonce_field('add_single_product_action', 'add_single_product_nonce') ?>
                                                <input type="number" class="product-quantity" name="product-quantity" step="1" min="1" placeholder="1">

                                                <?php if(!empty($variation_names)):?>
                                                    <?php if(!empty($filter_values)): ?>    
                                                        <?php if(!empty( $variation_id)): ?>  
                                                            <input type="hidden" class="variation-id" name="variation-id" value="<?php echo $variation_id; ?>">
                                                        <?php endif; ?> 
                                                    <?php endif; ?> 
                                                <?php endif; ?> 

                                                <input type="hidden" class="product-id" name="product-id" value="<?php echo $product->get_id(); ?>">

                                                <?php if(!empty($variation_names)):?>
                                                    <?php if(!empty($filter_values)): ?>    
                                                        <?php if(!empty( $variation_id)): ?>  

                                                            <button type="submit" class="btn-add-to-cart">Add to Cart</button>

                                                        <?php endif; ?> 
                                                    <?php else: ?>   
                                                        <button type="submit" class="btn-add-to-cart" disabled style="background-color: grey;">Add to Cart</button>
                                                    <?php endif; ?>
                                                
                                                <?php else: ?>   
                                                    <button type="submit" class="btn-add-to-cart">Add to Cart</button>
                                                <?php endif; ?>

                                                <button class="btn btn-add-to-cart loading" disabled style="display: none;">
                                                    <span class="spinner-border spinner-border-sm"></span>
                                                    Loading..
                                                </button>
                                            
                                            </form>
                                        </div>

                                    <?php endif; ?> 

                                    <div class="single-product-tax-field">
                                        <div class="tax-field"><p>SKU: <span><?php echo $product->get_sku(); ?></span></p></div>
                                    
                                        <div class="tax-field"><p>Categories: <?=$cat_str_?></p>
                                        </div>
                                        <div class="tax-field"><p>Tags: <?= $tag_str_?></p></div>            
                                    </div>
                                </div>
                            </div>
                            <div class="single-product-full-screen-image">
                                <div class="header">
                                    <?php if(!empty($gallary_ids)):?>
                                        <div class="single-product-full-screen-header-number"></div>
                                       
                                    <?php else:?> 
                                        <h5>1/1</h5>
                                    <?php endif;?>   
                                     <p class="close-full-image"><i class="fa-solid fa-xmark"></i></p>               
                                </div>
                                <div class="image-content">
                                    <div class="single-product-image-content-chervon chervon-left"><span><i class="fa-solid fa-chevron-left"></i></span></div> 
                                    <div class="single-product-image-content-chervon chervon-right"><span><i class="fa-solid fa-chevron-right"></i></span></div>
                                    <div class="image-screen">
                                        <?php if(!empty($gallary_ids)):?>

                                            <div class="single-product-image-content-gallary-slider-move">
                                                <?php foreach($gallary_ids as $key => $gallary_id): ?>
                                                    <div class="single-product-image-content-gallary-slider-image-slide" data-id=<?=$key?>>
                                                        <img src="<?=wp_get_attachment_url($gallary_id)?>" alt="single-product-gallary-slider-image">
                                                    </div>
                                                <?php endforeach; ?>
                                            </div>

                                        <?php else:?> 

                                            <div class="single-product-image-content-gallary-slider-image">
                                                <img src="<?=wp_get_attachment_url($single_img_id)?>" alt="single-product-gallary-slider-image">
                                            </div>

                                        <?php endif;?>       
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="single-product-tabs single-product-item">
                        
                               <a href="javscript:void(0)">
                                    <?php wc_get_template("single-product/tabs/tabs.php") ?>    
                               </a>             
                           
                        </div>
                        <div class="single-product-related single-product-item">
                            <div class="section_title mb-5">
                                <h3>Related Product</h3>
                            </div>
                            <div class="row row-cols-1 row-cols-md-4 g-5">

                                <?php
                                    $related_products_ids = wc_get_related_products($product->get_id(), 4);
                                    
                                                    
                                ?>
                                <?php if(!empty($related_products_ids)): ?>

                                    <?php foreach($related_products_ids as $product_id):?>

                                        <?php get_template_part( "templates/archive-page/product", null, ["id" => $product_id] )?>

                                    <?php endforeach; ?>  

                                <?php endif; ?>

                                
                            </div>
                        </div>
                    <?php endforeach; ?>   
                <?php endif; ?>

           </div>
        </section>

<?php endif; ?>

<?php get_footer(); ?>







<script>
    jQuery(document).ready(function($){

      

        let number_image = $(".single-product-gallary-slider-image").length;
        let total = 0;

        getMouseOut();
        initGallary();
        initThumbnail();

        $(".single-product-gallary-slider-screen").on("mousemove", function(e){

            e.preventDefault();

            let imageX = $(".single-product-gallary-slider-screen").offset().left;
            let imageY = $(".single-product-gallary-slider-screen").offset().top;

            let X = e.pageX - imageX;
            let Y = e.pageY - imageY;

            $(".single-product-gallary-slider-image.active").css({
                "transform-origin": `${X}px ${Y}px`,
                "transform": `scale(2)`
            })
            
        });

      

        function getMouseOut(){
            $(".single-product-gallary-slider-screen").on("mouseleave", function(e){

                $(".single-product-gallary-slider-image.active").css({
                    "transform": `scale(1)`,
                    "transform-origin": `center`
                 })

            });
        }

        function initGallary(){

            let image_W =   $(".single-product-gallary-slider-move").find(".single-product-gallary-slider-image").width();

            $(".single-product-gallary-slider-move").find(".single-product-gallary-slider-image").each(function(index, el){

                if(index == 0){
                    $(this).addClass("active");
                }
                
            });
 
            if($(".single-product-gallary-slider-image").length == 1){
                $(".single-product-chervon").hide();
               
            }

            if(total >= (number_image)){
                $(".single-product-chervon.chervon-left").hide();
            }

            if(total < 1){
                $(".single-product-chervon.chervon-right").hide();
            }


        }

        $(".single-product-chervon.chervon-left").on("click", function(e){
            e.preventDefault();

            if($(".single-product-gallary-slider-image.active").next().length){
                $(".single-product-gallary-slider-image.active").removeClass('active').next().addClass("active");
            }
          
            let image_W =   $(".single-product-gallary-slider-move").find(".single-product-gallary-slider-image").width();

            
            if(total >= (number_image - 1)){
                $(".single-product-chervon.chervon-left").hide();
                $(".single-product-gallary-slider-move").css({"left": `-${(number_image - 1) * image_W}px`});
                total =  number_image - 1;
                return total;
            }else{
                total++;
                $(".single-product-chervon.chervon-right").show();
                $(".single-product-gallary-slider-move").animate({
                    "left": `-=${image_W}px`
                },500);
            }

            initThumbnail();
        });

        $(".single-product-chervon.chervon-right").on("click", function(e){
            e.preventDefault();

            if($(".single-product-gallary-slider-image.active").prev().length){
                $(".single-product-gallary-slider-image.active").removeClass('active').prev().addClass("active");
            }
           
            let image_W =   $(".single-product-gallary-slider-move").find(".single-product-gallary-slider-image").width();
            if(total < 1 ){
                $(".single-product-gallary-slider-move").css({"left": `0`});
                $(".single-product-chervon.chervon-right").hide();
                return total;
            }else{
                total--;
                $(".single-product-chervon.chervon-left").show();
               
                $(".single-product-gallary-slider-move").animate({
                    "left": `+=${image_W}px`
                },500);
            }

            initThumbnail();

        });

        $(".single-product-gallary-slider-image-thumnail").on("click", function(e){
            e.preventDefault();
            
            let image_W =   $(".single-product-gallary-slider-move").find(".single-product-gallary-slider-image").width();
            let current_id = $(this).attr("id");

            $(".single-product-gallary-slider-image").each(function(){
                    if($(this).data("id") == current_id){
                        $(this).addClass("active");
                    }else{
                        $(this).removeClass("active");
                    }
            });
           
            let move_dis = - (parseInt(current_id)) * image_W;

            $(this).addClass("active");
            $(this).parent().siblings().find(".single-product-gallary-slider-image-thumnail").removeClass("active");

            $(".single-product-gallary-slider-move").animate({"left": `${move_dis}px`}, 500);

            console.log(number_image - 1);

            if(current_id == number_image - 1){
                $(".single-product-chervon.chervon-right").show();
                $(".single-product-chervon.chervon-left").hide();
            }

            if(current_id == 0){
                $(".single-product-chervon.chervon-right").hide();
                $(".single-product-chervon.chervon-left").show();
            }

            total = current_id;
            return total;
        });


        function initThumbnail(){

            $current_image_id = $(".single-product-gallary-slider-image.active").data("id");

            $(".single-product-gallary-slider-image-thumnail").each(function(){
                if($(this).attr("id") == $current_image_id){
                    $(this).addClass("active");
                }else{
                    $(this).removeClass("active");
                }
            });
            
        }



    });

</script>
