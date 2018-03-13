<?php
/**
 * The template for displaying 404 pages (not found).
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package Spa_and_Salon
 */

get_header(); ?>

		<main id="main" class="site-main" role="main">
				<div class="error-holder">
					<h1><?php esc_html_e( '404', 'spa-and-salon' ); ?></h1>
					<h2><?php esc_html_e( 'Sorry, that page can\'t be found!', 'spa-and-salon' ); ?></h1></h2>
					<p><?php esc_html_e( 'Try going back to our ', 'spa-and-salon' ); ?><a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'homepage', 'spa-and-salon' ); ?></a><?php esc_html_e( ' where we\'ll point you in the right direction.', 'spa-and-salon' ); ?></p>
				</div>
		</main><!-- #main -->

<?php
get_footer();
