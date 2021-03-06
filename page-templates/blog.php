<?php 
/*
	Template Name: Blog
*/
?>
<?php get_header(); ?>
<?php do_action( 'accelerate_before_body_content' ); ?>

	<div id="primary">
		<div id="content" class="clearfix">

		<?php // Display blog posts on any page @ https://m0n.co/l
		$temp = $wp_query; $wp_query= null;
		$wp_query = new WP_Query(); $wp_query->query('posts_per_page=5' . '&paged='.$paged);
		while ($wp_query->have_posts()) : $wp_query->the_post(); ?>

			<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
				<?php do_action( 'accelerate_before_post_content' ); ?>

				<header class="entry-header">
					<h2 class="entry-title">
						<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a>
					</h2>
				</header>

				<?php
				if ( 'post' == get_post_type() ) :
					accelerate_entry_meta();
				endif;
				?>

				<?php
				if ( has_post_thumbnail() ) {
					$image = '';
					$title_attribute = get_the_title( $post->ID );
					$image .= '<figure class="post-featured-image">';
					$image .= '<a href="' . get_permalink() . '" title="' . the_title_attribute( 'echo=0' ) . '">';
					$image .= get_the_post_thumbnail( $post->ID, 'featured-blog-large', array(
							'title' => esc_attr( $title_attribute ),
							'alt'   => esc_attr( $title_attribute ),
						) ) . '</a>';
					$image .= '</figure>';
					echo $image;
				}
				?>

				<div class="entry-content clearfix">
					<?php
					global $more;
					$more = 0;
					the_content( '<span>' . __( 'Read more', 'accelerate' ) . '</span>' );
					?>
				</div>

				<?php do_action( 'accelerate_after_post_content' ); ?>
			</article>

			<?php
			do_action( 'accelerate_before_comments_template' );
			// If comments are open or we have at least one comment, load up the comment template
			if ( comments_open() || '0' != get_comments_number() ) {
				comments_template();
			}
			do_action( 'accelerate_after_comments_template' );
			?>

		<?php endwhile; ?>

		<?php if ($paged > 1) { ?>

		<nav id="nav-posts">
			<div class="prev"><?php next_posts_link('&laquo; Previous Posts'); ?></div>
			<div class="next"><?php previous_posts_link('Newer Posts &raquo;'); ?></div>
		</nav>

		<?php } else { ?>

		<nav id="nav-posts">
			<div class="prev"><?php next_posts_link('&laquo; Previous Posts'); ?></div>
		</nav>

		<?php } ?>

		<?php wp_reset_postdata(); ?>

</div><!-- #content -->
	</div><!-- #primary -->

<?php accelerate_sidebar_select(); ?>

<?php do_action( 'accelerate_after_body_content' ); ?>

<?php get_footer(); ?>
