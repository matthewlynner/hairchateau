<?php
/**
 * Spa and Salon Theme Customizer.
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Spa_and_Salon
 */


/**
 * Add postMessage support for site title and description for the Theme Customizer.F
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function spa_and_salon_customize_register( $wp_customize ) {

    if ( version_compare( get_bloginfo('version'),'4.9', '>=') ) {
        $wp_customize->get_section( 'static_front_page' )->title = __( 'Static Front Page', 'spa-and-salon' );
    }
	
    /* Option list of all post */	
    $spa_and_salon_options_posts = array();
    $spa_and_salon_options_posts_obj = get_posts('posts_per_page=-1');
    $spa_and_salon_options_posts[''] = esc_html__( 'Choose Post', 'spa-and-salon' );
    foreach ( $spa_and_salon_options_posts_obj as $spa_and_salon_posts ) {
    	$spa_and_salon_options_posts[$spa_and_salon_posts->ID] = $spa_and_salon_posts->post_title;
    }
    
    /* Option list of all categories */
    $spa_and_salon_args = array(
	   'type'                     => 'post',
	   'orderby'                  => 'name',
	   'order'                    => 'ASC',
	   'hide_empty'               => 1,
	   'hierarchical'             => 1,
	   'taxonomy'                 => 'category'
    ); 
    $spa_and_salon_option_categories = array();
    $spa_and_salon_category_lists = get_categories( $spa_and_salon_args );
    $spa_and_salon_option_categories[''] = esc_html__( 'Choose Category', 'spa-and-salon' );
    foreach( $spa_and_salon_category_lists as $spa_and_salon_category ){
        $spa_and_salon_option_categories[$spa_and_salon_category->term_id] = $spa_and_salon_category->name;
    }
    
    /** Default Settings */    
    $wp_customize->add_panel( 
        'wp_default_panel',
         array(
            'priority' => 10,
            'capability' => 'edit_theme_options',
            'theme_supports' => '',
            'title' => esc_html__( 'Default Settings', 'spa-and-salon' ),
            'description' => esc_html__( 'Default section provided by wordpress customizer.', 'spa-and-salon' ),
        ) 
    );
    
    $wp_customize->get_section( 'title_tagline' )->panel     = 'wp_default_panel';
    $wp_customize->get_section( 'colors' )->panel            = 'wp_default_panel';
    $wp_customize->get_section( 'header_image' )->panel      = 'wp_default_panel';
    $wp_customize->get_section( 'background_image' )->panel  = 'wp_default_panel';
    $wp_customize->get_section( 'static_front_page' )->panel = 'wp_default_panel'; 
    
    $wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';
    
    /** Default Settings Ends */

    /** Home Page Settings */
    $wp_customize->add_panel( 
        'spa_and_salon_home_page_settings',
         array(
            'priority' => 30,
            'capability' => 'edit_theme_options',
            'title' => esc_html__( 'Home Page Settings', 'spa-and-salon' ),
            'description' => esc_html__( 'Customize Home Page Settings', 'spa-and-salon' ),
        ) 
    );
    
    /** Banner Section */
    $wp_customize->add_section(
        'spa_and_salon_banner_settings',
        array(
            'title' => esc_html__( 'Banner Section', 'spa-and-salon' ),
            'priority' => 10,
            'panel' => 'spa_and_salon_home_page_settings',
        )
    );
        
    /** Enable/Disable Banner Section */
    $wp_customize->add_setting(
        'spa_and_salon_ed_banner_section',
        array(
            'default' => '',
            'sanitize_callback' => 'spa_and_salon_sanitize_checkbox',
        )
    );
    
    $wp_customize->add_control(
        'spa_and_salon_ed_banner_section',
        array(
            'label' => esc_html__( 'Enable Banner Section', 'spa-and-salon' ),
            'section' => 'spa_and_salon_banner_settings',
            'type' => 'checkbox',
        )
    );
    
    /** Banner Post */
    $wp_customize->add_setting(
        'spa_and_salon_banner_post',
        array(
            'default' => '',
            'sanitize_callback' => 'spa_and_salon_sanitize_select',
        )
    );
    
    $wp_customize->add_control(
        'spa_and_salon_banner_post',
        array(
            'label' => esc_html__( 'Select Banner Post', 'spa-and-salon' ),
            'section' => 'spa_and_salon_banner_settings',
            'type' => 'select',
            'choices' => $spa_and_salon_options_posts,
        )
    );
    
    /** Read More Text */
    $wp_customize->add_setting(
        'spa_and_salon_banner_read_more',
        array(
            'default' =>  esc_html__( 'Get Started', 'spa-and-salon' ),
            'sanitize_callback' => 'spa_and_salon_sanitize_nohtml',
        )
    );
    
    $wp_customize->add_control(
        'spa_and_salon_banner_read_more',
        array(
            'label' => esc_html__( 'Read More Text', 'spa-and-salon' ),
            'section' => 'spa_and_salon_banner_settings',
            'type' => 'text',
        )
    );
    /** Banner Section Ends */
    
    /** Featured Section */
    $wp_customize->add_section(
        'spa_and_salon_featured_settings',
        array(
            'title' => esc_html__( 'Featured Section', 'spa-and-salon' ),
            'priority' => 20,
            'panel' => 'spa_and_salon_home_page_settings',
        )
    );
    
    /** Enable/Disable Featured Section */
    $wp_customize->add_setting(
        'spa_and_salon_ed_featured_section',
        array(
            'default' => '',
            'sanitize_callback' => 'spa_and_salon_sanitize_checkbox',
        )
    );
    
    $wp_customize->add_control(
        'spa_and_salon_ed_featured_section',
        array(
            'label' => esc_html__( 'Enable Featured Posts Section', 'spa-and-salon' ),
            'section' => 'spa_and_salon_featured_settings',
            'type' => 'checkbox',
        )
    );
    
    /** Featured Post One */
    $wp_customize->add_setting(
        'spa_and_salon_featured_post_one',
        array(
            'default' => '',
            'sanitize_callback' => 'spa_and_salon_sanitize_select',
        )
    );
    
    $wp_customize->add_control(
        'spa_and_salon_featured_post_one',
        array(
            'label' => esc_html__( 'Select Featured Post One', 'spa-and-salon' ),
            'section' => 'spa_and_salon_featured_settings',
            'type' => 'select',
            'choices' => $spa_and_salon_options_posts,
        )
    );

    
    /** Favicon for post one */
    $wp_customize->add_setting(
        'spa_and_salon_favicon-one',
        array(
            'default' => esc_html__( 'money', 'spa-and-salon' ),
            'sanitize_callback' => 'spa_and_salon_sanitize_nohtml',
        )
    );

    $wp_customize->add_control(
        'spa_and_salon_favicon-one',
        array(
            'label' => esc_html__( 'Favicon Name For Post One', 'spa-and-salon' ),
            'section' => 'spa_and_salon_featured_settings',
            'type' => 'text',
        )
    );
    
    /** Featured Post Two */
    $wp_customize->add_setting(
        'spa_and_salon_featured_post_two',
        array(
            'default' => '',
            'sanitize_callback' => 'spa_and_salon_sanitize_select',
        )
    );
    
    $wp_customize->add_control(
        'spa_and_salon_featured_post_two',
        array(
            'label' => esc_html__( 'Select Featured Post Two', 'spa-and-salon' ),
            'section' => 'spa_and_salon_featured_settings',
            'type' => 'select',
            'choices' => $spa_and_salon_options_posts,
        )
    );
    

    /** Favicon for post Two */
    $wp_customize->add_setting(
        'spa_and_salon_favicon-two',
        array(
            'default' => esc_html__( 'thumbs-up', 'spa-and-salon' ),
            'sanitize_callback' => 'spa_and_salon_sanitize_nohtml',
        )
    );

    $wp_customize->add_control(
        'spa_and_salon_favicon-two',
        array(
            'label' => esc_html__( 'Favicon Name For Post Two', 'spa-and-salon' ),
            'section' => 'spa_and_salon_featured_settings',
            'type' => 'text',
        )
    );
    
    /** Featured Post Three */
    $wp_customize->add_setting(
        'spa_and_salon_featured_post_three',
        array(
            'default' => '',
            'sanitize_callback' => 'spa_and_salon_sanitize_select',
        )
    );
    
    $wp_customize->add_control(
        'spa_and_salon_featured_post_three',
        array(
            'label' => esc_html__( 'Select Featured Post Three', 'spa-and-salon' ),
            'section' => 'spa_and_salon_featured_settings',
            'type' => 'select',
            'choices' => $spa_and_salon_options_posts,
        )
    );
    
    /** Favicon for post three */
    $wp_customize->add_setting(
        'spa_and_salon_favicon-three',
        array(
            'default' => esc_html__( 'shopping-cart', 'spa-and-salon' ),
            'sanitize_callback' => 'spa_and_salon_sanitize_nohtml',
        )
    );

    $wp_customize->add_control(
        'spa_and_salon_favicon-three',
        array(
            'label' => esc_html__( 'Favicon Name For Post Three', 'spa-and-salon' ),
            'section' => 'spa_and_salon_featured_settings',
            'type' => 'text',
        )
    );
    
    /** Featured Section Ends */
    
    /** About Section */
   
    $wp_customize->add_section(
        'spa_and_salon_about_settings',
        array(
            'title' => esc_html__( 'About Section', 'spa-and-salon' ),
            'priority' => 30,
            'panel' => 'spa_and_salon_home_page_settings',
        )
    );
        
    /** Enable/Disable About Note Section */
    $wp_customize->add_setting(
        'spa_and_salon_ed_about_section',
        array(
            'default' => '',
            'sanitize_callback' => 'spa_and_salon_sanitize_checkbox',
        )
    );
    
    $wp_customize->add_control(
        'spa_and_salon_ed_about_section',
        array(
            'label' => esc_html__( 'Enable About Section', 'spa-and-salon' ),
            'section' => 'spa_and_salon_about_settings',
            'type' => 'checkbox',
        )
    );
    
    /** About Section Post */
    $wp_customize->add_setting(
        'spa_and_salon_about_post',
        array(
            'default' => '',
            'sanitize_callback' => 'spa_and_salon_sanitize_select',
        )
    );
    
    $wp_customize->add_control(
        'spa_and_salon_about_post',
        array(
            'label' => esc_html__( 'Select About Section Post', 'spa-and-salon' ),
            'section' => 'spa_and_salon_about_settings',
            'type' => 'select',
            'choices' => $spa_and_salon_options_posts,
        )
    );
    
    /** Read More Text */
    $wp_customize->add_setting(
        'spa_and_salon_about_read_more',
        array(
            'default' => esc_html__( 'Read More', 'spa-and-salon' ),
            'sanitize_callback' => 'spa_and_salon_sanitize_nohtml',
        )
    );
    
    $wp_customize->add_control(
        'spa_and_salon_about_read_more',
        array(
            'label' => esc_html__( 'Read More Text', 'spa-and-salon' ),
            'section' => 'spa_and_salon_about_settings',
            'type' => 'text',
        )
    );

    /** About Section Ends */

    /** Service Section */
    $wp_customize->add_section(
        'spa_and_salon_service_settings',
        array(
            'title' => esc_html__( 'Service Section', 'spa-and-salon' ),
            'priority' => 40,
            'panel' => 'spa_and_salon_home_page_settings',
        )
    );
    
    /** Enable/Disable Service Section */
    $wp_customize->add_setting(
        'spa_and_salon_ed_service_section',
        array(
            'default' => '',
            'sanitize_callback' => 'spa_and_salon_sanitize_checkbox',
        )
    );
    
    $wp_customize->add_control(
        'spa_and_salon_ed_service_section',
        array(
            'label' => esc_html__( 'Enable Service Section', 'spa-and-salon' ),
            'section' => 'spa_and_salon_service_settings',
            'type' => 'checkbox',
        )
    );
    
    /** Service Section Title */
    $wp_customize->add_setting(
        'spa_and_salon_service_post_title',
        array(
            'default' => esc_html__( 'Our Services', 'spa-and-salon' ),
            'sanitize_callback' => 'spa_and_salon_sanitize_nohtml',
        )
    );
    
    $wp_customize->add_control(
        'spa_and_salon_service_post_title',
        array(
            'label' => esc_html__( 'Service Section Title', 'spa-and-salon' ),
            'section' => 'spa_and_salon_service_settings',
            'type' => 'text',
        )
    );
    
    /** Service Section Content */
    $wp_customize->add_setting(
        'spa_and_salon_service_post_content',
        array(
            'default' => '',
            'sanitize_callback' => 'spa_and_salon_sanitize_html',
        )
    );
    
    $wp_customize->add_control(
        'spa_and_salon_service_post_content',
        array(
            'label' => esc_html__( 'Service Section Content', 'spa-and-salon' ),
            'section' => 'spa_and_salon_service_settings',
            'type' => 'textarea',
        )
    );
    /** Service Post One */
    $wp_customize->add_setting(
        'spa_and_salon_service_post_one',
        array(
            'default' => '',
            'sanitize_callback' => 'spa_and_salon_sanitize_select',
        )
    );
    
    $wp_customize->add_control(
        'spa_and_salon_service_post_one',
        array(
            'label' => esc_html__( 'Select Service Post One', 'spa-and-salon' ),
            'section' => 'spa_and_salon_service_settings',
            'type' => 'select',
            'choices' => $spa_and_salon_options_posts,
        )
    );
    
    /** Service Post Two */
    $wp_customize->add_setting(
        'spa_and_salon_service_post_two',
        array(
            'default' => '',
            'sanitize_callback' => 'spa_and_salon_sanitize_select',
        )
    );
    
    $wp_customize->add_control(
        'spa_and_salon_service_post_two',
        array(
            'label' => esc_html__( 'Select Service Post Two', 'spa-and-salon' ),
            'section' => 'spa_and_salon_service_settings',
            'type' => 'select',
            'choices' => $spa_and_salon_options_posts,
        )
    );

    /** Service Post Three */
    $wp_customize->add_setting(
        'spa_and_salon_service_post_three',
        array(
            'default' => '',
            'sanitize_callback' => 'spa_and_salon_sanitize_select',
        )
    );
    
    $wp_customize->add_control(
        'spa_and_salon_service_post_three',
        array(
            'label' => esc_html__( 'Select Service Post Three', 'spa-and-salon' ),
            'section' => 'spa_and_salon_service_settings',
            'type' => 'select',
            'choices' => $spa_and_salon_options_posts,
        )
    );

    /** Service Post Four */
    $wp_customize->add_setting(
        'spa_and_salon_service_post_four',
        array(
            'default' => '',
            'sanitize_callback' => 'spa_and_salon_sanitize_select',
        )
    );
    
    $wp_customize->add_control(
        'spa_and_salon_service_post_four',
        array(
            'label' => esc_html__( 'Select Service Post Four', 'spa-and-salon' ),
            'section' => 'spa_and_salon_service_settings',
            'type' => 'select',
            'choices' => $spa_and_salon_options_posts,
        )
    );

    /** Service Post Five */
    $wp_customize->add_setting(
        'spa_and_salon_service_post_five',
        array(
            'default' => '',
            'sanitize_callback' => 'spa_and_salon_sanitize_select',
        )
    );
    
    $wp_customize->add_control(
        'spa_and_salon_service_post_five',
        array(
            'label' => esc_html__( 'Select Service Post Five', 'spa-and-salon' ),
            'section' => 'spa_and_salon_service_settings',
            'type' => 'select',
            'choices' => $spa_and_salon_options_posts,
        )
    );

    /** Service Post Six */
    $wp_customize->add_setting(
        'spa_and_salon_service_post_six',
        array(
            'default' => '',
            'sanitize_callback' => 'spa_and_salon_sanitize_select',
        )
    );
    
    $wp_customize->add_control(
        'spa_and_salon_service_post_six',
        array(
            'label' => esc_html__( 'Select Service Post Six', 'spa-and-salon' ),
            'section' => 'spa_and_salon_service_settings',
            'type' => 'select',
            'choices' => $spa_and_salon_options_posts,
        )
    );

    /** Service Section Ends */
    
    /** Testimonials Section */

    $wp_customize->add_section(
        'spa_and_salon_testimonial_settings',
        array(
            'title' => esc_html__( 'Testimonial Section', 'spa-and-salon' ),
            'priority' => 50,
            'panel' => 'spa_and_salon_home_page_settings',
        )
    );
    
    /** Enable/Disable Testimonial Section */
    $wp_customize->add_setting(
        'spa_and_salon_ed_testimonial_section',
        array(
            'default' => '',
            'sanitize_callback' => 'spa_and_salon_sanitize_checkbox',
        )
    );
    
    $wp_customize->add_control(
        'spa_and_salon_ed_testimonial_section',
        array(
            'label' => esc_html__( 'Enable Testimonial Section', 'spa-and-salon' ),
            'section' => 'spa_and_salon_testimonial_settings',
            'type' => 'checkbox',
        )
    );
    
    /** Testimonial Section Title */
    $wp_customize->add_setting(
        'spa_and_salon_testimonial_section_title',
        array(
            'default' => esc_html__( 'Client Testimonials', 'spa-and-salon' ),
            'sanitize_callback' => 'spa_and_salon_sanitize_nohtml',
        )
    );
    
    $wp_customize->add_control(
        'spa_and_salon_testimonial_section_title',
        array(
            'label' => esc_html__( 'Testimonial Section Title', 'spa-and-salon' ),
            'section' => 'spa_and_salon_testimonial_settings',
            'type' => 'text',
        )
    );
    
    /** Testimonial Section Content */
    $wp_customize->add_setting(
        'spa_and_salon_testimonial_section_content',
        array(
            'default' => '',
            'sanitize_callback' => 'spa_and_salon_sanitize_html',
        )
    );
    
    $wp_customize->add_control(
        'spa_and_salon_testimonial_section_content',
        array(
            'label' => esc_html__( 'Testimonial Section Content', 'spa-and-salon' ),
            'section' => 'spa_and_salon_testimonial_settings',
            'type' => 'textarea',
        )
    );
    
    /** Select Category */
    $wp_customize->add_setting(
        'spa_and_salon_testimonial_section_cat',
        array(
            'default' => '',
            'sanitize_callback' => 'spa_and_salon_sanitize_select',
        )
    );
    
    $wp_customize->add_control(
        'spa_and_salon_testimonial_section_cat',
        array(
            'label' => esc_html__( 'Select Category', 'spa-and-salon' ),
            'section' => 'spa_and_salon_testimonial_settings',
            'type' => 'select',
            'choices' => $spa_and_salon_option_categories,
        )
    );
    /** Testimonial Section Ends */
    
    /** Home Page Settings Ends */

    /** BreadCrumb Settings */
    $wp_customize->add_section(
        'spa_and_salon_breadcrumb_settings',
        array(
            'title' => esc_html__( 'Breadcrumb Settings', 'spa-and-salon' ),
            'priority' => 50,
            'capability' => 'edit_theme_options',
        )
    );
    
    /** Enable/Disable BreadCrumb */
    $wp_customize->add_setting(
        'spa_and_salon_ed_breadcrumb',
        array(
            'default' => '',
            'sanitize_callback' => 'spa_and_salon_sanitize_checkbox',
        )
    );
    
    $wp_customize->add_control(
        'spa_and_salon_ed_breadcrumb',
        array(
            'label' => esc_html__( 'Enable Breadcrumb', 'spa-and-salon' ),
            'section' => 'spa_and_salon_breadcrumb_settings',
            'type' => 'checkbox',
        )
    );
    
    /** Show/Hide Current */
    $wp_customize->add_setting(
        'spa_and_salon_ed_current',
        array(
            'default' => '1',
            'sanitize_callback' => 'spa_and_salon_sanitize_checkbox',
        )
    );
    
    $wp_customize->add_control(
        'spa_and_salon_ed_current',
        array(
            'label' => esc_html__( 'Show current', 'spa-and-salon' ),
            'section' => 'spa_and_salon_breadcrumb_settings',
            'type' => 'checkbox',
        )
    );
    
    /** Home Text */
    $wp_customize->add_setting(
        'spa_and_salon_breadcrumb_home_text',
        array(
            'default' => esc_html__( 'Home', 'spa-and-salon' ),
            'sanitize_callback' => 'spa_and_salon_sanitize_nohtml',
        )
    );
    
    $wp_customize->add_control(
        'spa_and_salon_breadcrumb_home_text',
        array(
            'label' => esc_html__( 'Breadcrumb Home Text', 'spa-and-salon' ),
            'section' => 'spa_and_salon_breadcrumb_settings',
            'type' => 'text',
        )
    );
    
    /** Breadcrumb Separator */
    $wp_customize->add_setting(
        'spa_and_salon_breadcrumb_separator',
        array(
            'default' => esc_html__( '>', 'spa-and-salon' ),
            'sanitize_callback' => 'spa_and_salon_sanitize_nohtml',
        )
    );
    
    $wp_customize->add_control(
        'spa_and_salon_breadcrumb_separator',
        array(
            'label' => esc_html__( 'Breadcrumb Separator', 'spa-and-salon' ),
            'section' => 'spa_and_salon_breadcrumb_settings',
            'type' => 'text',
        )
    );
    /** BreadCrumb Settings Ends */
    
    /** Social Settings */
    $wp_customize->add_section(
        'spa_and_salon_social_settings',
        array(
            'title' => esc_html__( 'Social Settings', 'spa-and-salon' ),
            'priority' => 30,
            'capability' => 'edit_theme_options',
        )
    );
    
    /** Enable/Disable Slider Caption */
    $wp_customize->add_setting(
        'spa_and_salon_social_ed_header',
        array(
            'default' => '',
            'sanitize_callback' => 'spa_and_salon_sanitize_checkbox',
        )
    );
    
    $wp_customize->add_control(
        'spa_and_salon_social_ed_header',
        array(
            'label' => esc_html__( 'Enable Social Links on Header', 'spa-and-salon' ),
            'section' => 'spa_and_salon_social_settings',
            'type' => 'checkbox',
        )
    );

    /** Enable/Disable Slider Caption */
    $wp_customize->add_setting(
        'spa_and_salon_social_ed_footer',
        array(
            'default' => '',
            'sanitize_callback' => 'spa_and_salon_sanitize_checkbox',
        )
    );
    
    $wp_customize->add_control(
        'spa_and_salon_social_ed_footer',
        array(
            'label' => esc_html__( 'Enable Social Links On Footer', 'spa-and-salon' ),
            'section' => 'spa_and_salon_social_settings',
            'type' => 'checkbox',
        )
    );

    /**  Footer Info For Social Setting */
    $wp_customize->add_setting(
        'spa_and_salon_social_info',
        array( 
            'default' => esc_html__( 'Follow Us On', 'spa-and-salon' ),
            'sanitize_callback' => 'spa_and_salon_sanitize_nohtml',
        )
    );
    
    $wp_customize->add_control(
        'spa_and_salon_social_info',
        array(
            'label' => esc_html__( 'Social Info In Footer', 'spa-and-salon' ),
            'section' => 'spa_and_salon_social_settings',
            'type' => 'text',
        )
    );


    /** Facebook Button Url */
    $wp_customize->add_setting(
        'spa_and_salon_button_url_fb',
        array( 
            'default' => '',
            'sanitize_callback' => 'spa_and_salon_sanitize_url',
        )
    );
    
    $wp_customize->add_control(
        'spa_and_salon_button_url_fb',
        array(
            'label' => esc_html__( 'Facebook Page Url', 'spa-and-salon' ),
            'section' => 'spa_and_salon_social_settings',
            'type' => 'text',
        )
    );
        /** Twiter Button Url */
    $wp_customize->add_setting(
        'spa_and_salon_button_url_tw',
        array( 
            'default' => '',
            'sanitize_callback' => 'spa_and_salon_sanitize_url',
        )
    );
    
    $wp_customize->add_control(
        'spa_and_salon_button_url_tw',
        array(
            'label' => esc_html__( 'Twitter Page Url', 'spa-and-salon' ),
            'section' => 'spa_and_salon_social_settings',
            'type' => 'text',
        )
    );
        /** Linkin Button Url */
    $wp_customize->add_setting(
        'spa_and_salon_button_url_ln',
        array( 
            'default' => '',
            'sanitize_callback' => 'spa_and_salon_sanitize_url',
        )
    );
    
    $wp_customize->add_control(
        'spa_and_salon_button_url_ln',
        array(
            'label' => esc_html__( 'Linkin Page Url', 'spa-and-salon' ),
            'section' => 'spa_and_salon_social_settings',
            'type' => 'text',
        )
    );
    
    /** Rss Button Url */
    $wp_customize->add_setting(
        'spa_and_salon_button_url_rss',
        array( 
            'default' => '',
            'sanitize_callback' => 'spa_and_salon_sanitize_url',
        )
    );
    
    $wp_customize->add_control(
        'spa_and_salon_button_url_rss',
        array(
            'label' => esc_html__( 'Rss Feed Url', 'spa-and-salon' ),
            'section' => 'spa_and_salon_social_settings',
            'type' => 'text',
        )
    );

    /**  Google Plus Button Url */
    $wp_customize->add_setting(
        'spa_and_salon_button_url_gp',
        array( 
            'default' => '',
            'sanitize_callback' => 'spa_and_salon_sanitize_url',
        )
    );
    
    $wp_customize->add_control(
        'spa_and_salon_button_url_gp',
        array(
            'label' => esc_html__( 'Google Plus Url', 'spa-and-salon' ),
            'section' => 'spa_and_salon_social_settings',
            'type' => 'text',
        )
    );

    /**  Pinterest Button Url */
    $wp_customize->add_setting(
        'spa_and_salon_button_url_pi',
        array( 
            'default' => '',
            'sanitize_callback' => 'spa_and_salon_sanitize_url',
        )
    );
    
    $wp_customize->add_control(
        'spa_and_salon_button_url_pi',
        array(
            'label' => esc_html__( 'Pinterest Url', 'spa-and-salon' ),
            'section' => 'spa_and_salon_social_settings',
            'type' => 'text',
        )
    );
    /**  Instagram Button Url */
    $wp_customize->add_setting(
        'spa_and_salon_button_url_is',
        array( 
            'default' => '',
            'sanitize_callback' => 'spa_and_salon_sanitize_url',
        )
    );
    
    $wp_customize->add_control(
        'spa_and_salon_button_url_is',
        array(
            'label' => esc_html__( 'Instagram Url', 'spa-and-salon' ),
            'section' => 'spa_and_salon_social_settings',
            'type' => 'text',
        )
    );

    /** Social Settings Ends */

    /** Header Section Settings */
    $wp_customize->add_section(
        'spa_and_salon_header_section_settings',
        array(
            'title' => esc_html__( 'Header Section Settings', 'spa-and-salon' ),
            'priority' => 30,
            'capability' => 'edit_theme_options',
        )
    );


    /**  Phone Number */
    $wp_customize->add_setting(
        'spa_and_salon_ph',
        array( 
            'default' => esc_html__( '01-234566789', 'spa-and-salon' ),
            'sanitize_callback' => 'spa_and_salon_sanitize_nohtml',
        )
    );
    
    $wp_customize->add_control(
        'spa_and_salon_ph',
        array(
            'label' => esc_html__( 'Phone Number', 'spa-and-salon' ),
            'section' => 'spa_and_salon_header_section_settings',
            'type' => 'text',
        )
    );

    /** Footer Section */
    $wp_customize->add_section(
        'spa_and_salon_footer_section',
        array(
            'title' => __( 'Footer Settings', 'spa-and-salon' ),
            'priority' => 70,
        )
    );
    
    /** Copyright Text */
    $wp_customize->add_setting(
        'spa_and_salon_footer_copyright_text',
        array(
            'default' => '',
            'sanitize_callback' => 'wp_kses_post',
        )
    );
    
    $wp_customize->add_control(
        'spa_and_salon_footer_copyright_text',
        array(
            'label' => __( 'Copyright Info', 'spa-and-salon' ),
            'section' => 'spa_and_salon_footer_section',
            'type' => 'textarea',
        )
    );  

    /**
     * Sanitization Functions
     * 
     * @link https://github.com/WPTRT/code-examples/blob/master/customizer/sanitization-callbacks.php 
     */
     function spa_and_salon_sanitize_checkbox( $checked ){
        // Boolean check.
        return ( ( isset( $checked ) && true == $checked ) ? true : false );
     }
     
     function spa_and_salon_sanitize_nohtml( $nohtml ){
        return wp_filter_nohtml_kses( $nohtml );
     }
     
     function spa_and_salon_sanitize_html( $html ){
        return wp_filter_post_kses( $html );
     }
     
     function spa_and_salon_sanitize_select( $input, $setting ){
        // Ensure input is a slug.
    	$input = sanitize_key( $input );
    	
    	// Get list of choices from the control associated with the setting.
    	$choices = $setting->manager->get_control( $setting->id )->choices;
    	
    	// If the input is a valid key, return it; otherwise, return the default.
    	return ( array_key_exists( $input, $choices ) ? $input : $setting->default );
     }
     
     function spa_and_salon_sanitize_url( $url ){
        return esc_url_raw( $url );
     }
     
}
add_action( 'customize_register', 'spa_and_salon_customize_register' );

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function spa_and_salon_customize_preview_js() {
	wp_enqueue_script( 'spa_and_salon_customizer', get_template_directory_uri() . '/js/customizer.js', array( 'customize-preview' ), '20130508', true );
}
add_action( 'customize_preview_init', 'spa_and_salon_customize_preview_js' );
