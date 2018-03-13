<?php
/**
 * Template part for displaying posts.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Spa_and_Salon
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<?php
			if ( is_single() ) {
				the_title( '<h1 class="entry-title">', '</h1>' );
			} else {
				the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
			}

		if ( 'post' === get_post_type() ) : ?>
		<div class="entry-meta">
			<?php spa_and_salon_posted_on(); ?>
		</div><!-- .entry-meta -->
		<?php
		endif; ?>
	</header><!-- .entry-header -->
	 <?php echo ( !is_single() ) ? '<a href="' . esc_url( get_the_permalink() ) . '" class="post-thumbnail">' : '<div class="post-thumbnail">'; ?>
 			<?php ( is_active_sidebar( 'right-sidebar' ) ) ? the_post_thumbnail( 'spa-and-salon-with-sidebar' ) : the_post_thumbnail( 'spa-and-salon-without-sidebar' ) ; ?>
    <?php echo ( !is_single() ) ? '</a>' : '</div>' ;?>

	<div class="entry-content">
		<?php
		if( is_single()){
			the_content( sprintf(
				/* translators: %s: Name of current post. */
				wp_kses( __( 'Continue reading %s <span class="meta-nav">&rarr;</span>', 'spa-and-salon' ), array( 'span' => array( 'class' => array() ) ) ),
				the_title( '<span class="screen-reader-text">"', '"</span>', false )
			) );
			}else{
			the_excerpt();
			}
			wp_link_pages( array(
				'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'spa-and-salon' ),
				'after'  => '</div>',
			) );
		?>
	</div><!-- .entry-content -->


	
    <footer class="entry-footer">
    	<?php if( !is_single() ){ ?>
		<a href="<?php the_permalink(); ?>" class="btn-green"><?php esc_html_e( 'Read More', 'spa-and-salon' ); ?></a>
		<?php }?>
		<?php spa_and_salon_entry_footer(); ?>
	</footer><!-- .entry-footer -->


</article><!-- #post-## -->
