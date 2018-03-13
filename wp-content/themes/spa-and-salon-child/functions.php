<?php
//* Code goes here
add_action( 'wp_enqueue_scripts', 'enqueue_parent_styles' );

function enqueue_parent_styles() {
   wp_enqueue_style( 'parent-style', get_template_directory_uri().'/style.css' );
  wp_enqueue_style( 'font-awesome', get_template_directory_uri() . '/css/font-awesome.css' );
    wp_enqueue_style( 'flexslider', get_template_directory_uri() . '/css/flexslider.css' );
    wp_enqueue_style( 'meanmenu', get_template_directory_uri().'/css/meanmenu.css' );
    wp_enqueue_style( 'mcustomscrollbar', get_template_directory_uri().'/css/jquery.mCustomScrollbar.css' );
	wp_enqueue_style( 'spa-and-salon-google-fonts', add_query_arg( $query_args, "//fonts.googleapis.com/css" ) );
	wp_enqueue_style( 'spa-and-salon-style', get_stylesheet_uri(), array(), SPA_AND_SALON_THEME_VERSION );

}
