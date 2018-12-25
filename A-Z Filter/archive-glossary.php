<?php

/**
 * The template for displaying archive pages
 *
 * Used to display archive-type pages if nothing more specific matches a query.
 * For example, puts together date-based pages if no date.php file exists.
 *
 * If you'd like to further customize these archive views, you may create a
 * new template file for each one. For example, tag.php (Tag archives),
 * category.php (Category archives), author.php (Author archives), etc.
 *
 * @link       https://codex.wordpress.org/Template_Hierarchy
 *
 * @package    WordPress
 * @subpackage Custom_Theme
 * @since      1.0
 * @version    1.0
 */

$glossary = get_archive();

get_header(); ?>
	<div class="article">
		<div class="container">
			<div class="article__content article__content--stores">
				<h1><?php echo get_the_title( $glossary->ID ); ?></h1>

				<?php echo apply_filters( 'the_content', get_post_field( 'post_content', $glossary->ID ) ); ?>
			</div>
		</div>
	</div>
    <strong><a href="<?php echo get_post_type_archive_link( 'glossary' ); ?>"><?php _t('All') ?></a> &emsp;</strong>
<?php
foreach(range('a', 'z') as $i) : ?>
    <strong><a href="<?php echo get_post_type_archive_link( 'glossary' ); ?>?alpha=<?php echo $i; ?>"><?php echo ucfirst($i); ?></a> &emsp;</strong>
   <?php  endforeach;
if(have_posts()){
while (have_posts()){
    the_post();
    the_title('<h2>','</h2>');
}
}else{
    echo "Not Found";
}
get_footer();
