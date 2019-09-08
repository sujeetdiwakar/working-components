<?php
/*
*
*Template Name: Gallery Page
*
*/
get_header(); ?>
<script type="text/javascript">
	jQuery(document).ready(function(){
		var $href = jQuery('.js-tab li.is-active a').attr('href');
		jQuery($href).show().siblings('div').hide();
		jQuery('.js-tab li a').on('click',function(e){
			e.preventDefault();
			var $href= jQuery(this).attr('href');
			jQuery($href).show().siblings('div').hide();
			jQuery(this).parent('li').addClass('is-active').siblings('li').removeClass('is-active');
		});


		jQuery('.js-title').on('click',function(e){
			e.preventDefault();
			var $href= jQuery(this).attr('href');
			jQuery($href).show().siblings('div').hide();

			jQuery('.js-tab li a[href="'+$href+'"]').parent('li').addClass('is-active').siblings('li').removeClass('is-active');
		})
	});
</script>

<div class="container">
	<?php
	
	$terms = get_terms(['taxonomy'=>'gallery_cat','hide_empty'=>false]);
	echo "<ul class='js-tab'>";
	$k = 1;
	foreach ($terms as $term): ?>
		<li class="<?php echo ($k==1)?'is-active':''; ?>"><a href="#<?php echo $term->slug; ?>"><?php echo $term->name; ?></a></li>
	<?php $k++; endforeach;
	echo "</ul>";

	foreach ($terms as $term):
		$slugs[] = $term->slug;
	endforeach;
	/*
	echo "<pre>";
	print_r($slugs);
	echo "</pre>";
	*/
	foreach ($terms as $term): 
		$ar = $slugs;
		$pos = array_search($term->slug, $ar);
		unset($ar[$pos]);
		array_unshift($ar, $term->slug);
		?>
		<div id="<?php echo $term->slug; ?>">
			<?php
			$i = 1; 
			foreach ($ar as $slug): 
			
				$args = [
					'post_type'=>'gallery',
					'posts_per_page' => -1,
					'tax_query' => [
						[
							'taxonomy' => 'gallery_cat',
							'terms'    => $slug,
							'field'	   => 'slug',
						],
					],
				];
				$cr_term = get_term_by('slug', $slug, 'gallery_cat'); 
				$name = $cr_term->name;
				$desc = $cr_term->description;
				?>

			<h1><a class="js-title" href="#<?php echo $slug; ?>"><?php echo $name; ?></a></h1>
			<?php if($i==1): ?>
				<p><?php echo $desc; ?></p>
			<?php
			endif;
			$gallery = new WP_Query($args);
			if($i==1):
				while($gallery->have_posts()) : $gallery->the_post(); ?>
				    <div class="entry-content">
				   		<strong><?php the_title(); ?></strong>
				   </div>
				<?php endwhile; 
				wp_reset_postdata(); 
			endif;
				$i++;
		endforeach; ?>
	</div>
<?php endforeach; ?>
</div>
<?php
get_footer();
?>