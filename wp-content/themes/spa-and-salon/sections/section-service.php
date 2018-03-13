<?php
/**
 * Service Section
 * 
 * @package Spa_and_Salon
 */
 
 $spa_and_salon_service_title = get_theme_mod( 'spa_and_salon_service_post_title',esc_html__( 'Our Services', 'spa-and-salon' ) );
 $spa_and_salon_service_content = get_theme_mod( 'spa_and_salon_service_post_content' );
 $spa_and_salon_service_post_one = get_theme_mod( 'spa_and_salon_service_post_one' );
 $spa_and_salon_service_post_two = get_theme_mod( 'spa_and_salon_service_post_two' );
 $spa_and_salon_service_post_three = get_theme_mod( 'spa_and_salon_service_post_three' );
 $spa_and_salon_service_post_four = get_theme_mod( 'spa_and_salon_service_post_four' );
 $spa_and_salon_service_post_five = get_theme_mod( 'spa_and_salon_service_post_five' );
 $spa_and_salon_service_post_six = get_theme_mod( 'spa_and_salon_service_post_six' );
 

 echo '<div class="container">';
 if( $spa_and_salon_service_title || $spa_and_salon_service_content ){
    echo '<header class="header">' ;
        if( $spa_and_salon_service_title ) echo '<h2>' . esc_html( $spa_and_salon_service_title ) . '</h2>';
        if( $spa_and_salon_service_content ) echo wpautop( esc_html( $spa_and_salon_service_content ) ); 
    echo '</header>';
 }
 

 if( $spa_and_salon_service_post_one || $spa_and_salon_service_post_two || $spa_and_salon_service_post_three || $spa_and_salon_service_post_four || $spa_and_salon_service_post_five || $spa_and_salon_service_post_six ){
     $spa_and_salon_service_posts = array( $spa_and_salon_service_post_one, $spa_and_salon_service_post_two, $spa_and_salon_service_post_three, $spa_and_salon_service_post_four, $spa_and_salon_service_post_five, $spa_and_salon_service_post_six );
     $spa_and_salon_service_posts = array_filter( $spa_and_salon_service_posts );
     
     $service_qry = new WP_Query( array( 
        'post_type'             => 'post',
        'posts_per_page'        => -1,
        'post__in'              => $spa_and_salon_service_posts,
        'orderby'               => 'post__in',
        'ignore_sticky_posts'   => true 
     ) );
     if( $service_qry->have_posts() ){ 
        ?>
    <div class="row">

        <?php
             while( $service_qry->have_posts() ){
             $service_qry->the_post();
                if( has_post_thumbnail() ){
        ?>
                <div class="col">
    			    <a href="<?php the_permalink(); ?>"  class="img-holder">
    				    <?php the_post_thumbnail( 'spa-and-salon-service' ); ?>	
    			    </a>
                    <h3><a href="<?php the_permalink(); ?>"> <?php the_title(); ?></a></h3>
                </div>
            <?php
                 }
             }  
            ?>

        </div>
        <?php
             wp_reset_postdata(); 
    }
 }		
 echo '</div>';

