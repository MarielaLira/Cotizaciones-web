<?php
/* Template Name: lista Productos */

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

// if(isset($_POST['tituloCotizacion'])){
//   global $user_ID;

//   $new_post = array(
//   'post_title' => $_POST['tituloCotizacion'],
//   'post_content' => '',
//   'post_status' => 'publish',
//   'post_date' => date('Y-m-d H:i:s'),
//   'post_author' => $user_ID,
//   'post_type' => 'post',
//   'post_category' => array(2)
//   );
//   $post_id = wp_insert_post($new_post);
// }


get_header();
get_template_part('menu');
?>
<div id="mainContainer" class="backColorWhite relative z2" layout="column" layout-align="start center">
   
    
    <div class="cotizaciones content contentPad10 relative">
      <p class="title montseBold color2">Productos</p>
      <div class="newCotHolder" >
        <form layout="row" action="<?php echo get_stylesheet_directory_uri() ?>/createProductoPost.php" method="post" enctype="multipart/form-data" class="shortWidth">
           <input type="text" name="tituloProducto" placeholder="Nombre de Producto" 
                value="">
           <input type="submit" name="submit" value="Crear nuevo"/>
        </form>
        <!-- <div class="btn btnBox backColor2" onclick="createCotName('<?php bloginfo("template_directory"); ?>')">
          <p  class="textCenter">Crear nueva</p>
        </div> -->
      
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
             'post_type'=>'postproductos'
          );
   
    $the_query = new WP_Query( $args ); 
    while ( $the_query->have_posts() ) : 
    $the_query->the_post(); 
    if ( has_post_thumbnail() ) { 
      $thumb_id = get_post_thumbnail_id();
      $thumb_url_array = wp_get_attachment_image_src($thumb_id, 'full', true);
      $thumb_url = $thumb_url_array[0];
    }
    $post_id = get_the_ID();

    $desc=get_post_field('descPost', $post_id);
    $precio=get_post_field('precioPost', $post_id);

    
    ?>



        <div class="boxProducto relative" id="<?php echo $post_id?>">
           
           <form class="mainInfo" action="<?php echo get_stylesheet_directory_uri() ?>/manageProductoPost.php" 
            method="post" enctype="multipart/form-data" layout="row" layout-wrap>
             <div class="infoHolder BR BRwidth70%">
               <p>Titulo</p>
               <input type="text" name="title" class="BR BRwidth90%" placeholder="nombre" value="<?php the_title();?>">
             </div>

             <div class="infoHolder BR BRwidth30%">
               <p>Precio</p>
               <input type="number" name="precio" class="BR BRwidth90%" placeholder="precio" value="<?php echo $precio?>">
             </div>

             <div class="infoHolder BR BRwidth100%" >
               <p>Descripción</p>
               <input type="text" name="desc" class="BR BRwidth97%" placeholder="descripción" value="<?php echo $desc?>">
             </div>
             
             <input type="text" name="postid" hidden value="<?php echo $post_id?>">
             
             <input type="submit" name="submit" value="Guardar"/>
           </form>
           <form class="btnHolder alignBottom alignRight marginAuto" action="<?php echo get_stylesheet_directory_uri() ?>/duplicateProductoPost.php" 
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

