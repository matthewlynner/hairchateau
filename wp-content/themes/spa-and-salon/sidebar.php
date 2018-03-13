<?php
/**
 * The sidebar containing the main widget area.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Spa_and_Salon
 */

 $sidebar_layout = spa_and_salon_sidebar_layout();

if ( ! is_active_sidebar( 'right-sidebar' ) || ( $sidebar_layout == 'no-sidebar' ) || is_404() || is_search() ) {
	return;
}

?>

<aside id="secondary" class="widget-area" role="complementary">
	<?php dynamic_sidebar( 'right-sidebar' ); ?>
</aside><!-- #secondary -->
