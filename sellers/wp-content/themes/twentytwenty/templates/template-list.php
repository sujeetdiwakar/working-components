<?php
/**
 * Template Name: List Page
 */

if ( ! is_user_logged_in() ) {
	wp_redirect( get_home_url() );
	exit;
}

get_header(); ?>

	<main role="main">

		<?php
		get_template_part('template-parts/seller','menu');

		if ( isset( $_REQUEST['id'] ) ) {

			$id = $_REQUEST['id'];
			wp_trash_post( $id );
			echo '<h2>Your record has been deleted successfully</h2>';
		}
		$args = [
			'post_type'      => 'car',
			'posts_per_page' => - 1,
			'author'         => get_current_user_id()
		];
		$cars = new WP_Query( $args );
		// Start the loop.
		if ( $cars->have_posts() ): ?>
			<ul>
				<?php while ( $cars->have_posts() ):
					$cars->the_post(); ?>
					<li>
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
						<form method="post">
						<input type="hidden" name="id" value="<?php the_ID(); ?>">
						<button type="submit">Delete</button>
						</form>
					</li>
				<?php endwhile;
				wp_reset_postdata(); ?>
			</ul>
		<?php endif; ?>
	</main>

<?php get_footer();
