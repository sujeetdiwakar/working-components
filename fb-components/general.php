<?php
/**
 * Handy functions to use all over the template
 *
 * @package    WordPress
 * @subpackage Custom_Theme
 * @since      2.0
 */

if ( ! function_exists( 'css_class' ) ) {
	/**
	 * Easily add multiple classes to html object.
	 *
	 * @since 2.0
	 *
	 * @param array $classes Array containing class names.
	 *
	 * @return void
	 */
	function css_class( array $classes ) {
		echo ' class="' . trim( implode( ' ', $classes ) ) . '"';
	}
}

if ( ! function_exists( 'wp_enqueue_footer_script' ) ) {
	/**
	 * Add additional footer enqueues
	 *
	 * @since 4.1
	 *
	 * @return array Array containing all enqueues for the footer
	 */
	function wp_enqueue_footer_script( $name ) {
		global $wp_enqueue_footer_name;
		$wp_enqueue_footer_name = $name;

		add_filter( 'wp_enqueue_footer_array', function ( $enqueues ) {
			global $wp_enqueue_footer_name;
			array_push( $enqueues, $wp_enqueue_footer_name );

			$wp_enqueue_footer_name = null;

			return $enqueues;
		} );
	}
}

if ( ! function_exists( 'is_ajax_call' ) ) {
	/**
	 * Check if the page is loaded with ajax.
	 *
	 * @since 2.0
	 *
	 * @return bool True when the page is loaded with ajax.
	 */
	function is_ajax_call() {
		if ( ! empty( $_SERVER['HTTP_X_REQUESTED_WITH'] ) && strtolower( $_SERVER['HTTP_X_REQUESTED_WITH'] ) == 'xmlhttprequest' ) {
			return true;
		}

		return false;
	}
}

if ( ! function_exists( 'get_size' ) ) {
	/**
	 * Calculate the size of a file
	 *
	 * Can be used like `get_size( get_attached_file( $attachment_id ) )`.
	 *
	 * @since 3.0
	 *
	 * @param string $file The path to the file.
	 *
	 * @return string Formatted string with a neat file size.
	 */
	function get_size( $file ) {
		$bytes = filesize( $file );
		$s     = [ 'b', 'Kb', 'Mb', 'Gb' ];
		$e     = floor( log( $bytes ) / log( 1024 ) );

		return sprintf( '%.2f ' . $s[ $e ], ( $bytes / pow( 1024, floor( $e ) ) ) );
	}
}

if ( ! function_exists( 'strip_phone_number' ) ) {
	/**
	 * Strip the input to a phone number which can be called.
	 *
	 * @since 2.0
	 *
	 * @param string $phone_number The input phone number.
	 *
	 * @return string The formatted phone number.
	 */
	function strip_phone_number( $phone_number ) {
		$phone_number = str_replace( ' ', '', $phone_number );
		$phone_number = str_replace( '-', '', $phone_number );
		$phone_number = str_replace( '.', '', $phone_number );
		$phone_number = str_replace( '(0)', '', $phone_number );
		$phone_number = str_replace( '(', '', $phone_number );
		$phone_number = str_replace( ')', '', $phone_number );
		$phone_number = str_replace( '+', '00', $phone_number );

		return $phone_number;
	}
}

if ( ! function_exists( 'format_price' ) ) {
	/**
	 * Easily format prices.
	 *
	 * @since 3.0
	 *
	 * @param string $price The input price
	 * @param bool   $zeros Whether the price should contain zero's or just ,-
	 *
	 * @return string The formatted price
	 */
	function format_price( $price, $zeros = true ) {
		// Check if Woocommerce is active, if so use build in Woocommerce function
		if ( function_exists( 'wc_price' ) ) {
			return wc_price( $price );
		}

		$price = str_replace( '.', ',', $price );
		$price = '&euro; ' . $price;

		if ( $zeros === false ) {
			if ( substr( $price, - 3 ) == ',00' ) {
				$price = substr( $price, 0, - 3 ) . ',-';
			}
		}

		return $price;
	}
}

if ( ! function_exists( 'get_current_url' ) ) {
	/**
	 * Fetch the current URL from the Query String.
	 *
	 * @since 3.2
	 *
	 * @return string The current URL (escaped of course)
	 */
	function get_current_url() {
		global $wp;

		$current_url = esc_url( add_query_arg( esc_url( $_SERVER['QUERY_STRING'] ), '', home_url( $wp->request ) ) );

		if ( substr( $current_url, - 1 ) != '/' && strpos( $current_url, '?' ) === false ) {
			$current_url = $current_url . '/';
		}

		return $current_url;
	}
}

if ( ! function_exists( 'the_current_url' ) ) {
	/**
	 * Shorthand function for echo get_the_current_url();
	 *
	 * @see   get_current_url()
	 *
	 * @since 3,2
	 *
	 * @return void
	 */
	function the_current_url() {
		echo get_current_url();
	}
}

add_action("wp_ajax_my_user_vote", "my_user_vote");
add_action("wp_ajax_nopriv_my_user_vote", "my_must_login");

function my_user_vote() {
    $hello = "hello";

}