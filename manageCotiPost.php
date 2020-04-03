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
$status = '';

$titulo = $_POST['tituloCotizacion'];
$empresa = $_POST['nombreEmpresaCotizacion'];
$tel = $_POST['telEmpresaCotizacion'];
$correo = $_POST['correoEmpresaCotizacion'];
$direccion = $_POST['direccionEmpresaCotizacion'];
$post_id = $_POST['postId'];
$name = $current_user->data->user_login;
$clienteEmp=$_POST['nombreEmpresaClienteCotizacion'];
$clienteNom=$_POST['personaDirijidaCotizacion'];
$fecha1=$_POST['fechaCotizacion'];
$fecha2=$_POST['fechaPagoCotizacion'];
$desc=$_POST['resumenCotizacion'];
$notas=$_POST['notasCotizacion'];
$iva=$_POST['ivaCotizacion'];
$moneda=$_POST['monedaCotizacion'];
$itemArray = $_POST['itemArray'];
$status = $_POST['status'];


$new_post = array(
       'ID' =>  $post_id,
       'post_title' => $titulo,
       'post_status' => 'publish',
       'post_date' => date('Y-m-d H:i:s'),
       'post_author' => $user_ID,
       'post_type' => 'postcotis',
    );
    wp_update_post($new_post);

if ($post_id) {
  // insert post meta
  update_post_meta($post_id, 'logoPost', $srcCot);
  update_post_meta($post_id, 'dirPost', $direccion);
  update_post_meta($post_id, 'telPost', $tel);
  update_post_meta($post_id, 'mailPost', $correo);
  update_post_meta($post_id, 'empresaPost', $empresa);
  update_post_meta($post_id, 'clienteEmpPost', $clienteEmp);
  update_post_meta($post_id, 'clienteNomPost', $clienteNom);
  update_post_meta($post_id, 'fecha1Post', $fecha1);
  update_post_meta($post_id, 'fecha2Post', $fecha2);
  update_post_meta($post_id, 'descPost', $desc);
  update_post_meta($post_id, 'notasPost', $notas);
  update_post_meta($post_id, 'ivaPost', $iva);
  update_post_meta($post_id, 'monedaPost', $moneda);
  update_post_meta($post_id, 'itemPost', $itemArray);
  update_post_meta($post_id, 'statusPost', $status);
}
wp_redirect("/cotizacion?id=".$post_id);
