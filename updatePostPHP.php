<?php
    require_once('../../../wp-load.php');
    require_once( ABSPATH . 'wp-admin/includes/image.php' );

    global $user_ID;
    $id = $_POST['postId'];
    $viewPref = $_POST['viewPref'];
    $name = $_POST['name'];
    $cat = $_POST['cat'];
    $image = $_POST['img'];

    
    $new_post = array(
       'ID' =>  $id,
       'post_title' => $name,
       'post_content' => $viewPref,
       'post_status' => 'publish',
       'post_date' => date('Y-m-d H:i:s'),
       'post_author' => $user_ID,
       'post_type' => 'post',
       'post_category' => array($cat)
    );
    wp_update_post($new_post);
    





?>