<?php

global $user_ID;
require_once( ABSPATH . 'wp-admin/includes/image.php' );
require_once( ABSPATH . 'wp-admin/includes/file.php' );
require_once( ABSPATH . 'wp-admin/includes/media.php' );

global $_GET;
var_dump($_GET['my_file_upload'])
$attach_id = media_handle_upload('my_file_upload', 160);
var_dump($attach_id);
if (is_numeric($attach_id)) {
    update_option('option_image', $attach_id);
    update_post_meta($post_id, '_my_file_upload', $attach_id);
}

?>