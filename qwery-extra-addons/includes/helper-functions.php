<?php
function qwery_drop_posts($post_type='post'){
    $args = array(
        'numberposts' => -1,
        'post_type'   => $post_type
    );

    $posts = get_posts( $args );
    $list = array();
    foreach ($posts as $cpost){
        $list[$cpost->ID] = $cpost->post_title;
    }
    return $list;
}
function qwery_drop_cat($tax='category') {
    $args = [
        'taxonomy' => $tax,
        'hide_empty' => false,
        'hierarchical' => true,
        'orderby'       => 'name',
        'order'         => 'DESC',
    ];
    $categories_obj = get_categories($args);
    $categories = array();

    foreach ($categories_obj as $pn_cat) {
        $categories[$pn_cat->cat_ID] = $pn_cat->cat_name;
    }
    return $categories;
}