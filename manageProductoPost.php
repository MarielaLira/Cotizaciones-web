<?php
 
// WordPress environment
require( dirname(__FILE__) . '/../../../wp-load.php' );



global $user_ID;
$precio = '';
$post_id = '';
$desc='';
$titulo = '';

$precio = $_POST['precio'];
$post_id = $_POST['postid'];
$name = $current_user->data->user_login;
$desc=$_POST['desc'];
$titulo = $_POST['title'];


$new_post = array(
       'ID' =>  $post_id,
       'post_title' => $titulo,
       'post_status' => 'publish',
       'post_date' => date('Y-m-d H:i:s'),
       'post_author' => $user_ID,
       'post_type' => 'postproductos',
    );
    wp_update_post($new_post);

if ($post_id) {
  // insert post meta
  update_post_meta($post_id, 'descPost', $desc);
  update_post_meta($post_id, 'precioPost', $precio);
}
wp_redirect("/productos");
