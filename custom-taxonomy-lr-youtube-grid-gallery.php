<?php
add_action( 'init', 'lryg_register_taxonomy_category_videos' );
function lryg_register_taxonomy_category_videos() {
    $labels = array(
	    'name' => __( 'Categories', 'lr-youtube-grid-gallery' ),
	    'singular_name' => __( 'Category', 'lr-youtube-grid-gallery' ),
	    'search_items' => __( 'Search Category', 'lr-youtube-grid-gallery' ),
	    'popular_items' => __( 'Category Popular', 'lr-youtube-grid-gallery' ),
	    'all_items' => __( 'All Category', 'lr-youtube-grid-gallery' ),
	    'parent_item' => __( 'Parent Category', 'lr-youtube-grid-gallery' ),
	    'parent_item_colon' => __( 'Parent Category:', 'lr-youtube-grid-gallery' ),
	    'edit_item' => __( 'Edit Category', 'lr-youtube-grid-gallery' ),
	    'update_item' => __( 'Update Category', 'lr-youtube-grid-gallery' ),
	    'add_new_item' => __( 'Add New Category', 'lr-youtube-grid-gallery' ),
	    'new_item_name' => __( 'New Category', 'lr-youtube-grid-gallery' ),
	    'add_or_remove_items' => __( 'Add or remove Category', 'lr-youtube-grid-gallery' ),
	    'choose_from_most_used' => __( 'Choose from the most used Category', 'lr-youtube-grid-gallery' ),
	    'menu_name' => __( 'Categories', 'lr-youtube-grid-gallery' ),
    );
    $args = array(
	    'labels' => $labels,
	    'public' => true,
	    'show_in_nav_menus' => true,
	    'show_ui' => true,
	    'show_tagcloud' => true,
	    'show_admin_column' => true,
	    'hierarchical' => true,
	    'rewrite' => true,
	    'query_var' => true
    );
register_taxonomy( 'youtube-category', array('lr-youtube-gallery'), $args );
}