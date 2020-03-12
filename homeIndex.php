
<?php
/* 
Template Name: home
*/ 

?>

<?php


get_header();
get_template_part( 'menu' ); 
$login  = (isset($_GET['login']) ) ? $_GET['login'] : 0;
?>

<div id="mainContainer" class="relative z2" >
   
   <div class="formlogin marginAuto alignCenter " layout="column" layout-align="center center">
    <!-- <h2 class="textUpper colorWhite">Iniciar Sesión</h2> -->
    <br>
    <br>
    <?php
     if ( $login === "failed" ) {
       echo '<p class="login-msg colorWhite">Invalid username and/or password.</p><br>';
     } elseif ( $login === "empty" ) {
       echo '<p class="login-msg colorWhite">Username and/or Password is empty.</p><br>';
     } elseif ( $login === "false" ) {
       echo '<p class="login-msg colorWhite">You are logged out.</p><br>';
     }

     $args = array(
         'redirect' => home_url('/cuenta/'), 
         'id_username' => 'user',
         'id_password' => 'pass',
        );
     ?>
     <?php wp_login_form( $args ); ?>
  </div>

</div>


<?php get_footer();?>
