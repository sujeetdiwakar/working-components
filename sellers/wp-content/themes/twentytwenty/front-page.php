<?php
/**
 * The template for displaying front pages
 *
 * @package    WordPress
 * @subpackage Custom_Theme
 * @since      1.0
 * @version    1.0
 */

get_header(); ?>

	<main role="main">
		<?php
		$args = [
			'post_type'      => 'car',
			'posts_per_page' => - 1,

		];
		$cars = new WP_Query( $args );
		// Start the loop.
		if ( $cars->have_posts() ): ?>
			<ul>
				<?php while ( $cars->have_posts() ):
					$cars->the_post(); ?>
					<li>
						<a href="<?php the_permalink(); ?>">
							<?php if ( has_post_thumbnail() ): ?>
								<figure><img height="200" width="200" src="<?php the_post_thumbnail_url(); ?>"> </figure>
							<?php endif; ?>
							<strong><?php the_title(); ?></strong>
							<?php if ( get_field( 'price' ) ): ?>
								<span>Price: <?php the_field( 'price' ); ?></span>
							<?php endif; ?>
							<?php if ( get_field( 'brand' ) ): ?>
								<span>Brand: <?php the_field( 'brand' ); ?></span>
							<?php endif; ?>
						</a>
					</li>
				<?php endwhile;
				wp_reset_postdata(); ?>
			</ul>
		<?php endif; ?>
	</main>

<?php get_footer();

