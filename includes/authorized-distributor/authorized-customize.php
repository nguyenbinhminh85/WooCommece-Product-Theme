<?php

add_action( 'customize_register', "register_authorized_javascript" );

function register_authorized_javascript(){

    class WP_New_Menu_Authorized_Customize_Control extends WP_Customize_Control {
        public $type = 'new_menu';
        /**
        * Render the control's content.
        */
        public function render_content() {

            ?>

                <input type="hidden" id="authorized_front_page_value" value="" <?php echo $this->link(); ?>>
                <?php wp_nonce_field("authorized_front_page_nonce_action", "authorized_front_page_nonce_name") ?>

            <?php

                 $values = get_theme_mod("front_page_authorized_setting_id");
                 $datas = maybe_unserialize($values);

            ?>

               
                <div class="authorized-section-front-page">
                    <?php if(empty($datas)): ?>
                        <div class="authorized-item" style="display:block;">
                            <div class="image" style="display: none;">
                                <img src="" alt="">
                            </div>
                            <input type="hidden" class="image-id" value="">
                            <input type="button" class="authorized-button authorized_button_add" value="Add represent Image for authorized">
                            <input type="button" class="authorized-button authorized_button_remove" value="Remove Image" style="display: none;">
                            <div class="delete-authorized-item">
                                    X
                            </div>
                        </div>
                    <?php else: ?>
                        <?php foreach($datas as $data): ?>

                            <?php
                                $field_img_id = $data['image_id'];
                                $image_url = wp_get_attachment_url($field_img_id);
                            ?>

                            <div class="authorized-item" style="display:block;">
                                <div class="image" style="display: block;">
                                    <img src="<?=$image_url?>" alt="saved_img">
                                </div>
                                <input type="hidden" class="image-id" value="<?=$field_img_id?>">
                                <input type="button" class="authorized-button authorized_button_add" value="Add represent Image for authorized" style="display: none;">
                                <input type="button" class="authorized-button authorized_button_remove" value="Remove Image" style="display: block;">
                                <div class="delete-authorized-item">
                                        X
                                </div>
                            </div>

                        <?php endforeach; ?>   
                    <?php endif; ?>

                    <div class="authorized-default-item" style="display:none;">
                        <div class="image" style="display: none;">
                            <img src="" alt="">
                        </div>
                        <input type="hidden" class="image-id" value="">
                        <input type="button" class="authorized-button authorized_button_add" value="Add represent Image for authorized">
                        <input type="button" class="authorized-button authorized_button_remove" value="Remove Image" style="display: none;">
                        <div class="delete-authorized-item">
                                X
                        </div>
                    </div>
                </div>
                <button type="button" class="save_data_authorized">Upload Distributor</button>
               

                <button class="add_more_authorized">Add More Distributor</button>

            <?php
        
        }
    }
    
    
}          

class Add_font_page_authorized_distributor{

    public function __construct()
        {
            add_action( 'customize_register', [$this, "my_customize_register"] );

            add_action( 'admin_enqueue_scripts', [$this, 'add_media_script'] );

            add_action( 'customize_controls_enqueue_scripts', [$this, "register_script_file"] );
        }

    public function register_script_file(){

        wp_enqueue_script( 'authorized-front-page-js', get_template_directory_uri().'/includes/authorized-distributor/authorized-customize.js?gh=abcefg', array('jquery'), '1.0.0', true );

        wp_enqueue_style( 'authorized-front-page-css', get_template_directory_uri()."/includes/authorized-distributor/authorized-customize.css?gh=abcfg", array(), "1.0.0", "all" );

        wp_localize_script( 'authorized-front-page-js', 'add_authorized', array(
            'ajaxurl' => admin_url( 'admin-ajax.php' )
        ) );

    }

    public function add_media_script( $hook_suffix ) {

        wp_enqueue_media();

    }


    public function my_customize_register( $wp_customize ){

        $wp_customize->add_panel('front_page_authorized_panel_id', array(
            'title' => 'Setting Front Page Authorized Section',
            'description' => 'This field use to setting up the front page - authorized distributor section',
            'priority' => 260
        ));

        $wp_customize->add_section('front_page_authorized_section_id', array(
            'title' => 'Front Page Authorized Distributor Section',
            'description' => 'Add authorized distributor section information for front page',
            'panel' => 'front_page_authorized_panel_id'
        ));

        $wp_customize->add_setting('front_page_authorized_setting_id', array(
            'type' => 'theme_mod',
            'capability' => 'edit_theme_options',
            'default' => '',
            'transport' => 'refresh', // or postMessage
            'sanitize_callback' => 'sanitize_text_field'
        ));

        $wp_customize->add_control(
            new WP_New_Menu_Authorized_Customize_Control($wp_customize, 'front_page_authorized_setting_id', array(
                'label' => 'Add Authorized Distributor Info',
                'section' => 'front_page_authorized_section_id'
            ))
        );

    }
}

$object = new Add_font_page_authorized_distributor();


