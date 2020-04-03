<?php
 
// WordPress environment
require( dirname(__FILE__) . '/../../../wp-load.php' );



global $user_ID;
$empresa = '';
$tel = '';
$correo = '';
$direccion = '';
$post_id = '';
$name = '';
$clienteEmp='';
$clienteNom='';
$fecha1='';
$fecha2='';
$desc='';
$notas='';
$iva='';
$moneda='';
$itemArray = '';
$titulo = '';

$post_id = $_POST['postToDuplicate'];
$titulo = $_POST['title'];

$telCot=get_post_field('telPost', $post_id);
$empresaCot=get_post_field('empresaPost', $post_id);
$dirCot=get_post_field('dirPost', $post_id);
$mailCot=get_post_field('mailPost', $post_id);
$srcCot=get_post_field('logoPost', $post_id);
$clienteEmp=get_post_field('clienteEmpPost', $post_id);
$clienteNom=get_post_field('clienteNomPost', $post_id);
$fecha1=get_post_field('fecha1Post', $post_id);
$fecha2=get_post_field('fecha2Post', $post_id);
$desc=get_post_field('descPost', $post_id);
$notas=get_post_field('notasPost', $post_id);
$iva=get_post_field('ivaPost', $post_id);
$moneda=get_post_field('monedaPost', $post_id);
$itemArray=get_post_field('itemPost', $post_id);


$new_post = array(
       'post_title' => $titulo.' -Duplicado',
       'post_content' => '',
       'post_status' => 'publish',
       'post_date' => date('Y-m-d H:i:s'),
       'post_author' => $user_ID,
       'post_type' => 'postcotis',
);
$new_id = wp_insert_post($new_post);

if ($new_id) {
  // insert post meta
  add_post_meta($new_id, 'logoPost', $srcCot);
  add_post_meta($new_id, 'dirPost', $direccion);
  add_post_meta($new_id, 'telPost', $tel);
  add_post_meta($new_id, 'mailPost', $correo);
  add_post_meta($new_id, 'empresaPost', $empresa);
  add_post_meta($new_id, 'clienteEmpPost', $clienteEmp);
  add_post_meta($new_id, 'clienteNomPost', $clienteNom);
  add_post_meta($new_id, 'fecha1Post', $fecha1);
  add_post_meta($new_id, 'fecha2Post', $fecha2);
  add_post_meta($new_id, 'descPost', $desc);
  add_post_meta($new_id, 'notasPost', $notas);
  add_post_meta($new_id, 'ivaPost', $iva);
  add_post_meta($new_id, 'monedaPost', $moneda);
  add_post_meta($new_id, 'itemPost', $itemArray);
}
wp_redirect("/cotizaciones");
