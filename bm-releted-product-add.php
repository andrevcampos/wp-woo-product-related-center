<?php
$title = $_GET['related_product_title'];
$ppostid = $_GET['related_product_ppostid'];
$postid = $_GET['related_product_postid'];
echo $title . " " . $ppostid . " " . $postid . "- ";
include '../../../wp-load.php';
$new_post = array(
    'post_title' => "$postid",
    'post_status'   => 'publish',
    'post_type'     => 'pruduct-relatedp'
);

$postId2 = wp_insert_post($new_post);
add_post_meta( $postId2, 'related_product_title', $title, true );
add_post_meta( $postId2, 'related_product_ppostid', $ppostid, true );
echo $postId2;
?>