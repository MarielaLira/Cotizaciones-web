<?php
/* 
Template Name: contacto
*/ 

?>

<?php


get_header();
get_template_part('menu');
?>
<div id="mainContainer" class="backColorWhite relative z2" layout="column" layout-align="start center">
  <div class="content contentPad10 relative">
    <p class="title montseBold color2">Contacto</p>
  </div>

  <div class="content contentPad10 relative">
    <div class="fullWidth height500 height600Md backColorGray ">
      <div class="colContent width95 height400  floatRight padTop100 padTop20Md padTop80Sm">
         <p class="montseBold color2 textCenter fontSize25">Ponte en contacto con nosotros.</p>
         <br>
         <br>
         <?php 
           echo do_shortcode('[contact-form-7 id="341" title="contacto"]');
         ?>
      </div>
    </div>
  </div>
 </div>
</div>

<?php get_footer(); //include('/footer.php'); ?>
