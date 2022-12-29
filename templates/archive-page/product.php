<!-- Single Product Template -->

<?php

$product = wc_get_product( $args['id'] );

    $newness_day = 10;
    $created_day = strtotime($product->get_date_created()); 
    $newProduct = (time() - (60 * 60 * 24 * $newness_day) < $created_day) ? true: false;

    $is_product_on_sale = $product->is_on_sale();

?>

<?php 

    if($product->get_type() == "variation"){
        
        $variations = $product->get_attributes();
        
    }

?>

<div class="shop_single_product_item col position-relative">
    <?php if($newProduct): ?>
        <span class="position-absolute badge rounded-pill bg-danger new_product_sign">
            NEW
        </span>
    <?php endif; ?> 
    <?php if($is_product_on_sale): ?>
        <span class="position-absolute badge rounded-pill bg-success new_product_sign">
            Sale!
        </span>
    <?php endif; ?>
    <div class="card h-100">
        <a href="<?=get_permalink( $product->get_id() )?>">
            <div class="image_box">
                <img src="<?=wp_get_attachment_url($product->get_image_id())?>" class="card-img-top" alt="product_img">
                
            </div>
        </a>
        <div class="card-body">
            <p class="category"><?=$product->get_categories()?></p>
            <h5 class="card-title"><?=$product->get_name()?></h5>
            <p><?php echo $product->get_price_html()?></p>

            <?php if(!empty($variations)): ?>
                    <?php foreach($variations as $key => $value): 
                        $name = str_replace("pa_", "", $key);
                        $name = str_replace("-", " ", $name );

                        if(strpos($value, "-")){
                            $value = str_replace("-", " ", $value);
                        }
                    ?>
                      <p class="variation"><?=ucfirst($name)?>: <?=ucfirst($value)?></p>  

                    <?php endforeach; ?>
            <?php endif; ?>

            <?php if($product->get_average_rating()): ?>
                    <div class="star-rating">
                        <?php
                            $star_num = (int)$product->get_average_rating();
                        ?>
                        <?php for($i = 0; $i < $star_num; $i++){
                            ?>
                                <span><i class="fa-solid fa-star"></i></span>
                            <?php
                        }?>
                    </div>
            <?php endif; ?>
        </div>
    </div>
</div>

