
<div id="smallMenu" class="backColor1 alignTop">
  <div onclick="openMenu();" class="svgHolder"><img class="svg svgColor2" src="<?php bloginfo('template_directory'); ?>/assets/images/svgs/menu.svg"></div>
</div>
<div id="menuShadow" class="shadow fullWidth fullHeight"></div>
<div id="menu" class="backColor2 relative" >
  <div  class="titleHolder backColor1">
    <div onclick="closeMenu();" class="svgHolder"><img class="svg svgColor2" src="<?php bloginfo('template_directory'); ?>/assets/images/svgs/cross.svg"></div>
  </div>
  <?php 
  global $current_user;

  get_currentuserinfo();
  $role = implode(',', $current_user->roles);
  $role .= '';
  if (is_user_logged_in() == true){
  ?>
  <a href="/cuenta"><p class="option color1">Mi Cuenta</p></a>
  <a href="/cotizaciones"><p class="option color1">Cotizaciones</p></a>
  <a href="/productos"><p class="option color1">Productos</p></a>
  <a href="/clientes"><p class="option color1">Clientes</p></a>
  <a href="/estadisticas"><p class="option color1">Estadisticas</p></a>
  <!-- <a href="/cotizacion"><p class="option color1">Crear Cotización</p></a> -->
  <a href="<?php echo wp_logout_url( home_url('/cotizacion/') ); ?>"><p class="option color1">Salir</p></a>

  <?php 
  }
  if (is_user_logged_in() == false){
  ?>
  <a href="/"><p class="option color1">Inicio</p></a>
  <a href="/wp-login.php?action=register"><p class="option color1">Registro</p></a>
  <?php }?>
  <a href="/contacto"><p class="option color1">Contacto</p></a>
  
  <?php
  if ($role == 'administrator'){
  ?>
  <a href="/wp-admin/"><p class="option color1">Admin Panel</p></a>
  <?php 
  }

  ?>
  <div class="division backColor1 "></div>
</div>