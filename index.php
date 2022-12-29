<?php get_header(); ?>


<?php 

        $query = new WC_Product_Query( array(
           "post_type" => 'product',
           "limit"     => -1,
            'orderby' => 'date',
            'order' => 'DESC',
        ) );
        $products = $query->get_products();  
        
        // echo "<pre>";
        //     print_r( $products);    
        // echo "</pre>";

?>

        <section class="index_section">
            <div class="container">
                <div class="best_seller_product row row-cols-1 row-cols-md-4 g-4">
                    
                    <?php if($products): ?>
                        <?php foreach($products as $product):?>
                        
                            <div class="best_seller_item col">
                                <div class="card h-100">
                                    <a href="<?=get_permalink( $product->get_id() )?>">
                                        <div class="image_box">
                                            <img src="<?=wp_get_attachment_url($product->get_image_id())?>" class="card-img-top" alt="product_img">
                                        </div>
                                    </a>
                                    <div class="card-body">
                                        <p class="category"><?=$product->get_categories()?></p>
                                        <h5 class="card-title"><?=$product->get_name()?></h5>
                                        <p class="card-text">$<?=$product->get_price()?></p>
                                        <?php if($product->get_average_rating()): ?>
                                            <div class="star-rating">
                                                <?=$product->get_average_rating();?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>

                        <?php endforeach; ?>   
                    <?php else: ?> 
                         <h1>There're no Result</h1>   
                    <?php endif; ?>

                </div>    
            </div>
        </section>
        
<?php get_footer(); ?>

