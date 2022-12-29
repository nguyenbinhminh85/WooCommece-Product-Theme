<?php

include_once get_template_directory()."/classes/nav_walker_class.php";

include_once  get_template_directory()."/includes/collection-customize/collection-customize.php";

include_once  get_template_directory()."/includes/authorized-distributor/authorized-customize.php";

include_once  get_template_directory()."/includes/service-provide/service-customize.php";

include_once  get_template_directory()."/includes/section-title/section-title.php";

include_once  get_template_directory()."/includes/social-media-icon/social-media-icon.php";

include_once  get_template_directory()."/includes/company-address/company-address-customize.php";

include_once  get_template_directory()."/includes/news/add-news-post-type.php";

include_once  get_template_directory()."/includes/head-slider/head-slider.php";


//Contact Form

include_once get_template_directory()."/templates/contact-form.php";

//Add Assets File;
function add_assets_file(){

     //Add Fontawesome-css 
     wp_enqueue_style( 'fontawesome-css', get_template_directory_uri()."/assets/css/all.min.css", array(), "1.0.0", "all" );

    //Add Bootstrap-css 
    wp_enqueue_style( 'bootstrap-css', get_template_directory_uri()."/assets/css/bootstrap.min.css", array(), "1.0.0", "all" );

    //Add Theme-css 
    wp_enqueue_style( 'theme-css', get_template_directory_uri()."/assets/css/theme_css.css?gh=abcef", array(), "1.0.0", "all" );

    //Add Main style Sheet
    wp_enqueue_style( 'style-css', get_stylesheet_uri() );

     //Add Fontawesome-js
     wp_enqueue_script( 'fontawesome-js', get_template_directory_uri() . '/assets/js/all.min.js', array('jquery'), '1.0.0', true );

    //Add Bootstrap-js
    wp_enqueue_script( 'bootstrap-js', get_template_directory_uri() . '/assets/js/bootstrap.min.js?gh=abced', array('jquery'), '1.0.0', true );

    //Add theme-js
    wp_enqueue_script( 'theme-js', get_template_directory_uri() . '/assets/js/theme_js.js?gh=abcefg', array('jquery'), '1.0.0', true );


    wp_localize_script( 'theme-js', 'add_single_product', array(
        'ajaxurl' => admin_url( 'admin-ajax.php' )
    ) );

}

add_action( 'wp_enqueue_scripts', 'add_assets_file' );


//Add Nave Menu

    function mytheme_register_nav_menu(){

        add_theme_support("menus");

        add_theme_support( 'widgets' );

        $defaults = array(
            'height'               => 100,
            'width'                => 300,
            'flex-height'          => true,
            'flex-width'           => true,
            'header-text'          => array( 'site-title', 'site-description' ),
            'unlink-homepage-logo' => false, 
        );
        add_theme_support( 'custom-logo', $defaults );

        register_nav_menus( array(
            'main_menu' => __( 'Main Menu', 'beautiful-tree' ),
            'footer_menu'  => __( 'Footer Menu', 'beautiful-tree' ),
        ) );

        add_theme_support( 'woocommerce' );


    }

add_action('after_setup_theme','mytheme_register_nav_menu');    


add_action( 'wp_ajax_product_cart', 'add_product_to_cart' );
add_action( 'wp_ajax_nopriv_product_cart', 'add_product_to_cart' );
remove_action( 'wp_loaded', array( 'WC_Form_Handler', 'product_cart' ), 20 );

function add_product_to_cart(){

    if(!isset($_POST['product_nonce']) || !wp_verify_nonce($_POST['product_nonce'], "add_single_product_action")){
            $data = [
                "nonce_error"   => true,
                "message"       => "Something_wrong!"
            ];

            echo wp_send_json($data);
            return false;
    }

    $product_id = absint($_POST['product_id']);
    $quantity   = absint(empty($_POST['product_quantity'])? 1:$_POST['product_quantity']);

    $variation_id = absint(empty($_POST['product_quantity'])? "":$_POST['product_variation_id']);

    
    $passed_validation = apply_filters('woocommerce_add_to_cart_validation', true, $product_id, $quantity);
    $product_status = get_post_status($product_id);

    if(!empty($variation_id))
    {
        if('publish' === $product_status && $passed_validation && WC()->cart->add_to_cart($product_id, $quantity,$variation_id)){

            do_action('woocommerce_ajax_added_to_cart', $product_id);
            if ('yes' === get_option('woocommerce_cart_redirect_after_add')) {
                wc_add_to_cart_message(array($product_id => $quantity), true);
            }
            
            WC_AJAX :: get_refreshed_fragments(); 
            
        }else {

            WC_AJAX :: get_refreshed_fragments(); 
        }

    }else{
        if('publish' === $product_status && $passed_validation && WC()->cart->add_to_cart($product_id, $quantity)){

            do_action('woocommerce_ajax_added_to_cart', $product_id);
            if ('yes' === get_option('woocommerce_cart_redirect_after_add')) {
                wc_add_to_cart_message(array($product_id => $quantity), true);
            }
            
            WC_AJAX :: get_refreshed_fragments(); 
            
        }else {

            WC_AJAX :: get_refreshed_fragments(); 
        }
    }

    wp_die();


}

add_filter( 'woocommerce_add_to_cart_fragments', 'misha_add_to_cart_fragment' );

function misha_add_to_cart_fragment( $fragments ) {
    
    $fragments[ '.misha-cart' ] = '<a href="'.wc_get_cart_url().'">';

    $fragments[ '.misha-cart' ] .= '<div class="cart_item position-relative">
    <p><i class="fa-solid fa-cart-shopping"></i></p>';
        
    if(WC()->cart->get_cart_contents_count() > 0){
        $fragments[ '.misha-cart' ] .= '<span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
            '. WC()->cart->get_cart_contents_count() .'</span>';
    }
            
    $fragments[ '.misha-cart' ] .= '</div></a>';

 	return $fragments;

 }

function updateNotices($fragments){

    $all_notices = WC()->session->get('wc_notices', array());
    $notices_types = apply_filters( 'woocommerce_notice_types', array( 'error', 'success', 'notice' ) );

    ob_start();

    foreach($notices_types as $notice_type){
        if(wc_notice_count($notice_type) > 0){
            wc_get_template("notices/{$notice_type}.php", array(
                "notices" => array_filter($all_notices[$notice_type])
            ));
        }
    }

    $fragments["html_notices"] = ob_get_clean();

    wc_clear_notices();

    return $fragments;

}

add_filter( 'woocommerce_add_to_cart_fragments', 'updateNotices' );


/**
 * Remove "Description" Heading Title @ WooCommerce Single Product Tabs
 */
add_filter( 'woocommerce_product_description_heading', '__return_null' );
add_filter( 'woocommerce_product_additional_information_heading', '__return_null' );


add_action( 'woocommerce_before_shop_loop_item_title', 'bbloomer_new_badge_shop_page', 3 );
          
function bbloomer_new_badge_shop_page() {
   global $product;
   $newness_days = 30;
   $created = strtotime( $product->get_date_created() );
   if ( ( time() - ( 60 * 60 * 24 * $newness_days ) ) < $created ) {
      echo '<span class="itsnew onsale">' . esc_html__( 'New!', 'woocommerce' ) . '</span>';
   }
}

    

// function custom_posts_per_page( $query ) {

//     if ( $query->is_archive('product') ) {
//         set_query_var('posts_per_page', -1);
//     }
// }
// add_action( 'pre_get_posts', 'custom_posts_per_page' );


function addNewqueryVar($vars){
    $vars[] = "color";
    $vars[] = "size";

    return $vars;
}

add_filter('query_vars', "addNewqueryVar");


add_action( 'wp_ajax_filter_from_query', 'add_size_query_var' );
add_action( 'wp_ajax_nopriv_filter_from_query', 'add_size_query_var' );

function add_size_query_var(){

    if(!isset($_POST['nonce']) || !wp_verify_nonce($_POST['nonce'], "add_filter_nonce_action")){
        return false;
    }

    $params = [];
    
    if(!empty($_POST['info'])){
        foreach($_POST['info'] as $datas){
            foreach($datas as $key => $data){
                $query_val = "";
                foreach($data as $value){
                    $query_val .= $value .",";
                }
                $query_val = substr_replace($query_val,"", -1);
                $params[$key] = $query_val;
            }
        }
    }

    $url = isset($_POST['url']) ? $_POST['url']:"http://localhost/worpress/wordpress/shop";

    $feedback = [
        "data" => $_POST['info'],
        'url' => add_query_arg($params, $url),
    ];

    wp_send_json($feedback);

}

add_action( 'wp_ajax_filter_from_query_single_page', 'add_filter_from_query_single_page' );
add_action( 'wp_ajax_nopriv_filter_from_query_single_page', 'add_filter_from_query_single_page' );

function add_filter_from_query_single_page(){

    if(!isset($_POST['nonce']) || !wp_verify_nonce($_POST['nonce'], "add_single_page_nonce_action")){
        return false;
    }

    $params = [];
    
    if(!empty($_POST['info'])){
        foreach($_POST['info'] as $datas){
            foreach($datas as $key => $data){
                $query_val = "";
                foreach($data as $value){
                    $query_val .= $value .",";
                }
                $query_val = substr_replace($query_val,"", -1);
                $params[$key] = $query_val;
            }
        }
    }

    $url = isset($_POST['url']) ? $_POST['url']:"http://localhost/worpress/wordpress/shop";

    $feedback = [
        "data" => $_POST['info'],
        'url' => add_query_arg($params, $url),
    ];

    wp_send_json($feedback);

}


// <=========== Register Field Custom Taxonomy ==============>

function add_field_area(){

    $args = array(
        'label'     => "Fields",
        'public'   => true,
        'hierarchical' => true,
        'query_var'         => true,
        'has_archive' => true,
		'rewrite'           => array( 'slug' => 'field-cat' ),
        
    );

    register_taxonomy('field-cat', 'product', $args);
}

add_action( 'init', 'add_field_area', 0 );


// <=========== Setting collection Section For Front Page==============>


add_action( 'wp_ajax_setting_collection_front_page', 'setting_collection_front_page' );
add_action( 'wp_ajax_nopriv_setting_collection_front_page', 'setting_collection_front_page' );

function setting_collection_front_page(){

    if(!isset($_POST['nonce']) || !wp_verify_nonce($_POST['nonce'], "collection_front_page_nonce_action")){
        return false;
    }

    
    if(!is_serialized($_POST['values'])){
        $feedback = maybe_serialize($_POST['values']);
    }

    echo $feedback;

    wp_die();
}


// <=========== Setting Authorized Distributor Section For Front Page==============>


add_action( 'wp_ajax_adding_authorized_on_front_page', 'setting_authorized_front_page' );
add_action( 'wp_ajax_nopriv_adding_authorized_on_front_page', 'setting_authorized_front_page' );

function setting_authorized_front_page(){

    if(!isset($_POST['nonce']) || !wp_verify_nonce($_POST['nonce'], "authorized_front_page_nonce_action")){
        return false;
    }

    
    if(!is_serialized($_POST['values'])){
        $feedback = maybe_serialize($_POST['values']);
    }

    echo $feedback;

    wp_die();
}


// <=========== Setting Service Provide Section For Front Page==============>


add_action( 'wp_ajax_setting_service_provide_front_page', 'setting_service_front_page' );
add_action( 'wp_ajax_nopriv_setting_service_provide_front_page', 'setting_service_front_page' );

function setting_service_front_page(){

    if(!isset($_POST['nonce']) || !wp_verify_nonce($_POST['nonce'], "service_front_page_nonce_action")){
        return false;
    }

    
    if(!is_serialized($_POST['values'])){
        $feedback = maybe_serialize($_POST['values']);
    }

    echo $feedback;

    wp_die();
}


// <=========== Setting News Page==============>


add_action( 'wp_ajax_get_news_info', 'setting_news_page' );
add_action( 'wp_ajax_nopriv_get_news_info', 'setting_news_page' );

function setting_news_page(){

    if(!isset($_POST['nonce']) || !wp_verify_nonce($_POST['nonce'], "news_info_action")){
        return false;
    }
  
    if(!empty($_POST['news_info']) && !empty($_POST['url'])){

       $url =  add_query_arg( array(
            'info' => $_POST['news_info'],
        ), $_POST['url'] );

        $feedback = [
            "url" => esc_url($url),
            "info" => $_POST['news_info']
        ];
        wp_send_json($feedback);
    }

    wp_die();
}


/**
 * Add a sidebar.
 */
function wpdocs_theme_slug_widgets_init() {
	register_sidebar( array(
		'name'          => __( 'Footer-1'),
		'id'            => 'footer-1',
		'description'   => __( 'add widget to footer area 3' ),
		'before_widget' => '<li id="%1$s" class="widget %2$s">',
		'after_widget'  => '</li>',
		'before_title'  => '<h5 class="widgettitle">',
		'after_title'   => '</h5>',
	) );

    register_sidebar( array(
		'name'          => __( 'Footer-2'),
		'id'            => 'footer-2',
		'description'   => __( 'add widget to footer area 4' ),
		'before_widget' => '<li id="%1$s" class="widget %2$s">',
		'after_widget'  => '</li>',
		'before_title'  => '<h5 class="widgettitle">',
		'after_title'   => '</h5>',
	) );
}
add_action( 'widgets_init', 'wpdocs_theme_slug_widgets_init' );



/* <-=================Preset Product Pagination======================-> */

function custom_posts_per_page( $query ) {
    //fixing pagination of custom post type
    if(!is_admin()){
        if ( $query->is_archive('product') ) {
            set_query_var('posts_per_page', 1);
        }
    }
}
add_action( 'pre_get_posts', 'custom_posts_per_page' );

