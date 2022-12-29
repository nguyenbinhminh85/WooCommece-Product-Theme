<?php

add_action('customize_register','add_company_information_html');

function add_company_information_html(){

    class WP_Footer_2_Customize_Control extends WP_Customize_Control {

        /**
        * Render the control's content.
        */
        public function render_content() {

            $values = get_theme_mod("footer_2_contact_info_setting_id");
            $datas = maybe_unserialize($values);

            // echo "<pre>";
            //     print_r($datas);    
            // echo "</pre>";

        ?>
                <section class="company-info">
                    <div class="section-info">
                        <h3><?php echo $this->label?></h3>
                        <p class="description"><?php echo $this->description ?></p>
                    </div>
                    <form action="#">
                        <div class="company-address-contact-info">

                            <?php wp_nonce_field( 'add_company_info_action', 'add_company_info_nonce_field' ); ?>
                            <input type="hidden" id="get_company_info" <?php echo $this->link()?> value=""> 
                            
                            <?php if(empty($datas)): ?>

                                <div class="item-address-contact-info">
                                    <div class="item-title">
                                        <label for="title">Location</label>
                                        <input type="text" class="title info" id="title" placeholder="Location 1">
                                    </div>
                                    <!-- Address infomation -->   
                                    <div class="item-address">
                                        <div class="item-address-icon">
                                            <label for="addressIcon">Icon (Font awesome class)</label>
                                            <input type="text" class="addressIcon info" id="addressIcon" placeholder="fa-solid fa-location-dot">
                                        </div>
                                        <div class="item-address-info">
                                            <label for="addressInfo">Info</label>
                                            <input type="text" class="addressInfo info" id="addressInfo" placeholder="Address Info">
                                        </div>
                                    </div>
                                    <!-- Phone infomation --> 
                                    <div class="item-phone">
                                        <div class="item-phone-icon">
                                            <label for="phoneIcon">Icon (Font awesome class)</label>
                                            <input type="text" class="phoneIcon info" id="phoneIcon" placeholder="fa-solid fa-phone">
                                        </div>
                                        <div class="item-phone-info">
                                            <label for="phoneInfo">Info</label>
                                            <input type="text" class="phoneInfo info" id="phoneInfo" placeholder="Phone Info">
                                        </div>
                                    </div>
                                    <!-- Email infomation --> 
                                    <div class="item-email">
                                        <div class="item-email-icon">
                                            <label for="emailIcon">Icon (Font awesome class)</label>
                                            <input type="text" class="emailIcon info" id="emailIcon" placeholder="fa-solid fa-envelope">
                                        </div>
                                        <div class="item-email-info">
                                            <label for="emailInfo">Info</label>
                                            <input type="text" class="emailInfo info" id="emailInfo" placeholder="Email Info">
                                        </div>
                                    </div>      
                                </div>

                            <?php else: ?>

                                <?php foreach($datas as $data): ?>

                                    <div class="item-address-contact-info">
                                        <div class="delete-item">
                                            <p class="delete-button">X</p>
                                        </div>
                                        <!-- Address Title --> 
                                        <div class="item-title">
                                            <label for="title">Location</label>
                                            <input type="text" class="title info" id="title" placeholder="Location 1" value="<?=$data[0]['title']?>">
                                        </div>
                                        <!-- Address infomation -->   
                                        <div class="item-address">
                                            <div class="item-address-icon">
                                                <label for="addressIcon">Icon (Font awesome class)</label>
                                                <input type="text" class="addressIcon info" id="addressIcon" placeholder="fa-solid fa-location-dot" value="<?=$data[1]['addressIcon']?>">
                                            </div>
                                            <div class="item-address-info">
                                                <label for="addressInfo">Info</label>
                                                <input type="text" class="addressInfo info" id="addressInfo" placeholder="Address Info" value="<?=$data[1]['addressInfo']?>">
                                            </div>
                                        </div>
                                        <!-- Phone infomation --> 
                                        <div class="item-phone">
                                            <div class="item-phone-icon">
                                                <label for="phoneIcon">Icon (Font awesome class)</label>
                                                <input type="text" class="phoneIcon info" id="phoneIcon" placeholder="fa-solid fa-phone" value="<?=$data[2]['phoneIcon']?>">
                                            </div>
                                            <div class="item-phone-info">
                                                <label for="phoneInfo">Info</label>
                                                <input type="text" class="phoneInfo info" id="phoneInfo" placeholder="Phone Info" value="<?=$data[2]['phoneInfo']?>">
                                            </div>
                                        </div>
                                        <!-- Email infomation --> 
                                        <div class="item-email">
                                            <div class="item-email-icon">
                                                <label for="emailIcon">Icon (Font awesome class)</label>
                                                <input type="text" class="emailIcon info" id="emailIcon" placeholder="fa-solid fa-envelope" value="<?=$data[3]['emailIcon']?>">
                                            </div>
                                            <div class="item-email-info">
                                                <label for="emailInfo">Info</label>
                                                <input type="text" class="emailInfo info" id="emailInfo" placeholder="Email Info" value="<?=$data[3]['emailInfo']?>">
                                            </div>
                                        </div>      
                                    </div>

                                <?php endforeach; ?> 

                            <?php endif; ?>
                        
                        </div>
                        <button type="submit" class="save-company-item">Save Company Info</button>
                    </form>
                    <div class="add-item-address-contact-info">
                        <button type="button" class="add-more-company-item">Add More Company Info</button>
                    </div>
                </section>

                <!-- Default Clone Item -->
                    <div class="item-address-contact-info-default">
                         <div class="delete-item">
                            <p class="delete-button">X</p>
                         </div>
                         <div class="item-title">
                            <label for="title">Location</label>
                            <input type="text" class="title info" id="title" placeholder="Location 1">
                         </div>
                         <!-- Address infomation -->   
                         <div class="item-address">
                            <div class="item-address-icon">
                                <label for="addressIcon">Icon (Font awesome class)</label>
                                <input type="text" class="addressIcon info" id="addressIcon" placeholder="fa-solid fa-location-dot">
                            </div>
                            <div class="item-address-info">
                                <label for="addressInfo">Info</label>
                                <input type="text" class="addressInfo info" id="addressInfo" placeholder="Address Info">
                            </div>
                         </div>
                         <!-- Phone infomation --> 
                         <div class="item-phone">
                            <div class="item-phone-icon">
                                <label for="phoneIcon">Icon (Font awesome class)</label>
                                <input type="text" class="phoneIcon info" id="phoneIcon" placeholder="fa-solid fa-phone">
                            </div>
                            <div class="item-phone-info">
                                <label for="phoneInfo">Info</label>
                                <input type="text" class="phoneInfo info" id="phoneInfo" placeholder="Phone Info">
                            </div>
                         </div>
                          <!-- Email infomation --> 
                          <div class="item-email">
                            <div class="item-email-icon">
                                <label for="emailIcon">Icon (Font awesome class)</label>
                                <input type="text" class="emailIcon info" id="emailIcon" placeholder="fa-solid fa-envelope">
                            </div>
                            <div class="item-email-info">
                                <label for="emailInfo">Info</label>
                                <input type="text" class="emailInfo info" id="emailInfo" placeholder="Email Info">
                            </div>
                         </div>      
                    </div>


        <?php
        }

      }

}



class Add_company_information{

    public function __construct()
    {
        add_action( 'customize_register', [$this, "my_customize_register"] );

        add_action( 'customize_controls_enqueue_scripts', [$this, "register_script_file"] );
    }

    public function register_script_file(){

        wp_enqueue_script( 'company-information-js', get_template_directory_uri().'/includes/company-address/company-address-customize.js?gh=abc', array('jquery'), '1.0.0', true );

        wp_enqueue_style( 'company-information-css', get_template_directory_uri()."/includes/company-address/company-address-customize.css?gh=abc", array(), "1.0.0", "all" );

        wp_localize_script( 'social-media-js', 'add_company', array(
                'ajaxurl' => admin_url( 'admin-ajax.php' )
            ) 
        );

    }

    public function my_customize_register( $wp_customize ){

        $wp_customize->add_section( 'footer_2_section_id', array(
            'title'         => __( 'Add Company Address And Contact' ),
            'description'   => __( 'Add company location and contact' ),
            'panel'         => 'footer_panel_id', // Not typically needed.
            'priority'      => 60,
            'capability'    => 'edit_theme_options',
        ) );
    

        $wp_customize->add_setting( 'footer_2_title_setting_id', array(

            'type'              => 'theme_mod', // or 'option'
            'capability'        => 'edit_theme_options',
            'default'           => 'Section Title',
            'transport'         => 'refresh', // or postMessage
            'sanitize_callback' => 'sanitize_text_field',

        ) );

        $wp_customize->add_control( 'footer_2_title_setting_id', array(
            'type'          => 'text',
            'section'       => 'footer_2_section_id',
            'label'         => __( 'Company Information Title' ),
            'description'   => __( 'Add footer section 2 Title' ),
            
        ) );


        $wp_customize->add_setting( 'footer_2_contact_info_setting_id', array(

            'type'              => 'theme_mod', // or 'option'
            'capability'        => 'edit_theme_options',
            'transport'         => 'refresh', // or postMessage
            'sanitize_callback' => 'sanitize_text_field',

        ) );

        $wp_customize->add_control( new WP_Footer_2_Customize_Control($wp_customize, 'footer_2_contact_info_setting_id', // Setting id
                array( 
                    'section'       => 'footer_2_section_id',
                    'label'         => __( 'Company Contact Information' ),
                    'description'   => __( 'Add company address, phone, email' ),
                )
              )
         );

    }

}

new Add_company_information();




add_action( 'wp_ajax_add_company_address_info', 'add_company_info_ajax_handler' );
add_action('wp_ajax_nopriv_add_company_address_info', 'add_company_info_ajax_handler');

function add_company_info_ajax_handler() {
   
	if ( !isset( $_POST['nonce'] ) || !wp_verify_nonce( $_POST['nonce'], 'add_company_info_action' ) ) {
  
        die( __( 'Security check', 'textdomain' ) ); 
    }
 
    $values = $_POST['data'];
    echo maybe_serialize( $values );
    
    wp_die();
}