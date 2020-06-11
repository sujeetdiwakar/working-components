<?php
/**
 * Template Name: Dashboard Page
 */

if ( ! is_user_logged_in() ) {
	wp_redirect( get_home_url() );
	exit;
}

get_header(); ?>

	<main role="main">
		<?php
		// Start the loop.
		while ( have_posts() ) {
			the_post();

			// Include the page content template.
			if ( current_user_can( 'sellers' ) ) {
				get_template_part( 'template-parts/dashboard', 'seller' );
			}
		} ?>
	</main>

<?php get_footer();
