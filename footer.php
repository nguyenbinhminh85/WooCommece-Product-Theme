</main>
<footer>

<!-- <-==========================To Top Button===================-> -->
<div class="to_the_top" style="display: none;">
    <p><i class="fa-solid fa-chevron-up"></i></p>
</div>


<!-- Footer Start -->
    <div class="container-fluid footer">
        <div class="container py-5">
            <div class="row g-5">

           <!--  Footer 1 -->
                <div class="col-md-4 col-sm-6">
                        <?php
                            $id = get_theme_mod('footer_1_company_logo_setting_id', 0);
                            if($id != 0){
                                $logo_src = wp_get_attachment_url($id) ? esc_url(wp_get_attachment_url($id)):"";
                            }
                            
                            $greeting = get_theme_mod('footer_1_greeting_text_setting_id', '');

                        ?>

                        <?php if(!empty($logo_src)): ?>
                            <div class="company-logo">
                                <img src="<?php echo $logo_src ?>" alt="footer-logo" class="img-fluid">
                            </div>
                        <?php endif; ?>

                        <div class="contact_icon">   
                            <?php if(!empty($greeting)): ?>
                                <div class="greeting">
                                    <h5><?=$greeting?></h5>
                                </div>
                            <?php endif; ?>

                            <?php
                                
                                $social_icons = get_theme_mod('footer_1_social_media_setting_id') ;

                                if(is_serialized( $social_icons )) 
                                { 
                                    $social_icons = maybe_unserialize($social_icons); 
                                }
                                    
                            ?>
                            <div class="social-media">
                                <?php if(is_array($social_icons)):?>
                                    <?php foreach($social_icons as $social_icon): ?>
                                        <div class="social-icon">
                                            <a style="color: <?=$social_icon['icon_color']?>" href="<?php echo $social_icon['icon_url'] ?>" target="_blank"><i class="<?php echo $social_icon['icon']?>"></i></a>  
                                        </div>
                                    <?php endforeach; ?>    
                                <?php endif; ?>
                            </div>
                        </div> 
                    
                </div>

            <!--  Footer 2 -->
                <div class="col-md-3 col-sm-6">

                <?php
                            
                    $title = get_theme_mod('footer_2_title_setting_id', '');
                    
                    $company_infos = get_theme_mod('footer_2_contact_info_setting_id','');
                    if(is_serialized( $company_infos )) 
                    { 
                        $company_infos = maybe_unserialize($company_infos); 
                    }
                    // echo "<pre>";
                    //     print_r($company_infos);
                    // echo "</pre>";
                        
                ?>
                    <div class="company-address-title">
                        <h5><?php echo $title ?></h5>
                    </div>

                    <?php foreach($company_infos as $key =>$company_info):?>
                        
                            <div class="company-info">
                                <h5><?php echo $company_info[0]['title'] ?></h5>
                                <div class="info address">
                                    <span><i class="<?=$company_info[1]['addressIcon']?>"></i></span>
                                    <p><?php echo $company_info[1]['addressInfo'] ?></p> 
                                </div>
                                <div class="info phone">
                                    <span><i class="<?=$company_info[2]['phoneIcon']?>"></i></span>
                                    <p><?php echo $company_info[2]['phoneInfo'] ?></p>
                                </div>
                                <div class="info email">
                                    <span><i class="<?=$company_info[3]['emailIcon']?>"></i></span>
                                     <p><?php echo $company_info[3]['emailInfo'] ?></p> 
                                </div>
                            </div>
                           
                    <?php endforeach; ?>

                </div>
            <!--  Footer 3 -->

                <div class="col-md-2 col-sm-6">
                    <?php if ( is_active_sidebar( 'footer-1' ) ) : ?>
                        
                        <?php dynamic_sidebar( 'footer-1' ); ?>
                    
                    <?php endif; ?>
                </div>

            <!--  Footer 4 -->
                <div class="col-md-3 col-sm-6 ">
                <?php if ( is_active_sidebar( 'footer-2' ) ) : ?>
                        
                        <?php dynamic_sidebar( 'footer-2' ); ?>

                        <!-- <div class="find_shop">
                            <a href="http://localhost/worpress/wordpress/contact/">
                                <h5>FIND STORE</h5><span><i class="fa-solid fa-arrow-right"></i></span>
                            </a>
                        </div> -->
                    
                    <?php endif; ?>
                </div>
            </div>
        </div>
       
        <div class="container copyright text-center">
            <p class="text">&COPY; All Right Reserved By NBM</p>
        </div>
        
    </div>
<!-- Footer End -->

</footer>

<?php wp_footer();?>
</body>
</html>


<style>

    <?php 
        $bgColor = get_option('footer_backgroundColor_setting_id');
        $textColor = get_option('footer_text_color_setting_id');
    ?>
    
    .footer{
        background-color: <?php echo $bgColor?>;
    }

    .contact_icon{
        display: flex;
        flex-direction: row;
        flex-wrap: wrap;
        justify-content: space-between;
        align-items: center;
        margin-top: 4rem;
    }

    .footer .social-media{
        display: flex;
        flex-direction: row;
        justify-content: center;
        align-items: center;
    }

    .footer h5, .footer p{
        color: <?php echo $textColor?>;
    }


    
    .social-media .social-icon{
       margin-right: 5px;
       width: 50px;
       height: 50px;
       border-radius: 3px;
       text-align: center;
       line-height: 50px;
       cursor: pointer;
       transition: all 0.3s;
    }

 
    .social-media .social-icon:hover{
      transform: translateY(-5px) scale(1.05);
    }

    .social-media .social-icon a{
       text-decoration: none;
       font-size: 30px;
    }

    .social-media .social-icon:hover a{
       opacity: 0.8;
    }

    .company-logo{
        max-width: 100%;
        height: auto;
    }

    .company-logo img{
        width: 100%;
        object-fit: contain;
    }

    .company-info{
        background-color:rgba(255, 255, 255, 0.1);
        padding: 5px 0 0 5px;
        margin-bottom: 10px;
    }

    .company-info h5{
        text-decoration: underline;
    }


    .company-info .info{
        display: flex;
        flex-direction: row;
        flex-wrap: wrap;
        margin-bottom: 0px;
    }

    .company-info .info span{
       margin-right: 10px;
       color:rgba(0, 0, 0, 0.6);
    }

    li{
        list-style: none;
    }



    .copyright p{
        margin-bottom: 0;
        padding: 0.25rem;
        border-top: thin solid #17171711;
    }

    ul.menu{
        display: flex;
        flex-direction: column;
    }
</style>