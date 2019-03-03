<?php
/**
 * Template Name: Order Page
 * Template Post Type: post, page
 */
session_start();
get_header();

$filter_args = [
    'parent' => 0,
    'hide_empty' => true,
];

$pid = $_GET['p_id'];
$cid = $_GET['c_id'];
$page_size = $_GET['page_size'];

$parent_terms = get_terms('product_cat', $filter_args);

if (!empty($pid)) {
    $subcategories = get_terms(
        [
            'taxonomy' => 'product_cat',
            'parent' => $pid,
            'orderby' => 'term_id',
            'hide_empty' => false
        ]
    );
}

?>
    <div class="article">
        <div class="article__content container">
            <main role="main">
                <?php get_template_part('template-parts/content', 'breadcrumb'); ?>
                <div class="container">
                    <?php the_content(); ?>
                </div>


                <div id="filter" class="container"
                     style="display:<?php echo (get_query_var('paged') || !empty($cid) || !empty($page_size) || !empty($pid)) ? 'block' : 'none'; ?>">
                    <div class="search"><br><br>
                        <?php echo (!empty($cid) || !empty($page_size) || !empty($pid)) ? 'block' : 'none'; ?>
                        <form>
                            <input type="hidden" name="pname" value="<?php echo $_REQUEST['pname']; ?>">
                            <div class="row">
                                <div class="col-md-4">

                                    <?php if (!empty($parent_terms)): ?>
                                        <select name="p_id" onchange="this.form.submit()">
                                            <option value=""><?php _t('Categorieën'); ?></option>
                                            <?php foreach ($parent_terms as $parent_term): ?>
                                                <option value="<?php echo $parent_term->term_id; ?>" <?php echo ($parent_term->term_id == $pid) ? 'selected' : null; ?>><?php echo $parent_term->name; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    <?php endif; ?>

                                </div>

                                <div class="col-md-4">

                                    <select name="c_id" onchange="this.form.submit()">
                                        <option value=""><?php _t('Subcategorieën'); ?></option>
                                        <?php foreach ($subcategories as $subcategory): ?>
                                            <option value="<?php echo $subcategory->term_id; ?>" <?php echo ($subcategory->term_id == $cid) ? 'selected' : null; ?>><?php echo $subcategory->name; ?></option>
                                        <?php endforeach; ?>
                                    </select>

                                </div>

                                <div class="col-md-4">
                                    <span><?php _t('Aantal producten tonen'); ?></span>
                                    <select name="page_size" onchange="this.form.submit()">
                                        <?php for ($i = 2; $i <= 20; $i += 2) {
                                            if ($i == $page_size) {
                                                echo '<option value=' . $i . ' selected>' . $i . '</option>';
                                            } else {
                                                echo '<option value=' . $i . '>' . $i . '</option>';
                                            }
                                        } ?>
                                    </select>
                                    <p>
                                        <a href="<?php echo get_page_link(get_the_ID()); ?>"><?php _t('Verwijder filter'); ?></a>
                                    </p>
                                </div>

                            </div>
                        </form>
                    </div>
                    <?php
                    $page_size = $_GET['page_size'];
                    $pid = $_GET['p_id'];
                    $cid = $_GET['c_id'];
                    if (empty($page_size)) {
                        $page_size = 2;
                    }
                    if (!empty($pid) && !empty($cid)) {


                        $tax_query[] = [
                            'taxonomy' => 'product_cat',
                            'field' => 'term_id',
                            'terms' => [$cid],
                        ];
                    } elseif (!empty($pid)) {

                        $tax_query[] = [
                            'taxonomy' => 'product_cat',
                            'field' => 'term_id',
                            'terms' => [$pid],
                        ];
                    }

                    $args = [
                        'post_type' => 'product',
                        'posts_per_page' => $page_size,
                        'tax_query' => $tax_query,
                    ];

                    $order = new WP_Query($args);

                    if ($order->have_posts()) {
                        // Start the loop.
                        while ($order->have_posts()) {
                            $order->the_post();
                            ?>


                            <div class="block">
                                <a href="<?php the_permalink(); ?>">
                                    <figure>
                                        <?php the_post_thumbnail('product'); ?>
                                        <figcaption><?php echo substr(get_the_title(), '0', '23') . '...'; ?></figcaption>
                                    </figure>

                                    <?php if (($price = get_field('price')) && !empty($price)): ?>
                                        <p><?php echo $price; ?></p>
                                    <?php endif; ?>

                                </a>

                                <?php if (($order_button = get_field('order_button', 'option')) && !empty($order_button)): ?>
                                    <a id="delete-button" class="button js-title"
                                       href="?pname=<?php echo $_REQUEST['pname'] . ',' . get_the_title(); ?>"
                                       data-title="<?php the_title(); ?>" class="button">
                                        <?php _t('Bestel nu'); ?>
                                    </a>
                                <?php endif; ?>
                            </div>


                            <?php
                        }
                        echo paginate_links([
                            'base' => '?paged=%#%',
                            'format' => '?paged=%#%',
                            'current' => max(1, get_query_var('paged')),
                            'prev_text' => __('<'),
                            'next_text' => __('>'),
                            'total' => $order->max_num_pages
                        ]);
                    } else {
                        // If no content, include the "No posts found" template.
                        get_template_part('template-parts/content', 'none');
                    } ?>
            </main>
        </div>
    </div>
<?php get_footer();
