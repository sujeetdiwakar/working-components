<?php

namespace Custom_Theme\Queries;


class Post {
	
	public function __construct() {
		add_filter( 'pre_get_posts', [ $this, 'adjust_main_queries' ] );
	}

	
	public function adjust_main_queries( $query ) {
		if ( ! is_admin() && $query->is_main_query() && is_post_type_archive( 'example' ) ) {
			$query->set( 'posts_per_page', 16 );
			$query->set( 'orderby', 'title' );
			$query->set( 'order', 'asc' );
		}
        if ( ! is_admin() && $query->is_tax() || is_post_type_archive( 'glossary' ) ) {
            if ( isset( $_GET['alpha'] ) && ! empty( $_GET['alpha'] ) ) {
                $query->set( 'tax_query', '' );

                $tax_query[] = [
                    'taxonomy' => 'alpha_cat',
                    'field'    => 'slug',
                    'terms'    => $_GET['alpha'],
                ];
                $query->set( 'tax_query', $tax_query );
            }
        }

		return $query;
	}
}
