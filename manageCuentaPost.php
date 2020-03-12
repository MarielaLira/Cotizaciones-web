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



$empresa = $_POST['empresa'];
$tel = $_POST['telEmpresaCotizacion'];
$correo = $_POST['correoEmpresaCotizacion'];
$direccion = $_POST['direccionEmpresaCotizacion'];
$post_id = $_POST['postid'];
$name = $_POST['user'];

$profilepicture = $_FILES['profilepicture'];
$profilepictureLoad = $_POST['loadpicture'];

if($post_id == null || $post_id == ''){
  $post_id = get_page_by_title( $name.' '.$user_ID, OBJECT, 'postcuentas' )->ID;  
}





if($profilepicture['tmp_name'] != ''){

$wordpress_upload_dir = wp_upload_dir();
// $wordpress_upload_dir['path'] is the full server path to wp-content/uploads/2017/05, for multisite works good as well
// $wordpress_upload_dir['url'] the absolute URL to the same folder, actually we do not need it, just to show the link to file
$i = 1; // number of tries when the file with the same name already exists
 

$new_file_path = $wordpress_upload_dir['path'] . '/' . $profilepicture['name'];
$new_file_mime = mime_content_type( $profilepicture['tmp_name'] );
 
if( empty( $profilepicture ) ){
	die( 'Archivo no seleccionado.' );
    wp_redirect("/cuenta");
}
 
if( $profilepicture['error'] ){
	die( $profilepicture['error'] );
    wp_redirect("/cuenta");
}
 
if( $profilepicture['size'] > wp_max_upload_size() ){
	die( 'Archivo muy grande.' );
	wp_redirect("/cuenta");
}
 
if( !in_array( $new_file_mime, get_allowed_mime_types() ) ){
	die( 'Archivo no permitido' );
	wp_redirect("/cuenta");
}
 
while( file_exists( $new_file_path ) ) {
	$i++;
	$new_file_path = $wordpress_upload_dir['path'] . '/' . $i . '_' . $name.' '.$user_ID;
}
 
// looks like everything is OK
if( move_uploaded_file( $profilepicture['tmp_name'], $new_file_path ) ) {
 
 
	$upload_id = wp_insert_attachment( array(
		'guid'           => $new_file_path, 
		'post_mime_type' => $new_file_mime,
		'post_title'     => preg_replace( '/\.[^.]+$/', '', $name.' '.$user_ID ),
		'post_content'   => '',
		'post_status'    => 'inherit'
	), $new_file_path );
 
	// wp_generate_attachment_metadata() won't work if you do not include this file
	require_once( ABSPATH . 'wp-admin/includes/image.php' );
 
	// Generate and save the attachment metas into the database
	wp_update_attachment_metadata( $upload_id, wp_generate_attachment_metadata( $upload_id, $new_file_path ), $post_id );
 
	// Show the uploaded file in browser
	//wp_redirect( $wordpress_upload_dir['url'] . '/' . basename( $new_file_path ) );






    if ($post_id) {
       // insert post meta
       update_post_meta($post_id, 'logoPost', $wordpress_upload_dir['url'] . '/' . basename( $new_file_path ));
       update_post_meta($post_id, 'dirPost', $direccion);
       update_post_meta($post_id, 'telPost', $tel);
       update_post_meta($post_id, 'mailPost', $correo);
       update_post_meta($post_id, 'empresaPost', $empresa);
    }

    
    wp_redirect("/cuenta");
}

}
else{
	  if($profilepictureLoad != '' && $profilepictureLoad != null){
      $temp = $profilepictureLoad;
    }
    else{
      $temp = '';
    }

    if ($post_id) {
       // insert post meta
       update_post_meta($post_id, 'logoPost', $temp);
       update_post_meta($post_id, 'dirPost', $direccion);
       update_post_meta($post_id, 'telPost', $tel);
       update_post_meta($post_id, 'mailPost', $correo);
       update_post_meta($post_id, 'empresaPost', $empresa);
    }

    wp_redirect("/cuenta");
}