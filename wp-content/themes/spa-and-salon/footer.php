<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Spa_and_Salon
 */

$enabled_sections = spa_and_salon_get_sections();

      if( is_home() || ! $enabled_sections || ! ( is_front_page()  || is_page_template( 'template-home.php' ) ) ) { 
            if (  is_search() ) { echo '</div>'; }
            echo '</div></div></div>';
      } ?><!-- #content -->	
      
      <?php  
      $social_links = get_theme_mod( 'spa_and_salon_social_ed_footer' );
      $spa_and_salon_social_info = get_theme_mod('spa_and_salon_social_info', esc_html__( 'Follow Us On', 'spa-and-salon') );
                        
      if( $social_links ){
            echo '<div class="social-block"><div class="container">';
            
            if( $spa_and_salon_social_info ){ 
                  echo esc_html( $spa_and_salon_social_info );
            }
            do_action( 'spa_and_salon_social_link' ); 
            echo'</div></div>'; 
      } ?>
           
      <footer class="site-footer">
	<?php if( is_active_sidebar( 'footer-one' ) || is_active_sidebar( 'footer-two' ) || is_active_sidebar( 'footer-three' ) || is_active_sidebar( 'footer-four' ) ){ ?>
		<div class="footer-t">
			<div class="container">
				<div class="row">
					<?php 
                    
                        if( is_active_sidebar( 'footer-one') ) {
                        	echo '<div class="col">';
                        	dynamic_sidebar( 'footer-one' ); 
                        	echo '</div>';
                        }
                        
                        if( is_active_sidebar( 'footer-two') ) {
                        	echo '<div class="col">';
                        	dynamic_sidebar( 'footer-two' );
                        	echo '</div>';
                        }
                        
                        if( is_active_sidebar( 'footer-three') ) {
                        	echo '<div class="col">';
                        	dynamic_sidebar( 'footer-three' );
                        	echo '</div>';
                        }
                        
                        if( is_active_sidebar( 'footer-four' ) ) {
                        	echo '<div class="col">';
                        	dynamic_sidebar( 'footer-four' );
                        	echo '</div>';
						}
                    
                    ?>
				</div>
			</div>
		</div>
	<?php } 
		do_action( 'spa_and_salon_footer' );
	?>
	</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
