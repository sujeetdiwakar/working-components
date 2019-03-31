<?php

function videoType($url)
{

    if (strpos($url, 'youtube') > 0) {

        parse_str(parse_url($url, PHP_URL_QUERY), $params);

        return '<iframe src="https://www.youtube.com/embed/' . $params['v'] . '?autoplay=0&mute=1&loop=1&" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>';
    } elseif (strpos($url, 'vimeo') > 0) {

        $video_id = (int)substr(parse_url($url, PHP_URL_PATH), 1);

        return '<iframe src="//player.vimeo.com/video/' . $video_id . '?byline=0&amp;portrait=0" width="500" height="400" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>';
    }
}

add_action('wp_ajax_load_more_vacancy_by_ajax', 'more_vacancy');
add_action('wp_ajax_nopriv_load_more_vacancy_by_ajax', 'more_vacancy');

function more_vacancy()
{
    $paged = $_POST['page'];
    $args = [
        'post_type' => 'vacancy',
        'posts_per_page' => 5,
        'paged' => $paged,
    ];

    $my_posts = new WP_Query($args);

    if ($my_posts->have_posts()) {

        while ($my_posts->have_posts()): $my_posts->the_post();
            get_template_part('template-parts/loop', 'vacancy');
        endwhile;
        wp_reset_postdata();
    }
    die();
}

add_action('wp_ajax_load_posts_by_ajax', 'load_posts_by_ajax_callback');
add_action('wp_ajax_nopriv_load_posts_by_ajax', 'load_posts_by_ajax_callback');
function load_posts_by_ajax_callback()
{

    $cat_slug = $_POST['cat'];
    $postcode = $_POST['postcode'];
    if (!empty($postcode)) {
        $args = [
            'post_type' => 'location',
            'meta_query' => [
                [
                    'key' => 'location_postcode',
                    'value' => $postcode,
                ],
            ],
        ];
    }
    if (!empty($cat_slug)) {
        $args = [
            'post_type' => 'location',
            'tax_query' => [
                [
                    'taxonomy' => 'location_cat',
                    'terms' => $cat_slug,
                    'field' => 'slug',
                ],
            ],
        ];
    }
    $my_posts = new WP_Query($args);

    if ($my_posts->have_posts()) {

        ?>
        <div class="maps" data-zoom="12">
            <?php while ($my_posts->have_posts()): $my_posts->the_post();
                $location = get_field('google_map'); ?>
                <div class="marker" data-lat="<?php echo $location['lat']; ?>"
                     data-lng="<?php echo $location['lng']; ?>"
                     data-marker-icon="<?php echo get_theme_file_uri('dist/img/marker.png'); ?>">
                    <div class="maps__infobox">
                        <?php
                        $terms = get_the_terms(get_the_ID(), 'location_cat');

                        foreach ($terms as $term):?>
                            <h3><?php echo $term->name; ?></h3>
                        <?php endforeach; ?>
                        <strong><?php the_title(); ?></strong>

                        <address>
                            <?php the_field('location_address'); ?>
                        </address>
                        <a class="button" href="<?php the_permalink(); ?>"><?php _t('Bekijk vestiging'); ?></a>
                    </div>
                </div>
            <?php endwhile;
            wp_reset_postdata(); ?>
        </div>
        <script type="text/javascript">
            jQuery(document).ready(function ($) {
                $('.maps').maps({
                    map: {
                        disableDefaultUI: true,
                        zoomControl: true
                    },
                    infobox: {
                        closeBoxMargin: '-15px -15px 0px 0px',
                        closeBoxURL: 'https://www.google.com/intl/en_us/mapfiles/close.gif',
                        pixelOffset: new google.maps.Size(-30, -70),
                        alignBottom: true
                    }
                });
            });

            (function ($) {
                var maps_functions = {
                    map: null,
                    map_obj: null,
                    options: null,
                    markers: null,
                    zoom_level: null,

                    init: function (map_obj, options) {
                        // Variables
                        var _this = this;
                        _this.map_obj = map_obj;
                        _this.options = options !== undefined ? options : {};
                        _this.markers = map_obj.find('.marker');
                        _this.zoom_level = _this.map_obj.attr('data-zoom') !== undefined ? parseInt(_this.map_obj.attr('data-zoom')) : 14;

                        // Map options
                        var args = {
                            zoom: _this.zoom_level,
                            center: new google.maps.LatLng(0, 0),
                            mapTypeId: google.maps.MapTypeId.ROADMAP,
                            scrollwheel: false
                        };

                        if (_this.options.map !== undefined) {
                            $.extend(args, _this.options.map);
                        }

                        // Create map
                        _this.map = new google.maps.Map(_this.map_obj[0], args);

                        // Add a markers reference
                        _this.map.markers = [];

                        // Add markers
                        _this.markers.each(function () {
                            _this.add_marker($(this));
                        });

                        // Center map
                        this.center_map();
                    },
                    add_marker: function (marker_obj) {
                        // Variables
                        var _this = this;
                        var latlng = new google.maps.LatLng(marker_obj.attr('data-lat'), marker_obj.attr('data-lng'));
                        var cursor = $('.maps__infobox', marker_obj).length > 0 ? 'pointer' : 'default';

                        // Create marker
                        var marker = new google.maps.Marker({
                            position: latlng,
                            map: _this.map,
                            cursor: cursor,
                            icon: marker_obj.attr('data-marker-icon')
                        });

                        // Add to array
                        _this.map.markers.push(marker);

                        // If marker contains HTML, add it to an infobox
                        if ($('.maps__infobox', marker_obj).length > 0) {
                            // Infobox options
                            var args = {
                                content: $('.maps__infobox', marker_obj).html(),
                                boxClass: 'maps__infobox'
                            };

                            if (_this.options.infobox !== undefined) {
                                $.extend(args, _this.options.infobox);
                            }

                            // Create infobox
                            _this.map.markers[_this.map.markers.length - 1].infobox = new InfoBox(args);

                            // Show infobox when marker is clicked
                            google.maps.event.addListener(_this.map.markers[_this.map.markers.length - 1], 'click', function () {
                                var current_marker = this;

                                $.each(_this.map.markers, function (index, marker) {
                                    // If marker is not clicked, close marker
                                    if (_this.map.markers[index] !== current_marker) {
                                        _this.map.markers[index].infobox.close();
                                    }
                                });

                                this.infobox.open(_this.map, this);
                            });
                        }
                    },

                    center_map: function () {
                        // Variables
                        var _this = this;
                        var bounds = new google.maps.LatLngBounds();

                        // Loop through all markers and create bounds
                        $.each(_this.map.markers, function (i, marker) {
                            var latlng = new google.maps.LatLng(marker.position.lat(), marker.position.lng());
                            bounds.extend(latlng);
                        });

                        // Only 1 marker?
                        if (_this.map.markers.length === 1) {
                            // Set center of map
                            _this.map.setCenter(bounds.getCenter());
                        } else {
                            // Fit to bounds
                            _this.map.fitBounds(bounds);
                        }
                    }
                };

                $.fn.maps = function (options) {
                    if (this.length > 0) {
                        return maps_functions.init(this, options);
                    }
                };
            }(jQuery));
        </script>
    <?php }
    wp_die();
}


add_action('wp_ajax_load_filter_by_ajax_check','load_call');
add_action('wp_ajax_nopriv_load_filter_by_ajax_check','load_call');
function load_call(){
    $cat_slug = $_POST['cat'];
    $term = get_term_by('slug', $cat_slug, 'location_cat');
    $name = $term->name;
    $desc = $term->description;
    echo "<h2>$name</h2>";
    echo "<p>$desc</p>";
    die();
}

add_action('wp_ajax_load_filter_by_ajax_list','data_list');
add_action('wp_ajax_nopriv_load_filter_by_ajax_list','data_list');
function data_list(){
    echo "<h2>DESc</h2>";
    die();
}