<?php
/* Template Name: lista clientes */

?>


<?php
global $current_user;

get_currentuserinfo();
$role = implode(',', $current_user->roles);
$role .= '';
if (is_user_logged_in() == false){
   $login_page  = home_url( '/' );
   wp_safe_redirect($login_page);
}




get_header();
get_template_part('menu');
?>
<div id="mainContainer" class="backColorWhite relative z2" layout="column" layout-align="start center">
   
    
    <div class="cotizaciones content contentPad10 relative">
      <p class="title montseBold color2">Clientes</p>
      <div class="newCotHolder" >
        <form layout="column" action="<?php echo get_stylesheet_directory_uri() ?>/createClientePost.php" 
          method="post" enctype="multipart/form-data" class="shortWidth">
           <input type="text" name="nombreCliente" placeholder="Nombre del cliente" 
                value="">
           <input type="text" name="empresaCliente" placeholder="Nombre de su empresa" 
                value="">
           <input type="submit" name="submit" value="Crear nuevo"/>
        </form>
      
    </div>
  </div>
    


    <div class="cotizaciones content contentPad10 relative" layout="row" layout-wrap>
      <?php 
          $args = array(
             'author' =>  $current_user->ID,
             'order' => 'DSC',
             'orderby' => 'post_date',
             'post_status' => 'publish',
             'posts_per_page'=>'-1',
             'post_type'=>'postclientes'
          );
   
    $the_query = new WP_Query( $args ); 
    while ( $the_query->have_posts() ) : 
    $the_query->the_post(); 
    $post_id = get_the_ID();

    $empresa=get_post_field('clienteEmpPost', $post_id);
    $nombre=get_post_field('clienteNomPost', $post_id);

    
    ?>



        <div class="boxProducto relative" id="<?php echo $post_id?>">
           
           <form class="mainInfo" action="<?php echo get_stylesheet_directory_uri() ?>/manageClientePost.php" 
            method="post" enctype="multipart/form-data">
             <div class="infoHolder BR BRmargin0px20px0px0px">
               <p>Datos de cliente</p>
               <input type="text" name="nombreCliente" class="" placeholder="nombre" value="<?php echo $nombre;?>">
               <input type="text" name="empresaCliente" class="" placeholder="empresa" value="<?php echo $empresa;?>">
             </div>

             <input type="text" name="postid" hidden value="<?php echo $post_id?>">
             
             <input type="submit" name="submit" value="Guardar"/>
           </form>
           <form class="btnHolder alignBottom alignRight marginAuto" action="<?php echo get_stylesheet_directory_uri() ?>/duplicateClientePost.php" 
            method="post" enctype="multipart/form-data"  layout="row" layout-wrap>
             
             <div class="btnBox BR BRmargin10px12px0px0px" onclick="deletePost('<?php echo $post_id?>','<?php bloginfo("template_directory"); ?>')">
               <p >Borrar</p>
             </div>
             <input type="text" name="postToDuplicate" hidden value="<?php echo $post_id?>">
             <input type="text" name="title" hidden value="<?php the_title();?>">
             <input type="submit" name="submit" value="Duplicar"/>
           </form>
        </div>

    <?php wp_reset_postdata(); ?>
    <?php endwhile; ?>
    <?php wp_reset_query(); ?>
      
    </div>
    
    

    


  </div>

   <script>
   </script>
   
  

<?php get_footer();?>

