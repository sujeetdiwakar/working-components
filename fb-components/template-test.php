<?php
/**
 * Template Name: Test Page
 * Template Post Type: post, page
 */
get_header(); ?>
<div class="content">
    <a href="javascript:void(0)" class="js-button" data-filter="<?php echo admin_url( 'admin-ajax.php' ); ?>" data-appid="297165727552691">Log In With Facebook</a>
    <input type="button" class="" value="Log In With Facebook" />
    <?php the_content(); ?>
</div>


<?php get_footer();
