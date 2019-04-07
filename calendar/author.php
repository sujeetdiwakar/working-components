<?php
get_header();
global $wp_query;
$curauth = $wp_query->get_queried_object();
$u_id = $curauth->ID; ?>

    <main role="main">
        <div class="content container">
            <?php if (empty($_REQUEST['year']) && empty($_REQUEST['month'] && empty($_REQUEST['day']))) : ?>
                <div class="content__calendar">
                    <h1><?php _e(''); ?></h1>

                    <div class="content__calendar-year">
                        <?php
                        if (!empty($_GET['py'])) {
                            $py = $_GET['py'] - 1;
                        } else {
                            if ($_GET['ny']) {
                                $py = $_GET['ny'] - 1;
                            } else {
                                $py = date('Y') - 1;
                            }

                        }


                        if (!empty($_GET['ny'])) {

                            $ny = $_GET['ny'] + 1;

                        } else {

                            if ($_GET['py']) {
                                $ny = $_GET['py'] + 1;
                            } else {
                                $ny = date('Y') + 1;
                            }

                        }


                        if (!empty($_GET['py']) || !empty($_GET['ny'])) {
                            if (!empty($_GET['py'])) {
                                $y = $_GET['py'];
                            }
                            if (!empty($_GET['ny'])) {
                                $y = $_GET['ny'];
                            }
                        } else {
                            $y = date('Y');
                        }
                        ?>

                        <a href="?py=<?php echo $py; ?>" class="content__calendar-prev">
                            <i class="fa fa-chevron-circle-left"></i>
                        </a>

                        <h2><?php echo $y; ?></h2>

                        <a href="?ny=<?php echo $ny; ?>" class="content__calendar-next">
                            <i class="fa fa-chevron-circle-right"></i>
                        </a>
                    </div>
                    <?php
                    $cy = date('Y');
                    if($cy==$y||$cy ==$y){
                        $cr_month = date('m');
                    }elseif($cy>$y){
                        $cr_month =12;
                    }else{
                        $cr_month = 0;
                    }

                    for ($i = 1; $i <= 12; $i++): ?>
                        <div class="content__calendar-month <?php echo ($i <= $cr_month) ? 'is-active' : ''; ?>">
                            <?php echo draw_calendar($i, $y); ?>
                        </div>
                    <?php endfor; ?>
                </div>
            <?php endif;

            if (!empty($_REQUEST['year']) && !empty($_REQUEST['month'] && !empty($_REQUEST['day']))) : ?>

                <?php
                $query = new WP_Query([
                    'post_type' => 'report',
                    'author__in' => [$u_id],
                    'posts_per_page' => 20,
                    'date_query' => [
                        [
                            'year' => $_REQUEST['year'],
                            'month' => $_REQUEST['month'],
                            'day' => $_REQUEST['day'],
                        ],
                    ],
                ]);
                $count = $query->post_count;
                if ($query->have_posts()):
                    echo "<ul>";
                    $i = 1;
                    while ($query->have_posts()) : $query->the_post(); ?>
                        <li class="is-active">
                            <a href="<?php the_permalink(); ?>">
                                <?php echo $i; ?>
                            </a>
                        </li>
                        <?php
                        $i++;
                    endwhile;
                    wp_reset_postdata();
                    for ($i = $count + 1; $i <= 20; $i++) {
                        echo "<li>$i</li>";
                    }
                    echo "</ul>";
                else:
                    echo "Not found";
                endif; ?>

            <?php endif; ?>
        </div>
    </main>

<?php
get_footer();