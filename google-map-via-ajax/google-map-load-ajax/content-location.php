<?php

$args      = [
	'post_type'      => 'location',
	'posts_per_page' => - 1,
];
$locations = new WP_Query( $args );

if ( $locations->have_posts() ):?>

	<div class="locations js-location" data-url="<?php echo admin_url( 'admin-ajax.php' ); ?>">

		<div class="location__cat">
			<form>
				<strong><?php _t( 'Zoek een locatie' ); ?></strong>
				<?php
				$terms = get_terms(
					[
						'taxonomy' => 'location_cat',
					]
				);

				foreach ( $terms as $term ): ?>
					<label>
						<br>
						<input class="js-cat" type="radio" name="location" value="<?php echo $term->slug; ?>"><?php echo $term->name; ?>
					</label>
				<?php endforeach; ?>
				<br>
				<input id="postcode" type="text" name="postcode" placeholder="postcode">
				<button id="js-search" class="button"><?php _t( 'Zoeken' ); ?></button>
			</form>
		</div>

		<div class="locations__map">
			<div class="maps js-content" data-zoom="12">
				<?php while ( $locations->have_posts() ): $locations->the_post();
					$location = get_field( 'google_map' ); ?>
					<div class="marker" data-lat="<?php echo $location['lat']; ?>" data-lng="<?php echo $location['lng']; ?>" data-marker-icon="<?php echo get_theme_file_uri( 'dist/img/marker.png' ); ?>">
						<div class="maps__infobox">
							<?php
							$terms = get_the_terms( get_the_ID(), 'location_cat' );

							foreach ( $terms as $term ):?>
								<h3><?php echo $term->name; ?></h3>
							<?php endforeach; ?>
							<strong><?php the_title(); ?></strong>

							<address>
								<?php the_field( 'location_address' ); ?>
							</address>
							<a class="button" href="<?php the_permalink(); ?>"><?php _t( 'Bekijk vestiging' ); ?></a>
						</div>
					</div>
				<?php endwhile;
				wp_reset_postdata(); ?>
			</div>
			<?php wp_enqueue_footer_script( 'maps' ); ?>
		</div>

	</div>
<?php endif; ?>
