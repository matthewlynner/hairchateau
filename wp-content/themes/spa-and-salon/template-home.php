<?php
/**
 * Template Name: Home Page
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Spa_and_Salon
 */
get_header();
?>

	<?php

    $spa_and_salon_enabled_sections = spa_and_salon_get_sections();
    
    if( $spa_and_salon_enabled_sections ){
    
	    foreach( $spa_and_salon_enabled_sections as $spa_and_salon_section ){ ?>
	        <section class="<?php echo esc_attr( $spa_and_salon_section['class'] ); ?>" id="<?php echo esc_attr( $spa_and_salon_section['id'] ); ?>">
	            <?php get_template_part( 'sections/section', esc_attr( $spa_and_salon_section['id'] ) ); ?>
	        </section>
	    <?php
	    }
	}
	?>
<?php get_footer(); ?>