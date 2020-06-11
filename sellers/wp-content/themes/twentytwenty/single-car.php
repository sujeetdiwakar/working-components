<?php
/**
 * The template for displaying all single posts and attachments
 *
 * @package    WordPress
 * @subpackage Custom_Theme
 * @since      1.0
 * @version    1.0
 */

get_header(); ?>
	<main role="main">
		<?php while (have_posts()): the_post(); ?>
			<div class="car">
				<?php if(has_post_thumbnail()): ?>
					<figure><?php the_post_thumbnail('full'); ?></figure>
				<?php endif; ?>

				<h2><?php the_title(); ?></h2>
				<ul>
					<?php if ( get_field( 'price' ) ): ?>
						<span>Price: <?php the_field( 'price' ); ?></span>
					<?php endif; ?>
					<?php if ( get_field( 'brand' ) ): ?>
						<span>Brand: <?php the_field( 'brand' ); ?></span>
					<?php endif; ?>
				</ul>
				<?php the_content(); ?>
			</div>
		<?php endwhile; ?>
	</main>
<?php get_footer();
