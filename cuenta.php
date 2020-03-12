<?php
/* Template Name: cuenta */

?>

<?php

get_header();
get_template_part( 'menu' );




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

