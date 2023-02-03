<?php
$title = $_GET['title'];
$description = $_GET['description'];
$url = $_GET['url'];
$id = $_GET['id'];

include '../../../wp-load.php';

$new_post = array(
    'post_title' => $id,
    'post_status'   => 'publish',
    'post_type'     => 'pruduct-application'
);

$postId = wp_insert_post($new_post);
add_post_meta( $postId, 'application_title', $title, true );
add_post_meta( $postId, 'application_url', $url, true );
echo $postId;
?>