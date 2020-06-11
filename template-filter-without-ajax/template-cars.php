<?php
/*
 * Template Name: Cars
 */

get_header();
?>
	<main>
		<div class="car__form">
			<form action="<?php echo get_permalink(); ?>">
				<?php
					echo $_REQUEST['cat'];
					$terms = get_terms(['taxonomy' => 'car_category', 'hide_empty'=> true,])
				?>
				<select name="used" onchange="this.form.submit();">
					<option value="">Select</option>
					<option value="1" <?php echo ($_REQUEST['used'] == 1)?'selected':''; ?>>1</option>
					<option value="2" <?php echo ($_REQUEST['used'] == 2)?'selected':''; ?>>2</option>
				</select>
				<select name="cat" onchange="this.form.submit();">
					<option value="">Select Name</option>
					<?php foreach ($terms as $term):?>
						<option value="<?php echo $term->slug; ?>" <?php if($_REQUEST['cat'] == $term->slug): ?>selected<?php endif; ?>><?php echo $term->name; ?></option>
					<?php endforeach; ?>
				</select>
			</form>
		</div>
		<?php
		$paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;


		if(!empty(@$_REQUEST['cat']) && !empty(@$_REQUEST['used'])){
			$args = [
				'post_type' => 'car',
				'posts_per_page' => 1,
				'paged' => $paged,
				'tax_query' => [
					[
						'taxonomy' => 'car_category',
						'field'    => 'slug',
						'terms'    => @$_REQUEST['cat'],
					]
				],
				'meta_query' => [
					array(
						'key'       => 'uses_year',
						'value'     => @$_REQUEST['used'],
						'compare'   => '=',
					),
				]
			];
		}elseif(!empty(@$_REQUEST['cat'])){
			$args = [
				'post_type' => 'car',
				'posts_per_page' => 1,
				'paged' => $paged,
				'tax_query' => [
					[
						'taxonomy' => 'car_category',
						'field'    => 'slug',
						'terms'    => @$_REQUEST['cat'],
					]
				],
			];
		}elseif( !empty(@$_REQUEST['used'])){
			$args = [
				'post_type' => 'car',
				'posts_per_page' => 1,
				'paged' => $paged,
				'meta_query' => [
					array(
						'key'       => 'uses_year',
						'value'     => @$_REQUEST['used'],
						'compare'   => '=',
					),
				]
			];
		} else{
			$args = [
				'post_type' => 'car',
				'posts_per_page' => 1,
				'paged' => $paged
			];
		}

		$cars = new WP_Query($args);
		while ( $cars->have_posts() ): $cars->the_post();
			the_title('<h4>','</h4>');
		endwhile; ?>

		<nav class="pagination">
			<?php
			$big = 999999999;
			echo paginate_links( array(
				//'base' => str_replace( $big, '%#%', get_pagenum_link( $big ) ),
				'format' => '?paged=%#%',
				'current' => max( 1, get_query_var('paged') ),
				'total' => $cars->max_num_pages,
				'prev_text' => '&laquo;',
				'next_text' => '&raquo;'
			) );
			?>
		</nav>

		<?php wp_reset_postdata(); ?>
	</main>

<?php
get_footer();
