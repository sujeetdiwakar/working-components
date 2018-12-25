<?php
/*https://www.kathyisawesome.com/alphabetical-posts-glossary/(helping website)
 *https://wordpress.stackexchange.com/questions/41660/group-posts-by-first-letter-of-title(helping website)
 *Group Posts by First Letter of Title
 */

// Add new taxonomy, NOT hierarchical (like tags)
function content_create_glossary_taxonomy(){
    if(!taxonomy_exists('alpha_cat')){
        register_taxonomy('alpha_cat',array('glossary'),array(
            'show_ui' => false
        ));
    }
}
add_action('init','content_create_glossary_taxonomy');


/* When the post is saved, saves our custom data */
function content_save_first_letter( $post_id ) {
    // verify if this is an auto save routine.
    // If it is our form has not been submitted, so we dont want to do anything
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
        return $post_id;

    //check location (only run for posts)
    $limitPostTypes = array('glossary');
    if (!in_array($_POST['post_type'], $limitPostTypes))
        return $post_id;

    // Check permissions
    if ( !current_user_can( 'edit_post', $post_id ) )
        return $post_id;

    // OK, we're authenticated: we need to find and save the data
    $taxonomy = 'alpha_cat';

    //set term as first letter of post title, lower case
    wp_set_post_terms( $post_id, strtolower(substr($_POST['post_title'], 0, 1)), $taxonomy );

    //delete the transient that is storing the alphabet letters
    delete_transient( 'kia_archive_alphabet');
}
add_action( 'save_post', 'content_save_first_letter' );



//create array from existing posts
function content_run_once(){

    //if ( false === get_transient( 'kia_run_once' ) ) {

    $taxonomy = 'alpha_cat';
    $alphabet = array();

    $posts = get_posts(array('post_type'=>'glossary','numberposts' => -1) );

    foreach( $posts as $p ) :
        //set term as first letter of post title, lower case
        wp_set_object_terms( $p->ID, strtolower(substr($p->post_title, 0, 1)), $taxonomy,true );
    endforeach;

    //set_transient( 'kia_run_once', 'true' );

    //}

}
add_action('init','content_run_once');
