<?php
/**
 * Template Name: Login Page
 */
get_header(); ?>
<main role="main">
	<?php
	// Start the loop.
	while ( have_posts() ) {
		the_post();

		// Include the page content template.
		get_template_part( 'template-parts/content', 'login' );
	} ?>
</main>
<?php get_footer();
