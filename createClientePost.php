<?php
 
// WordPress environment
require( dirname(__FILE__) . '/../../../wp-load.php' );



global $user_ID;
$nombre = '';
$empresa = '';


$nombre = $_POST['nombreCliente'];
$empresa = $_POST['empresaCliente'];


if($nombre == ''){
  wp_redirect("/clientes");  
}


$new_post = array(
  'post_title' => $nombre,
  'post_status' => 'publish',
  'post_date' => date('Y-m-d H:i:s'),
  'post_author' => $user_ID,
  'post_type' => 'postclientes'
  );
$post_id = wp_insert_post($new_post);

if ($post_id) {
  // insert post meta
  add_post_meta($post_id, 'clienteNomPost', $nombre);
  add_post_meta($post_id, 'clienteEmpPost', $empresa);
}




wp_redirect("/clientes");
