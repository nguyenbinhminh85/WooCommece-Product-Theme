<?php

class Add_font_page_section_title{

    public function __construct()
    {
        add_action( 'customize_register', [$this, "my_customize_register_best_seller"] );
        add_action( 'customize_register', [$this, "my_customize_register_new_arrival"] );

        add_action( 'customize_register', [$this, "my_customize_register_news"] );

        add_action( 'customize_register', [$this, "my_customize_register_collection"] );

        add_action( 'customize_register', [$this, "my_customize_register_authorized"] );

    }

    
    
    public function my_customize_register_best_seller( $wp_customize ){

        $wp_customize->add_panel('font_page_section_title_panel_id', array(
            'title' => 'Setting Front Page Section Title',
            'description' => 'This field use to setting up the front page - section title',
            'priority' => 280
        ));

        $wp_customize->add_section('font_page_section_title_bestSeller_section_id', array(
            'title' => 'Front Page Best Seller Section Title',
            'description' => 'Add best seller section title information for front page',
            'panel' => 'font_page_section_title_panel_id'
        ));

        $wp_customize->add_setting('font_page_section_title_bestSeller_setting_id', array(
            'type' => 'theme_mod',
            'capability' => 'edit_theme_options',
            'default' => '',
            'transport' => 'refresh', // or postMessage
            'sanitize_callback' => 'sanitize_text_field'
        ));

        $wp_customize->add_control( 'font_page_section_title_bestSeller_setting_id', array(
            'type' => 'text',
            'priority' => 10,
            'section' => 'font_page_section_title_bestSeller_section_id',
            'label' => __( 'Add Best Seller Section Title Text ' ),
            'description' => __( 'Add bestSeller section title text to front page' ),
          ) );

          $wp_customize->add_setting( 'font_page_section_title_text_color_bestSeller_setting_id', array(
            'type' => 'option',
            'capability' => 'manage_options',
            'default' => '#3f7059',
            'sanitize_callback' => 'sanitize_hex_color',
          ) );
      
        $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'font_page_section_title_text_color_bestSeller_setting_id', array(
            'label' => __( 'Change Best seller Section Title Text Color' ),
            'section' => 'font_page_section_title_bestSeller_section_id',
            'priority' => 20,
          ) ) );

          $wp_customize->add_setting( 'font_page_section_title_sideBar_color_bestSeller_setting_id', array(
            'type' => 'option',
            'capability' => 'manage_options',
            'default' => '',
            'sanitize_callback' => 'sanitize_hex_color',
          ) );
      
        $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'font_page_section_title_sideBar_color_bestSeller_setting_id', array(
            'label' => __( 'Change Best seller Section Title Sidebar Color' ),
            'section' => 'font_page_section_title_bestSeller_section_id',
            'priority' => 30,
          ) ) );


    }

    public function my_customize_register_new_arrival( $wp_customize ){

        $wp_customize->add_section('font_page_section_title_newArrival_section_id', array(
            'title' => 'Front Page NewArrival Section Title',
            'description' => 'Add New Arrival section title information for front page',
            'panel' => 'font_page_section_title_panel_id'
        ));




        $wp_customize->add_setting('font_page_section_title_newArrival_setting_id', array(
            'type' => 'theme_mod',
            'capability' => 'edit_theme_options',
            'default' => '',
            'transport' => 'refresh', // or postMessage
            'sanitize_callback' => 'sanitize_text_field'
        ));

        $wp_customize->add_control( 'font_page_section_title_newArrival_setting_id', array(
            'type' => 'text',
            'priority' => 10,
            'section' => 'font_page_section_title_newArrival_section_id',
            'label' => __( 'Add New Arival Section Title Text ' ),
            'description' => __( 'Add new arrival section title text to front page' ),
          ) );




          $wp_customize->add_setting( 'font_page_section_title_text_color_newArrival_setting_id', array(
            'type' => 'option',
            'capability' => 'manage_options',
            'default' => '#3f7059',
            'sanitize_callback' => 'sanitize_hex_color',
          ) );
      
        $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'font_page_section_title_text_color_newArrival_setting_id', array(
            'label' => __( 'Change New Arrival Section Title Text Color' ),
            'section' => 'font_page_section_title_newArrival_section_id',
            'priority' => 20,
          ) ) );



          $wp_customize->add_setting( 'font_page_section_title_sideBar_color_newArrival_setting_id', array(
            'type' => 'option',
            'capability' => 'manage_options',
            'default' => '',
            'sanitize_callback' => 'sanitize_hex_color',
          ) );
      
        $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'font_page_section_title_sideBar_color_newArrival_setting_id', array(
            'label' => __( 'Change New Arrival Section Title Sidebar Color' ),
            'section' => 'font_page_section_title_newArrival_section_id',
            'priority' => 30,
          ) ) );


    }

    public function my_customize_register_news( $wp_customize ){

        $wp_customize->add_section('font_page_section_title_news_section_id', array(
            'title' => 'Front Page News Section Title',
            'description' => 'Add News section title information for front page',
            'panel' => 'font_page_section_title_panel_id'
        ));



        $wp_customize->add_setting('font_page_section_title_News_setting_id', array(
            'type' => 'theme_mod',
            'capability' => 'edit_theme_options',
            'default' => '',
            'transport' => 'refresh', // or postMessage
            'sanitize_callback' => 'sanitize_text_field'
        ));

        $wp_customize->add_control( 'font_page_section_title_News_setting_id', array(
            'type' => 'text',
            'priority' => 10,
            'section' => 'font_page_section_title_news_section_id',
            'label' => __( 'Add News Section Title Text' ),
            'description' => __( 'Add News section title text to front page' ),
          ) );




          $wp_customize->add_setting( 'font_page_section_title_text_color_News_setting_id', array(
            'type' => 'option',
            'capability' => 'manage_options',
            'default' => '#3f7059',
            'sanitize_callback' => 'sanitize_hex_color',
          ) );
      
        $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'font_page_section_title_text_color_News_setting_id', array(
            'label' => __( 'Change News Section Title Text Color' ),
            'section' => 'font_page_section_title_news_section_id',
            'priority' => 20,
          ) ) );




          $wp_customize->add_setting( 'font_page_section_title_sideBar_color_News_setting_id', array(
            'type' => 'option',
            'capability' => 'manage_options',
            'default' => '',
            'sanitize_callback' => 'sanitize_hex_color',
          ) );
      
        $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'font_page_section_title_sideBar_color_News_setting_id', array(
            'label' => __( 'Change News Section Title Sidebar Color' ),
            'section' => 'font_page_section_title_news_section_id',
            'priority' => 30,
          ) ) );


    }

    public function my_customize_register_collection( $wp_customize ){

        $wp_customize->add_section('font_page_section_title_Collection_section_id', array(
            'title' => 'Front Page Collection Section Title',
            'description' => 'Add Collection section title information for front page',
            'panel' => 'font_page_section_title_panel_id'
        ));



        $wp_customize->add_setting('font_page_section_title_Collection_setting_id', array(
            'type' => 'theme_mod',
            'capability' => 'edit_theme_options',
            'default' => '',
            'transport' => 'refresh', // or postMessage
            'sanitize_callback' => 'sanitize_text_field'
        ));

        $wp_customize->add_control( 'font_page_section_title_Collection_setting_id', array(
            'type' => 'text',
            'priority' => 10,
            'section' => 'font_page_section_title_Collection_section_id',
            'label' => __( 'Add Collection Section Title Text' ),
            'description' => __( 'Add Collection section title text to front page' ),
          ) );




          $wp_customize->add_setting( 'font_page_section_title_text_color_Collection_setting_id', array(
            'type' => 'option',
            'capability' => 'manage_options',
            'default' => '#3f7059',
            'sanitize_callback' => 'sanitize_hex_color',
          ) );
      
        $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'font_page_section_title_text_color_Collection_setting_id', array(
            'label' => __( 'Change Collection Section Title Text Color' ),
            'section' => 'font_page_section_title_Collection_section_id',
            'priority' => 20,
          ) ) );




          $wp_customize->add_setting( 'font_page_section_title_sideBar_color_Collection_setting_id', array(
            'type' => 'option',
            'capability' => 'manage_options',
            'default' => '',
            'sanitize_callback' => 'sanitize_hex_color',
          ) );
      
        $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'font_page_section_title_sideBar_color_Collection_setting_id', array(
            'label' => __( 'Change Collection Section Title Sidebar Color' ),
            'section' => 'font_page_section_title_Collection_section_id',
            'priority' => 30,
          ) ) );


    }

    public function my_customize_register_authorized( $wp_customize ){

        $wp_customize->add_section('font_page_section_title_Authorized_section_id', array(
            'title' => 'Front Page Authorized Section Title',
            'description' => 'Add Authorized section title information for front page',
            'panel' => 'font_page_section_title_panel_id'
        ));



        $wp_customize->add_setting('font_page_section_title_Authorized_setting_id', array(
            'type' => 'theme_mod',
            'capability' => 'edit_theme_options',
            'default' => '',
            'transport' => 'refresh', // or postMessage
            'sanitize_callback' => 'sanitize_text_field'
        ));

        $wp_customize->add_control( 'font_page_section_title_Authorized_setting_id', array(
            'type' => 'text',
            'priority' => 10,
            'section' => 'font_page_section_title_Authorized_section_id',
            'label' => __( 'Add Authorized Section Title Text' ),
            'description' => __( 'Add Authorized section title text to front page' ),
          ) );




          $wp_customize->add_setting( 'font_page_section_title_text_color_Authorized_setting_id', array(
            'type' => 'option',
            'capability' => 'manage_options',
            'default' => '#3f7059',
            'sanitize_callback' => 'sanitize_hex_color',
          ) );
      
        $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'font_page_section_title_text_color_Authorized_setting_id', array(
            'label' => __( 'Change Authorized Section Title Text Color' ),
            'section' => 'font_page_section_title_Authorized_section_id',
            'priority' => 20,
          ) ) );




          $wp_customize->add_setting( 'font_page_section_title_sideBar_color_Authorized_setting_id', array(
            'type' => 'option',
            'capability' => 'manage_options',
            'default' => '',
            'sanitize_callback' => 'sanitize_hex_color',
          ) );
      
        $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'font_page_section_title_sideBar_color_Authorized_setting_id', array(
            'label' => __( 'Change Aithorized Section Title Sidebar Color' ),
            'section' => 'font_page_section_title_Authorized_section_id',
            'priority' => 30,
          ) ) );


    }
}

$object = new Add_font_page_section_title();
