<?php
/**
 * Custom functions that act independently of the theme templates.
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package Spa_and_Salon
 */

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function spa_and_salon_body_classes( $classes ) {
  global $post;
  
    if( !is_page_template( 'template-home.php' ) ){
        $classes[] = 'inner';
        // Adds a class of group-blog to blogs with more than 1 published author.
    }

	if ( is_multi_author() ) {
		$classes[] = 'group-blog ';
	}

    // Adds a class of custom-background-image to sites with a custom background image.
    if ( get_background_image() ) {
        $classes[] = 'custom-background-image';
    }
    
    // Adds a class of custom-background-color to sites with a custom background color.
    if ( get_background_color() != 'ffffff' ) {
        $classes[] = 'custom-background-color';
    }
    

    if( spa_and_salon_woocommerce_activated() && ( is_shop() || is_product_category() || is_product_tag() || 'product' === get_post_type() ) && ! is_active_sidebar( 'shop-sidebar' ) ){
        $classes[] = 'full-width';
    }    

    // Adds a class of hfeed to non-singular pages.
    if ( ! is_page() ) {
    	$classes[] = 'hfeed ';
    }
  
    if( is_404() ||  is_search() ){
        $classes[] = 'full-width';
    }
  
    if( ! is_active_sidebar( 'right-sidebar' ) ) {
        $classes[] = 'full-width'; 
    }
  
    if( is_page() ){
        $spa_and_salon_post_class = get_post_meta( $post->ID, 'spa_and_salon_sidebar_layout', true );   
        if( $spa_and_salon_post_class == 'no-sidebar' )
        $classes[] = 'full-width';
    }

	return $classes;
}
add_filter( 'body_class', 'spa_and_salon_body_classes' );

 /**
 * 
 * @link http://www.altafweb.com/2011/12/remove-specific-tag-from-php-string.html
 */
function spa_and_salon_strip_single( $tag, $string ){
    $string=preg_replace('/<'.$tag.'[^>]*>/i', '', $string);
    $string=preg_replace('/<\/'.$tag.'>/i', '', $string);
    return $string;
}

if( ! function_exists( 'spa_and_salon_breadcrumbs_cb' ) ):  
/**
 * Custom Bread Crumb
 *
 * @link http://www.qualitytuts.com/wordpress-custom-breadcrumbs-without-plugin/
 */
 
function spa_and_salon_breadcrumbs_cb() {
 
  $showOnHome  = 0; // 1 - show breadcrumbs on the homepage, 0 - don't show
    $delimiter   = get_theme_mod( 'spa_and_salon_breadcrumb_separator', __( '>', 'spa-and-salon' ) ); // delimiter between crumbs
    $home        = get_theme_mod( 'spa_and_salon_breadcrumb_home_text', __( 'Home', 'spa-and-salon' ) ); // text for the 'Home' link
    $showCurrent = get_theme_mod( 'spa_and_salon_ed_current', '1' ); // 1 - show current post/page title in breadcrumbs, 0 - don't show
    $before      = '<span class="current">'; // tag before the current crumb
    $after       = '</span>'; // tag after the current crumb
    
    global $post;
    $homeLink = home_url();
    
    if( get_theme_mod( 'spa_and_salon_ed_breadcrumb' ) ){
        if ( is_front_page() ) {
        
            if ( $showOnHome == 1 ) echo '<div id="crumbs"><a href="' . esc_url( $homeLink ) . '">' . esc_html( $home ) . '</a></div>';
        
        } else {
        
            echo '<div id="crumbs"><a href="' . esc_url( $homeLink ) . '">' . esc_html( $home ) . '</a> <span class="separator">' . esc_html( $delimiter ) . '</span> ';
        
            if ( is_category() ) {
                $thisCat = get_category( get_query_var( 'cat' ), false );
                if ( $thisCat->parent != 0 ) echo get_category_parents( $thisCat->parent, TRUE, ' <span class="separator">' . $delimiter . '</span> ' );
                echo $before .  esc_html( single_cat_title( '', false ) ) . $after;
            
            } elseif ( is_search() ) {
                echo $before . esc_html__( 'Search Results for "', 'spa-and-salon' ) . esc_html( get_search_query() ) . esc_html__( '"', 'spa-and-salon' ) . $after;
            
            } elseif ( is_day() ) {
                echo '<a href="' . esc_url( get_year_link( get_the_time( __( 'Y', 'spa-and-salon' ) ) ) ) . '">' . esc_html( get_the_time( __( 'Y', 'spa-and-salon' ) ) ) . '</a> <span class="separator">' . esc_html( $delimiter ) . '</span> ';
                echo '<a href="' . esc_url( get_month_link( get_the_time( __( 'Y', 'spa-and-salon' ) ), get_the_time( __( 'm', 'spa-and-salon' ) ) ) ) . '">' . esc_html( get_the_time( __( 'F', 'spa-and-salon' ) ) ) . '</a> <span class="separator">' . esc_html( $delimiter ) . '</span> ';
                echo $before . esc_html( get_the_time( __( 'd', 'spa-and-salon' ) ) ) . $after;
            
            } elseif ( is_month() ) {
                echo '<a href="' . esc_url( get_year_link( get_the_time( __( 'Y', 'spa-and-salon' ) ) ) ) . '">' . esc_html( get_the_time( __( 'Y', 'spa-and-salon' ) ) ) . '</a> <span class="separator">' . esc_html( $delimiter ) . '</span> ';
                echo $before . esc_html( get_the_time( __( 'F', 'spa-and-salon' ) ) ) . $after;
            
            } elseif ( is_year() ) {
                echo $before . esc_html( get_the_time( __( 'Y', 'spa-and-salon' ) ) ) . $after;
        
            } elseif ( is_single() && !is_attachment() ) {
                if ( get_post_type() != 'post' ) {
                    $post_type = get_post_type_object(get_post_type());
                    if( $post_type->has_archive == true ){
                        $slug = $post_type->rewrite;
                        echo '<a href="' . esc_url( $homeLink . '/' . $slug['slug'] ) . '/">' . esc_html( $post_type->labels->singular_name ) . '</a> <span class="separator">' . esc_html( $delimiter ) . '</span>';
                    }
                    if ( $showCurrent == 1 ) echo $before . esc_html( get_the_title() ) . $after;
                } else {
                    $cat = get_the_category(); 
                    if( $cat ){
                        $cat = $cat[0];
                        $cats = get_category_parents( $cat, TRUE, ' <span class="separator">' . esc_html( $delimiter ) . '</span> ' );
                        if ( $showCurrent == 0 ) $cats = preg_replace( "#^(.+)\s$delimiter\s$#", "$1", $cats );
                        echo $cats;
                    }
                    if ( $showCurrent == 1 ) echo $before . esc_html( get_the_title() ) . $after;
                }
            
            } elseif ( !is_single() && !is_page() && get_post_type() != 'post' && !is_404() ) {
                $post_type = get_post_type_object(get_post_type());
                echo $before . esc_html( $post_type->labels->singular_name ) . $after;
            
            } elseif ( is_attachment() ) {
                $parent = get_post( $post->post_parent );
                $cat = get_the_category( $parent->ID ); 
                if( $cat ){
                    $cat = $cat[0];
                    echo get_category_parents( $cat, TRUE, ' <span class="separator">' . esc_html( $delimiter ) . '</span> ');
                    echo '<a href="' . esc_url( get_permalink( $parent ) ) . '">' . esc_html( $parent->post_title ) . '</a>' . ' <span class="separator">' . esc_html( $delimiter ) . '</span> ';
                }
                if ( $showCurrent == 1 ) echo  $before . esc_html( get_the_title() ) . $after;
            
            } elseif ( is_page() && !$post->post_parent ) {
                if ( $showCurrent == 1 ) echo $before . esc_html( get_the_title() ) . $after;
        
            } elseif ( is_page() && $post->post_parent ) {
                $parent_id  = $post->post_parent;
                $breadcrumbs = array();
                while( $parent_id ){
                    $page = get_post( $parent_id );
                    $breadcrumbs[] = '<a href="' . esc_url( get_permalink( $page->ID ) ) . '">' . esc_html( get_the_title( $page->ID ) ) . '</a>';
                    $parent_id  = $page->post_parent;
                }
                $breadcrumbs = array_reverse( $breadcrumbs );
                for ( $i = 0; $i < count( $breadcrumbs) ; $i++ ){
                    echo $breadcrumbs[$i];
                    if ( $i != count( $breadcrumbs ) - 1 ) echo ' <span class="separator">' . esc_html( $delimiter ) . '</span> ';
                }
                if ( $showCurrent == 1 ) echo ' <span class="separator">' . esc_html( $delimiter ) . '</span> ' . $before . esc_html( get_the_title() ) . $after;
            
            } elseif ( is_tag() ) {
                echo $before . esc_html( single_tag_title( '', false ) ) . $after;
            
            } elseif ( is_author() ) {
                global $author;
                $userdata = get_userdata( $author );
                echo $before . esc_html( $userdata->display_name ) . $after;
            
            } elseif ( is_404() ) {
                echo $before . esc_html__( '404 Error - Page not Found', 'spa-and-salon' ) . $after;
            } elseif( is_home() ){
                echo $before;
                single_post_title();
                echo $after;
            }
        
            echo '</div>';
        
        }
    }
} // end spa_and_salon_breadcrumbs()

endif; // End function_exists

add_action( 'spa_and_salon_breadcrumbs', 'spa_and_salon_breadcrumbs_cb' );


/** 
 * Hook to move comment text field to the bottom in WP 4.4 
 *
 * @link http://www.wpbeginner.com/wp-tutorials/how-to-move-comment-text-field-to-bottom-in-wordpress-4-4/  
 */
function spa_and_salon_move_comment_field_to_bottom( $fields ) {
    $comment_field = $fields['comment'];
    unset( $fields['comment'] );
    $fields['comment'] = $comment_field;
    return $fields;
}

add_filter( 'comment_form_fields', 'spa_and_salon_move_comment_field_to_bottom' );

if( ! function_exists( 'spa_and_salon_social_link_cb' ) ):

/**Social Links**/
function spa_and_salon_social_link_cb(){

    $spa_and_salon_button_url_fb = get_theme_mod( 'spa_and_salon_button_url_fb');
    $spa_and_salon_button_url_tw = get_theme_mod( 'spa_and_salon_button_url_tw');
    $spa_and_salon_button_url_ln = get_theme_mod( 'spa_and_salon_button_url_ln');
    $spa_and_salon_button_url_rss = get_theme_mod( 'spa_and_salon_button_url_rss');
    $spa_and_salon_button_url_gp = get_theme_mod( 'spa_and_salon_button_url_gp');
    $spa_and_salon_button_url_pi = get_theme_mod( 'spa_and_salon_button_url_pi');
    $spa_and_salon_button_url_is = get_theme_mod( 'spa_and_salon_button_url_is');
    ?>
    <ul class="social-networks">
       <?php if( $spa_and_salon_button_url_fb ){?>
      <li><a href="<?php echo esc_url( $spa_and_salon_button_url_fb ) ?>"><i class="fa fa-facebook"></i></a></li>
      <?php } if( $spa_and_salon_button_url_tw ){?>
      <li><a href="<?php echo esc_url( $spa_and_salon_button_url_tw ) ?>"><i class="fa fa-twitter"></i></a></li>
      <?php } if( $spa_and_salon_button_url_ln ){?>
      <li><a href="<?php echo esc_url( $spa_and_salon_button_url_ln ) ?>"><i class="fa fa-linkedin"></i></a></li>
      <?php } if( $spa_and_salon_button_url_rss ){?>
      <li><a href="<?php echo esc_url( $spa_and_salon_button_url_rss ) ?>"><i class="fa fa-rss"></i></a></li>
      <?php } if( $spa_and_salon_button_url_gp ){?>
      <li><a href="<?php echo esc_url( $spa_and_salon_button_url_gp ) ?>"><i class="fa fa-google-plus"></i></a></li>
      <?php } if( $spa_and_salon_button_url_pi ){?>
      <li><a href="<?php echo esc_url( $spa_and_salon_button_url_pi ) ?>"><i class="fa fa-pinterest-p"></i></a></li>
      <?php } if( $spa_and_salon_button_url_is ){?>
      <li><a href="<?php echo esc_url( $spa_and_salon_button_url_is ) ?>"><i class="fa fa-instagram"></i></a></li>
      <?php } ?>
    </ul>
 <?php } 

 endif;
add_action( 'spa_and_salon_social_link', 'spa_and_salon_social_link_cb' );


if ( ! function_exists( 'spa_and_salon_excerpt_more' ) && ! is_admin() ) :
/**
 * Replaces "[...]" (appended to automatically generated excerpts) with ... * 
 */
function spa_and_salon_excerpt_more() {
  return ' &hellip; ';
}
endif;
add_filter( 'excerpt_more', 'spa_and_salon_excerpt_more' );


if ( ! function_exists( 'spa_and_salon_excerpt_length' ) ) :
/**
 * Changes the default 55 character in excerpt 
*/
function spa_and_salon_excerpt_length( $length ) {
  if( is_page_template('template-home.php') ){
    return 20;
  }else{  return 55;}
}
endif;
add_filter( 'excerpt_length', 'spa_and_salon_excerpt_length', 999 );

if( ! function_exists( 'spa_and_salon_get_sections' ) ):
/** Function to get Sections */
 function spa_and_salon_get_sections(){
    
    $spa_and_salon_sections = array(
        'banner-section' => array(
            'class' => 'banner-section',
            'id' => 'banner'
        ),
        'featured-section' => array(
            'class' => 'promotional-block',
            'id' => 'featured'
        ), 
        'about-section' => array(
            'class' => 'welcome-note',
            'id' => 'about'
        ),
        'service-section' => array(
            'class' => 'services',
            'id' => 'service'
        ),
        'testimonial-section' => array(
            'class' => 'testimonial',
            'id' => 'testimonial'
        )              
    );
    
    $spa_and_salon_enabled_section = array();
    foreach ( $spa_and_salon_sections as $spa_and_salon_section ) {
        
        if ( esc_attr( get_theme_mod( 'spa_and_salon_ed_' . $spa_and_salon_section['id'] . '_section' ) ) == 1 ){
            $spa_and_salon_enabled_section[] = array(
                'id' => $spa_and_salon_section['id'],
                'class' => $spa_and_salon_section['class']
            );
        }
    }
    return $spa_and_salon_enabled_section;
 }

endif;

if( ! function_exists( 'spa_and_salon_banner_cb' ) ):
 /** CallBack function for Banner */
 function spa_and_salon_banner_cb(){
    $spa_and_salon_ed_banner_section = get_theme_mod( 'spa_and_salon_ed_banner_section' );
    $spa_and_salon_banner_post       = get_theme_mod( 'spa_and_salon_banner_post' );
    $spa_and_salon_banner_read_more  = get_theme_mod( 'spa_and_salon_banner_read_more',esc_html__( 'Get Started', 'spa-and-salon' ) );
    $spa_and_salon_enabled_sections  = spa_and_salon_get_sections();

    if( $spa_and_salon_ed_banner_section  &&  true == $spa_and_salon_banner_post ){
        $banner_qry = new WP_Query( array( 'p' => $spa_and_salon_banner_post ) );
        if( $banner_qry->have_posts() ){
            while( $banner_qry->have_posts() ){
                $banner_qry->the_post();
                $categories_list = get_the_category_list( esc_html__( ', ', 'spa-and-salon' ) );
                if( has_post_thumbnail() ){
                    the_post_thumbnail( 'spa-and-salon-banner' );
                    ?>
                    <div class="banner-text">
                        <div class="container">
                            <div class="text">
                                <strong class="title"><?php the_title(); ?></strong>
                                <?php the_excerpt(); ?>
                                <a href="<?php the_permalink(); ?> " class="btn-green"><?php echo esc_html( $spa_and_salon_banner_read_more ); ?>
                                </a>
                            </div>
                        </div>
                    </div>
                    <?php
                    if( $spa_and_salon_enabled_sections ) echo '<div class="arrow-down"></div>';
                }
            }
            wp_reset_postdata();
        }
    }                
}

 endif;
 
 add_action( 'spa_and_salon_banner', 'spa_and_salon_banner_cb' );



if( ! function_exists( 'spa_and_salon_featured_cb' ) ):
/** CallBack function for featured Section */
function spa_and_salon_featured_cb(){
 $spa_and_salon_featured_post_one = get_theme_mod( 'spa_and_salon_featured_post_one' );
 $spa_and_salon_featured_post_two = get_theme_mod( 'spa_and_salon_featured_post_two' );
 $spa_and_salon_featured_post_three = get_theme_mod( 'spa_and_salon_featured_post_three' );
 $spa_and_salon_favicon_one = get_theme_mod( 'spa_and_salon_favicon-one', esc_html__( 'money', 'spa-and-salon' ) );
 $spa_and_salon_favicon_two = get_theme_mod( 'spa_and_salon_favicon-two', esc_html__( 'thumbs-up', 'spa-and-salon' ) );
 $spa_and_salon_favicon_three = get_theme_mod( 'spa_and_salon_favicon-three', esc_html__( 'shopping-cart', 'spa-and-salon' ) );

 ?>
    <div class="container">

      <?php 
        if( $spa_and_salon_featured_post_one && $spa_and_salon_featured_post_two && $spa_and_salon_featured_post_three ){
            
            $spa_and_salon_featured_posts = array( $spa_and_salon_featured_post_one, $spa_and_salon_featured_post_two, $spa_and_salon_featured_post_three );
            $spa_and_salon_featured_posts = array_filter( $spa_and_salon_featured_posts );
            
            $spa_and_salon_favicon = array( $spa_and_salon_favicon_one, $spa_and_salon_favicon_two, $spa_and_salon_favicon_three );
            $spa_and_salon_favicon = array_filter( $spa_and_salon_favicon );
            
            $featured_qry = new WP_Query( array( 
                'post_type'             => 'post',
                'posts_per_page'        => -1,
                'post__in'              => $spa_and_salon_featured_posts,
                'orderby'               => 'post__in',
                'ignore_sticky_posts'   => true
            ) );
            $count = 0;

            if( $featured_qry->have_posts() ){
        ?>
        <div class="row">
          <?php
            while( $featured_qry->have_posts() ){
              $featured_qry->the_post();
          ?>
              <div class="col">
              <?php if( has_post_thumbnail() ){ ?>
                   <div class="img-holder">
                     <?php 
                          echo '<a href="'.  esc_url( get_permalink() )  .'" >';
                            the_post_thumbnail( 'spa-and-salon-featured-block' ); 
                          echo '</a>';

                          if( isset($spa_and_salon_favicon[$count] ) ){ 
                      ?>
                            <div class="icon-holder">
                              <span class="fa fa-<?php echo esc_html( $spa_and_salon_favicon[$count] ); ?>"></span>
                            </div>
                          <?php } ?>
                   </div>
              <?php } ?>
              
                    <div class="text-holder">
                      <strong class="title"><a href="<?php the_permalink(); ?>"><?php the_title();?></a></strong>
                        <?php the_excerpt(); ?>
                          
                    </div>
              </div> 
              <?php
                $count ++;
            }
            wp_reset_postdata(); 
          ?>
        </div>
      <?php }   
        }
      ?>
    </div>
<?php }
 
 endif;
 add_action( 'spa_and_salon_featured', 'spa_and_salon_featured_cb' ); 


/**
 * Footer Credits 
*/
function spa_and_salon_footer_credit(){
    $copyright_text = get_theme_mod( 'spa_and_salon_footer_copyright_text' );

    $text  = '<div class="site-info"><div class="container"><span class="copyright">';
    if( $copyright_text ){
        $text .= wp_kses_post( $copyright_text ); 
    }else{
        $text .= esc_html__( '&copy; ', 'spa-and-salon' ) . date('Y'); 
        $text .= ' <a href="' . esc_url( home_url( '/' ) ) . '">' . esc_html( get_bloginfo( 'name' ) ) . '</a>'. esc_html__( '. All Rights Reserved.', 'spa-and-salon' );
    }
    $text .= '</span>';
    $text .= '<span class="by">' . sprintf( esc_html__( '%s', 'spa-and-salon' ), '<a href="'. esc_url( __( 'http://raratheme.com/wordpress-themes/spa-and-salon/', 'spa-and-salon' ) ) .'" target="_blank">'. esc_html__( 'Spa And Salon By: Rara Theme. ', 'spa-and-salon' ) .'</a>' );
    $text .= sprintf( esc_html__( 'Powered by: %s', 'spa-and-salon' ), '<a href="'. esc_url( __( 'https://wordpress.org/', 'spa-and-salon' ) ) .'" target="_blank">'. esc_html__( 'WordPress', 'spa-and-salon' ) . '</a>' );
    $text .= '</span></div></div>';
    echo apply_filters( 'spa_and_salon_footer_text', $text );    
}
add_action( 'spa_and_salon_footer', 'spa_and_salon_footer_credit' );

/**
 * Return sidebar layouts for pages
*/
function spa_and_salon_sidebar_layout(){
    global $post;
    
    if( get_post_meta( $post->ID, 'spa_and_salon_sidebar_layout', true ) ){
        return get_post_meta( $post->ID, 'spa_and_salon_sidebar_layout', true );    
    }else{
        return 'right-sidebar';
    }
}


/**
 * Is Woocommerce activated
*/
if ( ! function_exists( 'spa_and_salon_woocommerce_activated' ) ) {
  function spa_and_salon_woocommerce_activated() {
    if ( class_exists( 'woocommerce' ) ) { return true; } else { return false; }
  }
}