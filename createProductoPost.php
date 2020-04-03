<?php
 
// WordPress environment
require( dirname(__FILE__) . '/../../../wp-load.php' );



global $user_ID;
$titulo = '';



$titulo = $_POST['tituloProducto'];



if($titulo == ''){
  wp_redirect("/productos");  
}


$new_post = array(
  'post_title' => $titulo,
  'post_status' => 'publish',
  'post_date' => date('Y-m-d H:i:s'),
  'post_author' => $user_ID,
  'post_type' => 'postproductos'
  );
$post_id = wp_insert_post($new_post);






wp_redirect("/productos");
