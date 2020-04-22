<?php
 
// WordPress environment
require( dirname(__FILE__) . '/../../../wp-load.php' );



global $user_ID;

$post_id = $_POST['postToDuplicate'];
$titulo = $_POST['title'];

$clienteEmp=get_post_field('clienteEmpPost', $post_id);
$clienteNom=get_post_field('clienteNomPost', $post_id);


$new_post = array(
       'post_title' => $titulo.' -Duplicado',
       'post_content' => '',
       'post_status' => 'publish',
       'post_date' => date('Y-m-d H:i:s'),
       'post_author' => $user_ID,
       'post_type' => 'postclientes',
);
$new_id = wp_insert_post($new_post);

if ($new_id) {
  // insert post meta
  add_post_meta($new_id, 'clienteEmpPost', $clienteEmp);
  add_post_meta($new_id, 'clienteNomPost', $clienteNom.' -Duplicado');
}
wp_redirect("/clientes");
