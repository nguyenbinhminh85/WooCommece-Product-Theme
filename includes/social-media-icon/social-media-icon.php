<?php

add_action('customize_register','add_social_media_icon');  

function add_social_media_icon(){

    class WP_Social_Media_Customize_Control extends WP_Customize_Control {
        
        /**
        * Render the control's content.
        */
        public function render_content() {
            
    
                    $values = get_theme_mod("footer_1_social_media_setting_id");
                    $datas = maybe_unserialize($values);

                    // echo "<pre>";
                    //     print_r($datas);    
                    // echo "</pre>";

            ?>
                <div class="social_media_section">

                    <input type="hidden" id='social_icon_output_value' name="social_icon_output_value" <?php echo $this->link() ?> value="">
                    <?php wp_nonce_field( 'add_social_media_nonce_action', 'add_social_media_nonce_name' ); ?> 

                    <h3>Add Social Media Field</h3>
                    <p style="font-style: italic;"><?php echo $this->description ?></p>
                    
                    <form action="#">
                        <div class="add_social_media_section">

                            <?php if(empty($datas)): ?>

                                 <!-- group-media-init item -->
                                <div class="icon-media" style="display: block;">
                                    <div class="delete_media_icon">
                                        <div>X</div>
                                    </div> 
                                    <div class="media-item">
                                        <label for="icon"> Add your font awesome class Icon: </label>
                                        <input type="text" class='icon' value="" placeholder="fa-brands fa-facebook">
                                    </div>
                                    <div class="media-item">
                                        <label for="icon_color"> Add color to Icon: </label>
                                        <input type="color" class='icon_color' value="">
                                    </div>
                                    <div class="media-item">
                                        <label for="url">Add your url for social media:</label>
                                        <input type="text" class='icon_url' value="" placeholder="facebook.com">
                                    </div>
                                </div>

                            <?php else: ?>

                                <?php foreach($datas as $data): ?>

                                    <div class="icon-media" style="display: block;">
                                        <div class="delete_media_icon">
                                            <div>X</div>
                                        </div> 
                                        <div class="media-item">
                                            <label for="icon"> Add your font awesome class Icon: </label>
                                            <input type="text" class='icon' value="<?=$data['icon']?>" placeholder="fa-brands fa-facebook">
                                        </div>
                                        <div class="media-item">
                                            <label for="icon_color"> Add color to Icon: </label>
                                            <input type="color" class='icon_color' value="<?=$data['icon_color']?>">
                                        </div>
                                        <div class="media-item">
                                            <label for="url">Add your url for social media:</label>
                                            <input type="text" class='icon_url' value="<?=$data['icon_url']?>" placeholder="facebook.com">
                                        </div>
                                    </div>
                                   
                                <?php endforeach; ?> 

                            <?php endif; ?>

                            <!-- group-media-standard to clone -->
                            <div class="icon-media-standard" style="display: none;">
                                <div class="delete_media_icon">
                                    <div>X</div>
                                </div> 
                                <div class="media-item">
                                    <label for="icon"> Add your font awesome class Icon: </label>
                                    <input type="text" class='icon' value="" placeholder="fa-brands fa-facebook">
                                </div>
                                <div class="media-item">
                                    <label for="icon_color"> Add color to Icon: </label>
                                    <input type="color" class='icon_color' value="">
                                </div>
                                <div class="media-item">
                                    <label for="url">Add your url for social media:</label>
                                    <input type="text" class='icon_url' value="" placeholder="facebook.com">
                                </div>
                            </div>

                        </div>

                        <button type="submit" class="save_icon_data">Upload Icon Data</button>
                    </form>

                    <button class="add_more_icon">Add More Icon</button>

                </div>                    

            <?php
        }

      }

}


class Add_Social_Media_Icon{

    public function __construct()
    {
        add_action( 'customize_register', [$this, "my_customize_register"] );

        add_action( 'admin_enqueue_scripts', [$this, 'add_media_script'] );

        add_action( 'customize_controls_enqueue_scripts', [$this, "register_script_file"] );
    }

    public function register_script_file(){

        wp_enqueue_script( 'social-media-js', get_template_directory_uri().'/includes/social-media-icon/social-media-icon.js?gh=abcgf', array('jquery'), '1.0.0', true );

        wp_enqueue_style( 'social-media-css', get_template_directory_uri()."/includes/social-media-icon/social-media-icon.css?gh=abcgf", array(), "1.0.0", "all" );

        wp_localize_script( 'social-media-js', 'add_social', array(
                'ajaxurl' => admin_url( 'admin-ajax.php' )
            ) 
        );

    }

    public function add_media_script( $hook_suffix ) {

        wp_enqueue_media();
    
    }
    

    public function my_customize_register( $wp_customize ){

        $wp_customize->add_panel('footer_panel_id', array(
            'title' => 'Setting Footer Section',
            'description' => 'This field use to setting up footer section',
            'priority' => 290
        ));

    /* <-===============================//Footer 1 Section //========================-> */

        $wp_customize->add_section('footer_1_section_id', array(
            'title' => 'Add Social Media & Company Logo',
            'description' => 'Add Infomation to Footer Section 1',
            'panel' => 'footer_panel_id'
        ));

    /* <-===============================//Add Company Logo//========================-> */

        $wp_customize->add_setting('footer_1_company_logo_setting_id', array(
            'type' => 'theme_mod',
            'capability' => 'edit_theme_options',
            'default' => '',
            'transport' => 'refresh', // or postMessage
            'sanitize_callback' => 'absint'
        ));

        $wp_customize->add_control( new WP_Customize_Cropped_Image_Control( $wp_customize, 'footer_1_company_logo_setting_id', array(
            'section'     => 'footer_1_section_id',   
            'label'       => 'Company Logo Image',
            'description' => 'Add company logo image on Footer Section',
            'flex_width'  => true, // Allow any width, making the specified value recommended. False by default.
            'flex_height' => false, // Require the resulting image to be exactly as tall as the height attribute (default).
            'width'       => 300,
            'height'      => 100,
        ) ) ); 



    /* <-===============================//Add Greeting Text//========================-> */

        $wp_customize->add_setting('footer_1_greeting_text_setting_id', array(
            'type' => 'theme_mod',
            'capability' => 'edit_theme_options',
            'default' => 'Stay connected!',
            'transport' => 'refresh', // or postMessage
            'sanitize_callback' => 'sanitize_text_field'
        ));   

        $wp_customize->add_control( 'footer_1_greeting_text_setting_id', 
            array(
                'label'                 => esc_html__( 'Add Greeting Text'),
                'section'               => 'footer_1_section_id',
                'type'                  => 'text',
                'description'           => 'Please add greeting before social_media_icon'
            )
        ); 

    /* <-===============================//Add Social Media Icon//========================-> */

        $wp_customize->add_setting( 'footer_1_social_media_setting_id', array(
            'type' => 'theme_mod', // or 'option'
            'default' =>  '',
            'transport' => 'refresh', // or postMessage
            'sanitize_callback' => 'sanitize_text_field'
        ) );

        $wp_customize->add_control( 
            new WP_Social_Media_Customize_Control( $wp_customize,'footer_1_social_media_setting_id', 
                array(
                    'section'       => 'footer_1_section_id',
                    'description'   => 'Add font awesome social button icon'
                )
            )
        ); 
    /* <-===============================//Add Footer BackGround Color//========================-> */

        $wp_customize->add_section('footer_backgroundColor_section_id', array(
            'title' => 'Footer_Background_Color',
            'description' => 'Add backgroundColor to Footer',
            'panel' => 'footer_panel_id'
        ));

        $wp_customize->add_setting( 'footer_backgroundColor_setting_id', array(
            'type' => 'option',
            'capability' => 'manage_options',
            'default' => '#333',
            'sanitize_callback' => 'sanitize_hex_color',
        ) );


        $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'footer_backgroundColor_setting_id', array(
            'label' => __( 'Add Footer Background Color'),
            'section' => 'footer_backgroundColor_section_id',
            'description' => 'Change footer background color!'
          ) ) );

    /* <-===============================//Add Footer Text Color//========================-> */

        $wp_customize->add_section('footer_text_color_section_id', array(
            'title' => 'Setting Footer Text Color',
            'description' => 'Change footer text color',
            'panel' => 'footer_panel_id'
        ));

        $wp_customize->add_setting( 'footer_text_color_setting_id', array(
            'type' => 'option',
            'capability' => 'manage_options',
            'default' => '#333',
            'sanitize_callback' => 'sanitize_hex_color',
        ) );


        $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'footer_text_color_setting_id', array(
            'label' => __( 'Setting Footer Text Color'),
            'section' => 'footer_text_color_section_id',
            'description' => 'Change Footer Text color!'
        ) ) );


    }
}

$object = new Add_Social_Media_Icon();



/* <-===============================//PHP Handling Add Social Icon//========================-> */

add_action( 'wp_ajax_add_social_media', 'add_social_icon_ajax' );
add_action('wp_ajax_nopriv_add_social_media', 'add_social_icon_ajax');

function add_social_icon_ajax() {
    
    if ( !isset( $_POST['nonce'] ) && !wp_verify_nonce( $_POST['nonce'], 'add_social_media_nonce_action' ) ) {
  
        die( __( 'Security check', 'textdomain' ) ); 
        
    } 

    if(!is_serialized($_POST['values'])){
        $feedback = maybe_serialize($_POST['values']);
    }

    echo $feedback;

    wp_die();
}

