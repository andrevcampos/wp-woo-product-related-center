<?php

$id = $_GET['id'];

include '../../../wp-load.php';

global $wpdb;
$wpdb->get_results("DELETE FROM `" . $wpdb->prefix . "posts` where ID = $id");
$wpdb->get_results("DELETE FROM `" . $wpdb->prefix . "postmeta` where post_id=$id");
?>