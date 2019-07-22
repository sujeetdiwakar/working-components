<?php
/**
 * The template for displaying the header
 *
 * Displays all of the head element and everything up until the page wrapper div.
 *
 * @package    WordPress
 * @subpackage Custom_Theme
 * @since      1.0
 * @version    1.0
 */
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title><?php wp_title( '&laquo;', true, 'right' ); ?><?php bloginfo( 'name' ); ?></title>
	<?php wp_head(); ?>
	<!--[if lt IE 9]>
	<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
	<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>    <![endif]-->
</head>
<body <?php body_class(); ?>>

	<div class="wrapper">
		<header class="header<?php if ( is_admin_bar_showing() ): ?> header--admin<?php endif; ?>">
			<div class="header__top container">
				<ul>
					<?php if ( ( $shipping = get_field( 'shipping_text', 'option' ) ) && ! empty( $shipping ) ): ?>
						<li><?php echo $shipping; ?></li>
					<?php endif;

					if ( ( $delivery = get_field( 'delivery__detail', 'option' ) ) && ! empty( $delivery ) ):?>
						<li><?php echo $delivery; ?></li>
					<?php endif;

					if ( ( $rating = get_field( 'customer_rating', 'option' ) ) && ! empty( $rating ) ):?>
						<li><?php echo $rating; ?></li>
					<?php endif; ?>
				</ul>
			</div>

			<div class="header__info container">
				<div class="header__toggle">
					<a href="#nav"><span><?php _e( 'Menu' ); ?></span></a>
				</div>

				<div class="header__search">
					<?php get_product_search_form(); ?>
				</div>

				<div class="header__logo">
					<a href="<?php echo get_option( 'home' ); ?>/">
						<img src="<?php echo get_template_directory_uri(); ?>/images/logo.png" alt="<?php bloginfo( 'name' ); ?>">
					</a>
				</div>

				<div class="header__login">
					<ul>
						<?php if ( ( $account = get_option( 'woocommerce_myaccount_page_id' ) ) && ! empty( $account ) ): ?>
							<li>
								<?php if ( is_user_logged_in() ): ?>
									<p>
										<a href="<?php echo get_permalink( $account ); ?>">
											<?php _e( 'Mijn Account' ); ?>
										</a>
										<br>
										<a href="<?php echo wp_logout_url( home_url() ); ?>">
											<?php _e( 'Uitloggen' ); ?>
										</a>
									</p>
								<?php else: ?>
									<p>
										<span><?php _e( 'Nog geen account?' ); ?></span>
										<a href="<?php echo get_permalink( $account ); ?>"><?php _e( 'Registreren<br> Inloggen' ); ?></a>
									</p>
								<?php endif; ?>
							</li>
						<?php endif; ?>
						<li>
							<a href="<?php echo wc_get_cart_url(); ?>">
								<?php echo WC()->cart->get_cart_total(); ?>
								<strong>
									<i><?php echo WC()->cart->get_cart_contents_count(); ?></i>
									<span><?php _e( 'Afrekenen' ); ?></span>
								</strong>
							</a>
						</li>
					</ul>
				</div>
			</div>

			<div class="header__menu container">
				<?php wp_nav_menu( [
					'theme_location' => 'primary',
					'container'      => 'nav',
					'container_id'   => 'nav'
				] ); ?>
			</div>
		</header>