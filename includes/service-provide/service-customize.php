<?php

add_action( 'customize_register', "register_service_javascript" );

function register_service_javascript(){

    class WP_New_Menu_Service_Customize_Control extends WP_Customize_Control {

        public $type = 'new_menu';
        /**
        * Render the control's content.
        */
        public function render_content() {

            ?>

            <input type="hidden" id="service_front_page_value" value="" <?php echo $this->link(); ?>>
            <?php wp_nonce_field("service_front_page_nonce_action", "service_front_page_nonce_name") ?>

        <?php

             $values = get_theme_mod("front_page_service_setting_id");
             $datas = maybe_unserialize($values);

            //   echo "<pre>";
            //     print_r($datas);    
            // echo "</pre>";

        ?>

        <form action="#" id="service_input_data">

            <div class="service-section-front-page">
                <?php if(empty($datas)): ?>
                    <div class="about-card">
                        <div class="delete-about-card">
                            <div>X</div>
                        </div>        
                        <div class="title-item">
                            <label for="card_icon"> Add Card font awesome class icon: </label>
                            <input type="text" id="card_icon" class="card_info card_icon" value="" placeholder="fa-brands fa-facebook">
                        </div>

                        <div class="title-item">
                            <label for="card_title">Add Card Title:</label>
                            <input type="text" id="card_title" class="card_info card_title" value="" placeholder="Your Card Title">
                        </div>

                        <div class="title-item">
                            <label for="card_content">Add Card Content:</label>
                            <textarea name="card_content" id="card_content" class="card_info card_content" cols="10" placeholder="Your Card Content"></textarea>
                        </div>
                    </div>
                <?php else: ?>
                    <?php if(is_array($datas)): ?>
                        <?php foreach($datas as $data): ?>

                            <div class="about-card" style="display: block;">
                                <div class="delete-about-card">
                                    <div>X</div>
                                </div>        
                                <div class="title-item">
                                    <label for="card_icon"> Add Card font awesome class icon: </label>
                                    <input type="text" id="card_icon" class="card_info card_icon" value="<?=$data['icon']?>" placeholder="fa-brands fa-facebook">
                                </div>

                                <div class="title-item">
                                    <label for="card_title">Add Card Title:</label>
                                    <input type="text" id="card_title" class="card_info card_title" value="<?=$data['title']?>" placeholder="Your Card Title">
                                </div>

                                <div class="title-item">
                                    <label for="card_content">Add Card Content:</label>
                                    <textarea name="card_content" id="card_content" class="card_content card_info" cols="10" placeholder="Your Card Content"><?=$data['content']?></textarea>
                                </div>
                            </div>

                        <?php endforeach; ?>   
                    <?php endif; ?>
                <?php endif; ?>

                    <div class="about-card-standard" style="display: none;">
                        <div class="delete-about-card">
                            <div>X</div>
                        </div>        
                        <div class="title-item">
                            <label for="card_icon"> Add Card font awesome class icon: </label>
                            <input type="text" class="card_info card_icon" value="" placeholder="fa-brands fa-facebook">
                        </div>

                        <div class="title-item">
                            <label for="card_title">Add Card Title:</label>
                            <input type="text" class="card_info card_title" value="" placeholder="Your Card Title">
                        </div>

                        <div class="title-item">
                            <label for="card_content">Add Card Content:</label>
                            <textarea name="card_content" class="card_info card_content" cols="10" placeholder="Your Card Content"></textarea>
                        </div>
                    </div>

            </div>
            <button type="submit" class="save_data_service">Upload Service Provide</button>
        </form>   
            <button class="add_more_service">Add Service Provide</button>

        <?php
   
        }
    }
    
    
}          

class Add_front_page_service_provide{

    public function __construct()
        {
            add_action( 'customize_register', [$this, "my_customize_register"] );

            add_action( 'admin_enqueue_scripts', [$this, 'add_media_script'] );

            add_action( 'customize_controls_enqueue_scripts', [$this, "register_script_file"] );
        }

    public function register_script_file(){

        wp_enqueue_script( 'service-front-page-js', get_template_directory_uri().'/includes/service-provide/service-customize.js?gh=abcdef', array('jquery'), '1.0.0', true );

        wp_enqueue_style( 'service-front-page-css', get_template_directory_uri()."/includes/service-provide/service-customize.css?gh=abcfg", array(), "1.0.0", "all" );

        wp_localize_script( 'service-front-page-js', 'add_service', array(
            'ajaxurl' => admin_url( 'admin-ajax.php' )
        ) );

    }

    public function add_media_script( $hook_suffix ) {

        wp_enqueue_media();

    }


    public function my_customize_register( $wp_customize ){

        $wp_customize->add_panel('front_page_service_panel_id', array(
            'title' => 'Setting Front Page Service Section',
            'description' => 'This field use to setting up the front page - service provide section',
            'priority' => 270
        ));

        $wp_customize->add_section('front_page_service_section_id', array(
            'title' => 'Front Page Service Provide Section',
            'description' => 'Add service provide section information for front page',
            'panel' => 'front_page_service_panel_id'
        ));

        $wp_customize->add_setting('front_page_service_setting_id', array(
            'type' => 'theme_mod',
            'capability' => 'edit_theme_options',
            'default' => '',
            'transport' => 'refresh', // or postMessage
            'sanitize_callback' => 'sanitize_text_field'
        ));

        $wp_customize->add_control(
            new WP_New_Menu_Service_Customize_Control($wp_customize, 'front_page_service_setting_id', array(
                'label' => 'Add Authorized Distributor Info',
                'section' => 'front_page_service_section_id'
            ))
        );

/* <-======================= Service Provider Text area ==========================-> */

        $wp_customize->add_section('front_page_service_text_section_id', array(
            'title' => 'Front Page Service Text',
            'description' => 'Add Text to service provide section front page',
            'panel' => 'front_page_service_panel_id'
        ));

        $wp_customize->add_setting( 'front_page_service_text_setting_id', array(
            'type' => 'theme_mod', // or 'option'
            'capability' => 'edit_theme_options',
            'default' => '',
            'transport' => 'refresh', // or postMessage
            'sanitize_callback' => 'sanitize_text_field',
      
          ) );   
      
          $wp_customize->add_control( 'front_page_service_text_setting_id', array(
            'type' => 'text',
            'priority' => 20,
            'section' => 'front_page_service_text_section_id',
            'label' => __( 'Add Title' ),
            'description' => __( 'Add Text to service provide section front page' ),
          ) );

          $wp_customize->add_setting( 'front_page_service_text_content_setting_id', array(
            'type' => 'theme_mod', // or 'option'
            'capability' => 'edit_theme_options',
            'default' => '',
            'transport' => 'refresh', // or postMessage
            'sanitize_callback' => 'sanitize_text_field',
      
          ) );   
      
        $wp_customize->add_control( 'front_page_service_text_content_setting_id', array(
            'type' => 'textarea',
            'priority' => 30,
            'section' => 'front_page_service_text_section_id',
            'label' => __( 'Add Content' ),
            'description' => __( 'Add Text content to service provide section front page' ),
          ) );


        $wp_customize->add_setting( 'front_page_service_text_content_color_setting_id', array(
            'type' => 'option',
            'capability' => 'manage_options',
            'default' => '#fff',
            'sanitize_callback' => 'sanitize_hex_color',
          ) );
      
        $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'front_page_service_text_content_color_setting_id', array(
            'label' => __( 'Change Text Color' ),
            'section' => 'front_page_service_text_section_id',
            'priority' => 40,
          ) ) );



/* <-======================= Service Provider Color ==========================-> */
      

        $wp_customize->add_section('front_page_service_color_section_id', array(
            'title' => 'Front Page Service Color',
            'description' => 'Add Color to service provide section front page',
            'panel' => 'front_page_service_panel_id'
        ));

        $wp_customize->add_setting( 'front_page_service_bg_color_setting_id', array(
            'type' => 'option',
            'capability' => 'manage_options',
            'default' => '',
            'sanitize_callback' => 'sanitize_hex_color',
          ) );
      
        $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'front_page_service_bg_color_setting_id', array(
            'label' => __( 'Change Background Color' ),
            'section' => 'front_page_service_color_section_id',
            'priority' => 10,
          ) ) );


          $wp_customize->add_setting( 'front_page_service_Icon_color_setting_id', array(
            'type' => 'option',
            'capability' => 'manage_options',
            'default' => '',
            'sanitize_callback' => 'sanitize_hex_color',
          ) );
      
        $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'front_page_service_Icon_color_setting_id', array(
            'label' => __( 'Change Icon Color' ),
            'section' => 'front_page_service_color_section_id',
            'priority' => 20,
          ) ) );


          
          $wp_customize->add_setting( 'front_page_service_text_color_setting_id', array(
            'type' => 'option',
            'capability' => 'manage_options',
            'default' => '',
            'sanitize_callback' => 'sanitize_hex_color',
          ) );
      
        $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'front_page_service_text_color_setting_id', array(
            'label' => __( 'Change Text Color' ),
            'section' => 'front_page_service_color_section_id',
            'priority' => 40,
          ) ) );


          $wp_customize->add_setting( 'front_page_service_item_bg_color_setting_id', array(
            'type' => 'option',
            'capability' => 'manage_options',
            'default' => '#fff',
            'sanitize_callback' => 'sanitize_hex_color',
          ) );
      
        $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'front_page_service_item_bg_color_setting_id', array(
            'label' => __( 'Change Item Background Color' ),
            'section' => 'front_page_service_color_section_id',
            'priority' => 30,
          ) ) );



    }
}

$object = new Add_front_page_service_provide();


