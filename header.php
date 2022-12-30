<!DOCTYPE html>
<html <?php echo language_attributes()?>>
<head>
    <meta charset=<?=bloginfo("charset")?>>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?=bloginfo('title')?></title>
    <?php wp_head();?>
</head>
<body <?php body_class();?> >
        <?php wp_body_open(); ?>

    <header>
         
            <?php
                $head_message = get_theme_mod("header_top_message_setting_id", "");

                $head_bg_color = get_option("header_top_message_bg_color_setting_id");

                $head_color = get_option("header_top_message_color_setting_id");
            ?>

            <?php if($head_message != ""): ?>
                <section class="header_message" style="background-color: <?=$head_bg_color?>;">
                        <p class="pt-3" style="color: <?=$head_color?>;"><?=$head_message?></p>  
                </section> 
            <?php endif; ?>

          <section class="header_nav_bar">
            <nav class="navbar navbar-expand-lg navbar-light bg-light px-5">
                <div class="container-fluid">
               
                    <?php if(has_custom_logo()): ?>
                        <?php 
                            $logo_id = get_theme_mod('custom_logo');
                            $logo_url = wp_get_attachment_url($logo_id);
                        ?>
                        <a class="navbar-brand order-0" href="<?=home_url()?>"><img src="<?=esc_url($logo_url)?>" class="d-block w-100" alt="<?=get_bloginfo('name')?>"></a>
                    <?php else: ?>
                        <a class="navbar-brand order-0" href="<?=home_url()?>"><?=get_bloginfo('name')?></a>
                    <?php endif; ?>

                    
                    <button class="navbar-toggler order-2" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse order-3 order-lg-2 mt-3 mt-lg-0" id="navbarSupportedContent">
                        <!-- <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                            <li class="nav-item">
                                <a class="nav-link active" aria-current="page" href="#">Home</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#">Link</a>
                            </li>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    Dropdown
                                </a>
                                <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                    <li><a class="dropdown-item" href="#">Action</a></li>
                                    <li><a class="dropdown-item" href="#">Another action</a></li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li><a class="dropdown-item" href="#">Something else here</a></li>
                                </ul>
                            </li>
                        </ul> -->
                        <?php
                            
                            $nav_args = array(
                                'theme_location'  => 'main_menu',
                                'container'       => "",
                                'menu_class'      => "navbar-nav ms-auto mb-2 mb-lg-0",
                                'menu_id'         => "",
                                'walker'          => new Main_Nav_Menu(),  
                            );

                           
                            wp_nav_menu($nav_args);
                            
                        ?>
                    
                    </div>
                    <div class="search-icon order-1 order-lg-3 flex-grow-1 flex-lg-grow-0 justify-content-between">

                        <?php if(is_front_page() || is_archive()): ?>
                    
                            <div class="search_item">
                                <p><i class="fa-solid fa-magnifying-glass"></i></p>
                            </div>

                        <?php endif; ?>    
                        
                        <?php if(class_exists("WooCommerce")): ?>
                            <div class="woo_item pe-3 pe-lg-0">
                                <?php if(is_user_logged_in()): ?>

                                    <?php
                                       $current_user = wp_get_current_user();     
                                    ?>

                                    <div class="login-user-name">
                                            <p>Welcome <?=ucfirst(esc_html( $current_user->display_name ))?></p>
                                    </div>

                                    <a href="<?php echo wp_logout_url(get_permalink(get_option("woocommerce_myaccount_page_id"))) ?>"> 
                                        <div class="log-in">
                                            <p>Logout</p>
                                        </div>
                                    </a>
                                    
                                     
                                <?php else: ?>
                                    <a href="<?php echo get_permalink(get_option("woocommerce_myaccount_page_id")); ?>">
                                        <div class="log-in">
                                            <p><i class="fa-solid fa-user"></i></p>
                                        </div>
                                    </a>

                                    <a href="<?=wc_get_cart_url()?>">
                                        <div class="cart_item position-relative">
                                            <p><i class="fa-solid fa-cart-shopping"></i></p>
                                            <?php if(WC()->cart->get_cart_contents_count() > 0): ?>
                                                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                                    <?php echo WC()->cart->get_cart_contents_count() ?>
                                                </span>
                                            <?php endif; ?>
                                        </div>
                                    </a>
                                <?php endif; ?>
                            </div>   
                        <?php endif; ?>
                    </div>
                </div>
              
            </nav>
            <div class="search-form" style="display: none;">
                <?php
                    get_search_form();
                ?>
            </div>
          </section> 
    </header>

    <main>
        <?php if(is_front_page()): ?>

            <?php

                // <-============== Slider 1 ==============->
                $image_1 = get_theme_mod("header_slider_1_image_setting_id", "");   
                $image_1_title = get_theme_mod("header_slider_1_title_setting_id", "");
                $image_1_sub_title = get_theme_mod("header_slider_1_sub_title_setting_id", "");

                // <-============== Slider 2 ==============->
                 $image_2 = get_theme_mod("header_slider_2_image_setting_id", "");   
                 $image_2_title = get_theme_mod("header_slider_2_title_setting_id", "");
                 $image_2_sub_title = get_theme_mod("header_slider_2_sub_title_setting_id", "");

                // <-============== Slider 3 ==============->
                $image_3 = get_theme_mod("header_slider_3_image_setting_id", "");   
                $image_3_title = get_theme_mod("header_slider_3_title_setting_id", "");
                $image_3_sub_title = get_theme_mod("header_slider_3_sub_title_setting_id", "");

                // <-============== slider Text color ==============->

                $text_color = get_option("header_slider_text_color_setting_id","#fff");

               
            ?>
            <section class="slider_section">
                
                    <div id="carouselExampleCaptions" class="carousel slide" data-bs-ride="carousel">
                        <div class="carousel-indicators">
                            <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                            <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="1" aria-label="Slide 2"></button>
                            <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="2" aria-label="Slide 3"></button>
                        </div>
                        <div class="carousel-inner">
                            <div class="carousel-item active">
                                <?php if(!empty($image_1)): ?>
                                    <img src="<?=wp_get_attachment_url($image_1)?>" class="d-block w-100" alt="...">
                                <?php endif; ?>
                                <div class="carousel-caption d-none d-md-block">
                                    <?php if(!empty($image_1_title )): ?>
                                        <h5 style="color: <?=$text_color?>"><?=$image_1_title?></h5>
                                    <?php endif; ?>
                                    <?php if(!empty($image_1_title )): ?>
                                        <p style="color: <?=$text_color?>"><?=$image_1_sub_title?></p>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="carousel-item">
                                <?php if(!empty($image_2)): ?>
                                    <img src="<?=wp_get_attachment_url($image_2)?>" class="d-block w-100" alt="...">
                                <?php endif; ?>
                                <div class="carousel-caption d-none d-md-block">
                                    <?php if(!empty($image_2_title )): ?>
                                        <h5 style="color: <?=$text_color?>"><?=$image_2_title?></h5>
                                    <?php endif; ?>
                                    <?php if(!empty($image_2_title )): ?>
                                        <p style="color: <?=$text_color?>"><?=$image_2_sub_title?></p>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="carousel-item">
                                <?php if(!empty($image_3)): ?>
                                    <img src="<?=wp_get_attachment_url($image_3)?>" class="d-block w-100" alt="...">
                                <?php endif; ?>
                                <div class="carousel-caption d-none d-md-block">
                                    <?php if(!empty($image_3_title )): ?>
                                        <h5 style="color: <?=$text_color?>"><?=$image_3_title?></h5>
                                    <?php endif; ?>
                                    <?php if(!empty($image_3_title )): ?>
                                        <p style="color: <?=$text_color?>"><?=$image_3_sub_title?></p>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Previous</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Next</span>
                        </button>
                    </div>  
               
            </section>
        <?php endif; ?>

        <?php if(class_exists( 'woocommerce' )): ?>

                <?php if(is_shop()): ?>

                    <?php
                        $page = get_page_by_title( 'Shop' );
                    ?>
                    <section class="header_section">
                        <div class="shop_header_image">
                            <?php if(has_post_thumbnail($page->ID)): ?>
                                <?=get_the_post_thumbnail( $page->ID, 'full' );?>
                            <?php endif; ?>
                        </div>
                    </section>
                <?php endif; ?>

        <?php endif; ?>
       

        <?php if(is_post_type_archive("news")): ?>

            <?php
                $news = get_page_by_title( 'News' );
            ?>
            <section class="header_section">
                <div class="news_header_image">
                    <?php if(has_post_thumbnail($news->ID)): ?>
                        <?=get_the_post_thumbnail( $news->ID, 'full' );?>
                    <?php endif; ?>
                </div>
            </section>

        <?php endif; ?>


<style>
    .login-user-name{
        margin-left: 1rem;
    }
</style>