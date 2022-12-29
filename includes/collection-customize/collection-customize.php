<?php

add_action( 'customize_register', "register_javascript" );

function register_javascript(){

    class WP_New_Menu_Customize_Control extends WP_Customize_Control {
        public $type = 'new_menu';
        /**
        * Render the control's content.
        */
        public function render_content() {
        ?>
           <input type="text" id="collection_front_page_value" value="" <?php echo $this->link(); ?>>
           <?php wp_nonce_field("collection_front_page_nonce_action", "collection_front_page_nonce_name") ?>

           <?php

                $values = get_theme_mod("font_page_collection_product_setting_id");

                $datas = maybe_unserialize($values);

                // echo "<pre>";
                //     print_r($datas);    
                // echo "</pre>";
          
            ?>

            <form action="#">
                <div class="collection-section-front-page">

                        <?php if(empty($datas)): ?>

                            <div class="collection-item">
                                <div class="form-control">
                                    <label for=""><h4>Field Title</h4></label>
                                    <input type="text" class="field-title" placeholder="Add the field title" value="">
                                </div>
                                <div class="form-control">
                                    <label for=""><h4>Button Text</h4></label>
                                    <input type="text" class="field-text" placeholder="Add the Button text" value="">
                                </div>
                                <div class="form-control">
                                    <label for=""><h4>Field Slug Value</h4></label><span>Use slug value from Taxonomy "field-cat"</span>
                                    <input type="text" class="field-slug" placeholder="slug-value" value="">
                                </div>
                                <div class="form-control">
                                    <div class="image" style="display: none;">
                                        <img src="" alt="">
                                    </div>
                                    <input type="hidden" class="image-id" value="">
                                    <input type="button" class="field-button field_button_add" value="Add represent Image for field">
                                    <input type="button" class="field-button field_button_remove" value="Remove Image" style="display: none;">
                                </div>
                                <div class="delete-collection-item">
                                        X
                                </div>
                            </div>
                        <?php else: ?>
                            <?php foreach($datas as $data): ?>

                                <?php
                                    $field_img_id = $data['image_id'];
                                    $image_url = wp_get_attachment_url($field_img_id);
                                ?>

                                <div class="collection-item">
                                    <div class="form-control">
                                        <label for=""><h4>Field Title</h4></label>
                                        <input type="text" class="field-title" placeholder="Add the field title" value="<?=$data['title'];?>">
                                    </div>
                                    <div class="form-control">
                                        <label for=""><h4>Button Text</h4></label>
                                        <input type="text" class="field-text" placeholder="Add the Button text" value="<?=$data['text'];?>">
                                    </div>
                                    <div class="form-control">
                                        <label for=""><h4>Field Slug Value</h4></label><span>Use slug value from Taxonomy "field-cat"</span>
                                        <input type="text" class="field-slug" placeholder="slug-value" value="<?=$data['slug'];?>">
                                    </div>
                                    <div class="form-control">
                                        <div class="image">
                                            <img src="<?=$image_url?>" alt="">
                                        </div>
                                        <input type="hidden" class="image-id" value="<?=$field_img_id?>">
                                        <input type="button" class="field-button field_button_add" value="Add represent Image for field" style="display: none;">
                                        <input type="button" class="field-button field_button_remove" value="Remove Image" style="display: block;">
                                    </div>
                                    <div class="delete-collection-item">
                                            X
                                    </div>
                                </div>
                            <?php endforeach; ?>   
                        <?php endif; ?>

                        <div class="collection-default-item" style="display: none;">
                            <div class="form-control">
                                <label for=""><h4>Field Title</h4></label>
                                <input type="text" class="field-title" placeholder="Add the field title" value="">
                            </div>
                            <div class="form-control">
                                <label for=""><h4>Button Text</h4></label>
                                <input type="text" class="field-text" placeholder="Add the Button text" value="">
                            </div>
                            <div class="form-control">
                                <label for=""><h4>Field Slug Value</h4></label><span>Use slug value from Taxonomy "field-cat"</span>
                                <input type="text" class="field-slug" placeholder="slug-value" value="">
                            </div>
                            <div class="form-control">
                                <div class="image" style="display: none;">
                                    <img src="" alt="">
                                </div>
                                <input type="hidden" class="image-id" value="">
                                <input type="button" class="field-button field_button_add" value="Add represent Image for field">
                                <input type="button" class="field-button field_button_remove" value="Remove Image" style="display: none;">
                            </div>
                            <div class="delete-collection-item">
                                    X
                            </div>
                        </div>
                </div>
                <button type="submit" class="save_data_field">Upload Data Field</button>
           </form>

           <button class="add_more_field">Add More Field</button>
        <?php
        }
    }
    
  
}

class Add_font_page_collection_product{

    public function __construct()
    {
        add_action( 'customize_register', [$this, "my_customize_register"] );

        add_action( 'admin_enqueue_scripts', [$this, 'add_media_script'] );

        add_action( 'customize_controls_enqueue_scripts', [$this, "register_script_file"] );
    }

    public function register_script_file(){

        wp_enqueue_script( 'collection-front-page-js', get_template_directory_uri().'/includes/collection-customize/collection-customize.js?gh=abcefg', array('jquery'), '1.0.0', true );

        wp_enqueue_style( 'collection-front-page-css', get_template_directory_uri()."/includes/collection-customize/collection-customize.css?gh=abcfg", array(), "1.0.0", "all" );

        wp_localize_script( 'collection-front-page-js', 'add_collection', array(
            'ajaxurl' => admin_url( 'admin-ajax.php' )
        ) );

    }

    public function add_media_script( $hook_suffix ) {

        wp_enqueue_media();
    
    }
    

    public function my_customize_register( $wp_customize ){

        $wp_customize->add_panel('font_page_collection_product_panel_id', array(
            'title' => 'Setting Front Page Collection Section',
            'description' => 'This field use to setting up the front page - collection section',
            'priority' => 250
        ));

        $wp_customize->add_section('font_page_collection_product_section_id', array(
            'title' => 'Front Page Collection Section',
            'description' => 'Add collection section information for front page',
            'panel' => 'font_page_collection_product_panel_id'
        ));

        $wp_customize->add_setting('font_page_collection_product_setting_id', array(
            'type' => 'theme_mod',
            'capability' => 'edit_theme_options',
            'default' => '',
            'transport' => 'refresh', // or postMessage
            //'sanitize_callback' => 'wp_filter_nohtml_kses'
        ));

        $wp_customize->add_control(
            new WP_New_Menu_Customize_Control($wp_customize, 'font_page_collection_product_setting_id', array(
                'label' => 'Add Collection Info',
                'section' => 'font_page_collection_product_section_id'
            ))
        );

    }
}

$object = new Add_font_page_collection_product();


