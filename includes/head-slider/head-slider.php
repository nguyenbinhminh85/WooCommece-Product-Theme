<?php

add_action('customize_register', 'headerSlider_customize_register');

function headerSlider_customize_register($wp_customize){


    $wp_customize->add_panel( 'header_slider_panel_id', array(
        'priority'       => 220,
        'capability'     => 'edit_theme_options',
        'title'          => 'Front Page Header Section Panel',
        'description'    => 'Add information to Header Section',
    ) );


    $wp_customize->add_section( 'header_slider_section_id', array(
        'title' => __( 'Header Slider' ),
        'description' => __( 'Add information to Header Image Slider' ),
        'panel' => 'header_slider_panel_id', // Not typically needed.
        'priority' => 10,
        'capability' => 'edit_theme_options',
      ) );

/* <======Slider Image No 1 ==========> */

      $wp_customize->add_setting( 'header_slider_1_title_setting_id', array(
        'type' => 'theme_mod', // or 'option'
        'capability' => 'edit_theme_options',
        'default' => 'Add A Image Slider Title',
        'transport' => 'refresh', // or postMessage
        'sanitize_callback' => 'sanitize_text_field',

      ) );   


      $wp_customize->add_control( 'header_slider_1_title_setting_id', array(
        'type' => 'text',
        'priority' => 10,
        'section' => 'header_slider_section_id',
        'label' => 'Image Slider Title No.1' ,
        'description' => 'Add a Image slider Title',
      ) );

      $wp_customize->add_setting( 'header_slider_1_sub_title_setting_id', array(
        'type' => 'theme_mod', // or 'option'
        'capability' => 'edit_theme_options',
        'default' => 'Add A Image Slider Sub Title',
        'transport' => 'refresh', // or postMessage
        'sanitize_callback' => 'sanitize_text_field',

      ) );   

      $wp_customize->add_control( 'header_slider_1_sub_title_setting_id', array(
        'type' => 'text',
        'priority' => 20,
        'section' => 'header_slider_section_id',
        'label' => 'Image Slider Sub Title No.1',
        'description' => 'Add a Image slider Sub Title',
      ) );


      $wp_customize->add_setting( 'header_slider_1_image_setting_id', array(
        'type' => 'theme_mod', // or 'option'
        'capability' => 'edit_theme_options',
        'default' => '',
        'transport' => 'refresh', // or postMessage

      ) );   

      $wp_customize->add_control( new WP_Customize_Media_Control( $wp_customize, 'header_slider_1_image_setting_id', array(
        'label' => __( 'Slider Image No 1' ),
        'section' => 'header_slider_section_id',
        'mime_type' => 'image',
        'priority' => 30,
      ) ) );



/* <======Slider Image No 2 ==========> */

      $wp_customize->add_setting( 'header_slider_2_title_setting_id', array(
        'type' => 'theme_mod', // or 'option'
        'capability' => 'edit_theme_options',
        'default' => 'Add A Image Slider Title 2',
        'transport' => 'refresh', // or postMessage
        'sanitize_callback' => 'sanitize_text_field',

      ) );   


      $wp_customize->add_control( 'header_slider_2_title_setting_id', array(
        'type' => 'text',
        'priority' => 40,
        'section' => 'header_slider_section_id',
        'label' => __( 'Image Slider Title No.2' ),
        'description' => __( 'Add a Image slider Title 2' ),
      ) );

      $wp_customize->add_setting( 'header_slider_2_sub_title_setting_id', array(
        'type' => 'theme_mod', // or 'option'
        'capability' => 'edit_theme_options',
        'default' => 'Add A Image Slider Sub Title 2',
        'transport' => 'refresh', // or postMessage
        'sanitize_callback' => 'sanitize_text_field',

      ) );   

      $wp_customize->add_control( 'header_slider_2_sub_title_setting_id', array(
        'type' => 'text',
        'priority' => 50,
        'section' => 'header_slider_section_id',
        'label' => __( 'Image Slider Sub Title No.2' ),
        'description' => __( 'Add a Image slider Sub Title 2' ),
      ) );


      $wp_customize->add_setting( 'header_slider_2_image_setting_id', array(
        'type' => 'theme_mod', // or 'option'
        'capability' => 'edit_theme_options',
        'default' => '',
        'transport' => 'refresh', // or postMessage

      ) );   

      $wp_customize->add_control( new WP_Customize_Media_Control( $wp_customize, 'header_slider_2_image_setting_id', array(
        'label' => __( 'Slider Image No 2' ),
        'section' => 'header_slider_section_id',
        'mime_type' => 'image',
        'priority' => 60,
      ) ) );



/* <======Slider Image No 3 ==========> */

    $wp_customize->add_setting( 'header_slider_3_title_setting_id', array(
      'type' => 'theme_mod', // or 'option'
      'capability' => 'edit_theme_options',
      'default' => 'Add A Image Slider Title 3',
      'transport' => 'refresh', // or postMessage
      'sanitize_callback' => 'sanitize_text_field',

    ) );   


    $wp_customize->add_control( 'header_slider_3_title_setting_id', array(
      'type' => 'text',
      'priority' => 70,
      'section' => 'header_slider_section_id',
      'label' => __( 'Image Slider Title No.3' ),
      'description' => __( 'Add a Image slider Title 3' ),
    ) );

    $wp_customize->add_setting( 'header_slider_3_sub_title_setting_id', array(
      'type' => 'theme_mod', // or 'option'
      'capability' => 'edit_theme_options',
      'default' => 'Add A Image Slider Sub Title 3',
      'transport' => 'refresh', // or postMessage
      'sanitize_callback' => 'sanitize_text_field',

    ) );   

    $wp_customize->add_control( 'header_slider_3_sub_title_setting_id', array(
      'type' => 'text',
      'priority' => 80,
      'section' => 'header_slider_section_id',
      'label' => __( 'Image Slider Sub Title No.3' ),
      'description' => __( 'Add a Image slider Sub Title 3' ),
    ) );


    $wp_customize->add_setting( 'header_slider_3_image_setting_id', array(
      'type' => 'theme_mod', // or 'option'
      'capability' => 'edit_theme_options',
      'default' => '',
      'transport' => 'refresh', // or postMessage

    ) );   

    $wp_customize->add_control( new WP_Customize_Media_Control( $wp_customize, 'header_slider_3_image_setting_id', array(
      'label' => __( 'Slider Image No 3' ),
      'section' => 'header_slider_section_id',
      'mime_type' => 'image',
      'priority' => 90,
    ) ) );


    $wp_customize->add_setting( 'header_slider_text_color_setting_id', array(
      'type' => 'option',
      'capability' => 'manage_options',
      'default' => '#fff',
      'sanitize_callback' => 'sanitize_hex_color',
    ) );

    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'header_slider_text_color_setting_id', array(
      'label' => __( 'Change Text color' ),
      'section' => 'header_slider_section_id',
      'priority' => 95,
    ) ) );



    /* <======Header Top Message ==========> */

    $wp_customize->add_section( 'header_top_message_section_id', array(
      'title' => __( 'Header Top Message' ),
      'description' => __( 'Add information to Header Top Message' ),
      'panel' => 'header_slider_panel_id', // Not typically needed.
      'priority' => 20,
      'capability' => 'edit_theme_options',
    ) );


    $wp_customize->add_setting( 'header_top_message_setting_id', array(
      'type' => 'theme_mod', // or 'option'
      'capability' => 'edit_theme_options',
      'default' => 'Add A Top message',
      'transport' => 'refresh', // or postMessage
      'sanitize_callback' => 'sanitize_text_field',

    ) );   


    $wp_customize->add_control( 'header_top_message_setting_id', array(
      'type' => 'text',
      'priority' => 10,
      'section' => 'header_top_message_section_id',
      'label' => 'Top Mesage Text' ,
      'description' => 'Add a Top Mesage Text',
    ) );

    $wp_customize->add_setting( 'header_top_message_bg_color_setting_id', array(
      'type' => 'option',
      'capability' => 'manage_options',
      'default' => '#3f7059',
      'sanitize_callback' => 'sanitize_hex_color',
    ) );

  $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'header_top_message_bg_color_setting_id', array(
      'label' => __( 'Top Message Background Color' ),
      'section' => 'header_top_message_section_id',
      'priority' => 20,
    ) ) );

    $wp_customize->add_setting( 'header_top_message_color_setting_id', array(
      'type' => 'option',
      'capability' => 'manage_options',
      'default' => '#fff',
      'sanitize_callback' => 'sanitize_hex_color',
    ) );

  $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'header_top_message_color_setting_id', array(
      'label' => __( 'Top Message Background Color' ),
      'section' => 'header_top_message_section_id',
      'priority' => 30,
    ) ) );



}
