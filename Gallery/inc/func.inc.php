<?php

function gallery_create_emp_post_type() {
	$labels = [
		"name"         => "Portfolio Gallery",
		"add_new"      => "Add New",
		"add_new_item" => "Add New",
		"edit_item"    => "Edit",
		"search_items" => "Search Portfolio",
		"view_item"    => "View Portfolio",
		"not_found"    => "No Portfolio found"
	];
	$args   = [
		"labels"   => $labels,
		"public"   => true,
		"supports" => [ "title", "editor" ]
	];
	register_post_type( "gallery", $args );
}

function gallery_portfolio($attr)
{
	
$args = array(
    'post_type' => 'gallery'
);
 

$query = new WP_Query( $args );
 

if ( $query->have_posts() ) {
 echo "<ul  class='green'><li>All</li>";
    
    while ( $query->have_posts() ) {
 
        $query->the_post();
        echo "<li>";
 		the_title();
 		echo "</li>";
    }
 echo "</ul>";
}

if ( $query->have_posts() ) {
 echo "<ul>";
    $i=1;
    while ( $query->have_posts() ) {
 
        $query->the_post();
        echo "<li class='$i'>";
 		$gallery = get_post_gallery( get_the_ID(), false );
		$ids = explode( ",", $gallery['ids'] );

		echo '<div class="images ">';
		foreach( $ids as $id ) {
		    //Change "full" with the image size identifier you want to get
		    $src   = wp_get_attachment_image_src( $id, "full" );

		    
		    echo '<a href="'.$src[0].'">';
		    echo '<img src="'.$src[0].'" width="'.$src[1].'" height="'.$src[2].'">';
		    echo '</a>';
		   
		    
		    
		} 
		echo '</div>';
 		echo "</li>";
 		$i++;
    }
 echo "</ul>";
}

wp_reset_postdata();
	echo "hello from custom plugin";
}


?>
