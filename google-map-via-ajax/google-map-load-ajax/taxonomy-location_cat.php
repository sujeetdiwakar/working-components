<?php


get_header();

?>

    <main role="main">
        <div class="js-cat-desc">
            <h1><?php echo get_queried_object()->name; ?></h1>
            <p><?php echo get_queried_object()->description; ?></p>
        </div>
        <?php get_template_part('template-parts/content', 'location-cat'); ?>
        <div class="js-list">
            <?php
            if (have_posts()) {
               
                while (have_posts()) {
                    the_post();

                  
                    get_template_part('template-parts/loop', 'location');
                }
            } else {
               
                get_template_part('template-parts/content', 'none');
            } ?>
        </div>
    </main>

<?php get_footer();
