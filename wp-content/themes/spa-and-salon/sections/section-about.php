<?php
/**
 * About Section
 * 
 * @package Spa_and_Salon
 */
    $spa_and_salon_ed_about_section = get_theme_mod( 'spa_and_salon_ed_about_section' );
    $spa_and_salon_about_post = get_theme_mod( 'spa_and_salon_about_post' );
    $spa_and_salon_about_read_more = get_theme_mod( 'spa_and_salon_about_read_more', esc_html__( 'Read More', 'spa-and-salon' ) );
    
    $about_class = '';
    if( !is_page_template( 'template-home.php' ) || !$spa_and_salon_ed_about_section ) $about_class = ' about-note-inner';
    
    ?>
        <?php 
            if( $spa_and_salon_ed_about_section ){

              if( $spa_and_salon_about_post) { 
                $about_qry = new WP_Query( array( 'p' => $spa_and_salon_about_post ) );
                
                if( $about_qry->have_posts() ){
                    while( $about_qry->have_posts() ){
                        $about_qry->the_post();
                        ?>
                        <div class="container">
                          <div class="row">
                            <div class="col left-col">
                            <?php
                              if( has_post_thumbnail() ){ 
                                echo '<a href="'.  esc_url( get_permalink() )  .'" >';
                                  the_post_thumbnail( 'spa-and-salon-about-note' ); 
                                echo '</a>'
                            ?>
                            </div>
                            <div class="col">
                              <strong class="title"><?php the_title(); ?></strong>
                                <?php the_excerpt(); ?>
                                <?php if( $spa_and_salon_about_read_more ) { ?> 
                                  <a href="<?php the_permalink(); ?>" class="btn-green">
                                    <?php echo esc_html( $spa_and_salon_about_read_more ); ?>
                                  </a>
                                <?php } ?>
                            </div>
                          </div>
                    
                        <?php
                        }
                    }
                  wp_reset_postdata();
                }
              }
            }