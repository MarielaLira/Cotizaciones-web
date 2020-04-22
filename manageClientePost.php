<?php
 
// WordPress environment
require( dirname(__FILE__) . '/../../../wp-load.php' );



global $user_ID;
$post_id = '';
$nombre = '';
$empresa = '';


$nombre = $_POST['nombreCliente'];
$empresa = $_POST['empresaCliente'];

$post_id = $_POST['postid'];


$new_post = array(
       'ID' =>  $post_id,
       'post_title' => $nombre,
       'post_status' => 'publish',
       'post_date' => date('Y-m-d H:i:s'),
       'post_author' => $user_ID,
       'post_type' => 'postclientes',
    );
    wp_update_post($new_post);

if ($post_id) {
  // insert post meta
  update_post_meta($post_id, 'clienteNomPost', $nombre);
  update_post_meta($post_id, 'clienteEmpPost', $empresa);
}
wp_redirect("/clientes");
