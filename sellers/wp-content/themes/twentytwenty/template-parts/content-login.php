<?php
/**
 * The template used for displaying login form
 *
 * @package    WordPress
 * @subpackage Custom_Theme
 * @since      3.4.6
 * @version    3.4.6
 */

$dashboard = get_field( 'dashboard_page', 'option' ); ?>

<div class="content content--login container">
	<div class="content__login">
		<figure>
			<a href="<?php echo get_option( 'home' ); ?>/">
				<img src="<?php echo get_template_directory_uri(); ?>/images/logo.png" alt="<?php bloginfo( 'name' ); ?>">
			</a>
		</figure>

		<?php wp_login_form( [
			'remember'       => false,
			'redirect'       => get_permalink( $dashboard ),
			'label_username' => __( 'Username' ),
			'label_password' => __( 'Password' ),
			'label_log_in'   => __( 'Log In' ),
		] ); ?>
	</div>
</div>