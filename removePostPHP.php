<?php
    require_once('../../../wp-load.php');
    require_once( ABSPATH . 'wp-admin/includes/image.php' );

    global $user_ID;
    $postid = $_POST['id'];

    wp_delete_post($postid, true);



?>