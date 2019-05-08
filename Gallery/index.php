<?php
/*
 * Plugin Name: Portfolio Gallery Custom Plugin
 * version: 1.0
 * Description:  Portfolio Gallery Custom plugin used to show portfolio.
 * Author: XHTML Live
 *
 *
 */
//Configuration Section

//Include Section
function Zumper_widget_enqueue_script() {   
    wp_register_script( 'my_custom_script', plugin_dir_url( __FILE__ ) . 'js/custom.js', array('jquery'), '' );

    wp_register_style( 'custom-css',plugin_dir_url( __FILE__ ) . 'css/style.css','','', 'screen' );

     wp_enqueue_script( 'my_custom_script' );
     wp_enqueue_style( 'custom-css' );
}

add_action('wp_enqueue_scripts', 'Zumper_widget_enqueue_script',2000);

include_once "inc/func.inc.php";

//Action/Filter Hook Section
add_action("init","gallery_create_emp_post_type");

add_shortcode('portfolio', 'gallery_portfolio'); //Use it as [portfolio]
