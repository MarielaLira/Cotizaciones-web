<?php
/* Template Name: cuenta */

?>

<?php
global $current_user;
global $user_ID;
get_currentuserinfo();
$role = implode(',', $current_user->roles);
$role .= '';
if (is_user_logged_in() == false){
   $login_page  = home_url( '/' );
   wp_safe_redirect($login_page);
}

get_header();
get_template_part( 'menu' );


$name = $current_user->data->user_login;
$post_id = get_page_by_title( $name.' '.$user_ID, OBJECT, 'postcuentas' )->ID;  
if($post_id == null){
  $new_post = array(
  'post_title' => $name.' '.$user_ID,
  'post_status' => 'publish',
  'post_date' => date('Y-m-d H:i:s'),
  'post_author' => $user_ID,
  'post_type' => 'postcuentas'
  );
  $post_id = wp_insert_post($new_post);
}

$src=get_post_field('logoPost', $post_id);
$tel=get_post_field('telPost', $post_id);
$empresa=get_post_field('empresaPost', $post_id);
$dir=get_post_field('dirPost', $post_id);
$mail=get_post_field('mailPost', $post_id);





?>
<div id="mainContainer" class="backColorWhite relative z2" layout="column" layout-align="start center">
   
   <div id="cuenta" class="content contentPad10 relative">
     

   	 <p class="title montseBold color2">Información de cuenta</p>
     
     <p class="color2 BR BRmargin20px0px0px0px">Usuario:</p>
     <p class="color2 montseBold fontSize25" id="cuentaUser"><?php echo $name ?></p>
     <br>

     <div id="userID" class="hide"><?php echo $user_ID ?></div>

     <p class="color2">Logo:</p>
     <img id="logoHolder" class="logo smallImg" src="<?php echo $src?>"/>
    <form class="shortWidth" action="<?php echo get_stylesheet_directory_uri() ?>/manageCuentaPost.php" method="post" enctype="multipart/form-data">

    	<p class="color2 BR BRmargin20px0px0px0px">Subir logo:</p>
	    <input type="file" name="profilepicture" id="cuentaLogo" size="25" />
	    <input type="text" hidden name="loadpicture" id="cuentaLogoHide" value="<?php echo $src?>" />
	    
	    <p class="color2 BR BRmargin20px0px0px0px">Nombre de la empresa:</p>
	    <input id="cuentaEmpresa" type="text"  name="empresa" placeholder="Nombre de empresa" value="<?php echo $empresa?>">
        
	    <p class="color2 BR BRmargin20px0px0px0px">Datos de la empresa:</p>
        <input type="text" id="telEmpresaCotizacion" name="telEmpresaCotizacion" placeholder="telefono" value="<?php echo $tel?>">
        <input type="text" id="direccionEmpresaCotizacion" name="direccionEmpresaCotizacion" placeholder="dirección" value="<?php echo $dir?>">
        <input type="text" id="correoEmpresaCotizacion" name="correoEmpresaCotizacion" placeholder="correo" value="<?php echo $mail?>">

	    <input id="userName" type="text" hidden name="user" value="<?php echo $current_user->data->user_login ?>">
	    <input id="postid" type="text" hidden name="postid" value="<?php echo $post_id?>">

	    <input type="submit" name="submit" value="Guardar"/>
    </form>
    

   </div>
</div>


  

<?php get_footer();?>

