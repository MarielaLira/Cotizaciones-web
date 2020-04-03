<?php
/* Template Name: editar cotizacion*/

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
global $_GET;
$post_id = $_GET['id'];
if($post_id == null || $post_id == '' || (int)get_post_field('post_author', $post_id) != $current_user->id){
  wp_safe_redirect('/cotizaciones');
}

$name = $current_user->data->user_login;
$cuenta_id = get_page_by_title( $name.' '.$current_user->id, OBJECT, 'postcuentas' )->ID;

$src=get_post_field('logoPost', $cuenta_id);
$tel=get_post_field('telPost', $cuenta_id);
$empresa=get_post_field('empresaPost', $cuenta_id);
$dir=get_post_field('dirPost', $cuenta_id);
$mail=get_post_field('mailPost', $cuenta_id);


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
$status=get_post_field('statusPost', $post_id);

if($iva == null || $iva == ''){
  $iva = '16';
}
if($moneda == null || $moneda == ''){
  $moneda = 'USD';
}

if($telCot == null || $telCot == ''){
   $telCot = $tel;
}
if($mailCot == null || $mailCot == ''){
   $mailCot = $mail;
}
if($dirCot == null || $dirCot == ''){
   $dirCot = $dir;
}
if($empresaCot == null || $empresaCot == ''){
   $empresaCot = $empresa;
}
if($srcCot == null || $srcCot == ''){
   $srcCot = $src;
}

get_header();
get_template_part( 'menu' );
?>
<div class="hide">
     <?php
     echo '<div id="empresaNombreCuenta">'.$empresa.'</div>';
     echo '<div id="empresaLogoInfo">'.$src.'</div>';
     echo '<div id="telEmpresaCuenta">'.$tel.'</div>';
     echo '<div id="correoEmpresaCuenta">'.$mail.'</div>';
     echo '<div id="direccionEmpresaCuenta">'.$dir.'</div>';
     ?>

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
    $productoID = get_the_ID();

    $desc=get_post_field('descPost', $productoID);
    $precio=get_post_field('precioPost', $productoID);

    
    ?>
     <input id="productoNombre<?php echo $productoID?>" value="<?php the_title()?>">
     <input id="productoDesc<?php echo $productoID?>" value="<?php echo $desc?>">
     <input id="productoPrecio<?php echo $productoID?>" value="<?php echo $precio?>">
    <?php wp_reset_postdata(); ?>
    <?php endwhile; ?>
    <?php wp_reset_query(); ?>


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
    if ( has_post_thumbnail() ) { 
      $thumb_id = get_post_thumbnail_id();
      $thumb_url_array = wp_get_attachment_image_src($thumb_id, 'full', true);
      $thumb_url = $thumb_url_array[0];
    }
    $clienteID = get_the_ID();

    $nombre=get_post_field('clienteNomPost', $clienteID);
    $empresa=get_post_field('clienteEmpPost', $clienteID);

    
    ?>
     <input id="clienteNombre<?php echo $clienteID?>" value="<?php echo $nombre?>">
     <input id="clienteEmpresa<?php echo $clienteID?>" value="<?php echo $empresa?>">
    <?php wp_reset_postdata(); ?>
    <?php endwhile; ?>
    <?php wp_reset_query(); ?>
</div>

<div id="mainContainer" class="backColorWhite relative z2" layout="column" layout-align="start center">
   <div id="nuevaCot" class="expanded content contentPad10 relative">
    <p class="title montseBold color2">Editar Cotización</p>
    
    <form action="<?php echo get_stylesheet_directory_uri() ?>/manageCotiPost.php" method="post" enctype="multipart/form-data">
    
    <div class="cotizacion" id="innerCot">
     
      <div class="section header">
      	<div class="innerHolder" layout="row" layout-wrap layout-align="center start">
      	<div class="width50 column">
      		<img id="imagenLogoCotizacion" class="cotizacionImg" src="<?php echo $srcCot?>">
          <br>
      	  
        </div>
      	<div class="width50 column">
          <select id="selectStatus" name="status" class="">
             
              <?php 
                if($status == "terminado"){
              ?>
                 <option value="terminado" selected>Terminado</option>
                 <option value="incompleto">Incompleto</option>
                 <option value="en-revision">En Revision</option>
              <?php } ?>
              <?php 
                if($status == "incompleto" || $status == null || $status == ''){
              ?>
                 <option value="terminado" >Terminado</option>
                 <option value="incompleto" selected>Incompleto</option>
                 <option value="en-revision">En Revision</option>
              <?php } ?>
              <?php 
                if($status == "en-revision"){
              ?>
                 <option value="terminado">Terminado</option>
                 <option value="incompleto">Incompleto</option>
                 <option value="en-revision" selected>En Revision</option>
              <?php } ?>
         </select>
         <br>
         <input type="text"  id="tituloCotizacion" name="tituloCotizacion" placeholder="Titulo de Cotización" value="<?php echo get_post_field('post_title', $post_id);?>">
          <input type="text"  id="resumenCotizacion" name="resumenCotizacion" placeholder="Descripcion de Cotización" value="<?php echo $desc; ?>">
          <input type="text" hidden  name="postId" value="<?php echo $post_id; ?>">
            <!-- <textarea id="informacionEmpresaCotizacion" name="informacionEmpresaCotizacion" placeholder="Datos de tu Empresa"></textarea> -->
      	</div>
        <div class="fullWidth">
          <div onclick="setCuentaCot();" class="btnBox"><p >Actualizar</p></div>
          <br>
          
          <input type="text" id="nombreEmpresaCotizacion" name="nombreEmpresaCotizacion" placeholder="Nombre de Empresa" value="<?php echo $empresaCot?>">
          <input type="text" id="telEmpresaCotizacion" name="telEmpresaCotizacion" placeholder="telefono" value="<?php echo $telCot?>">
          <input type="text" id="correoEmpresaCotizacion" name="correoEmpresaCotizacion" placeholder="correo" value="<?php echo $mailCot?>">
          <input type="text" id="direccionEmpresaCotizacion" name="direccionEmpresaCotizacion" placeholder="dirección" value="<?php echo $dirCot?>">

          
        </div>
       </div>
      </div>
     
      <div class="section billTo" >
      	<div class="innerHolder" >
      	<div class="">
          <p class="color2">Datos de cliente</p>
      		<input id="nombreEmpresaClienteCotizacion" type="text"  name="nombreEmpresaClienteCotizacion" placeholder="Nombre de la empresa del cliente" value="<?php echo $clienteEmp?>">
          <input id="personaDirijidaCotizacion" type="text"  name="personaDirijidaCotizacion" placeholder="Nombre de a quien es dirijido" value="<?php echo $clienteNom?>">
      	  <br>
          <select id="selectClientes"  class="" onchange="selectBlurCliente();">
            <option value="-1" selected>En blanco</option>
            
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
              if ( has_post_thumbnail() ) { 
                $thumb_id = get_post_thumbnail_id();
                $thumb_url_array = wp_get_attachment_image_src($thumb_id, 'full', true);
                $thumb_url = $thumb_url_array[0];
              }
              $clienteID = get_the_ID();
              $nombre=get_post_field('clienteNomPost', $clienteID);
              $empresa=get_post_field('clienteEmpPost', $clienteID);
              ?>
                 <option value="<?php echo $clienteID; ?>"><strong><?php echo $nombre?></strong> <br> <?php echo $empresa;?></option>

              <?php wp_reset_postdata(); ?>
              <?php endwhile; ?>
              <?php wp_reset_query(); ?>
         </select>
          <br>
          <br>
          <br>
        </div>
      	<div class="">
          <p class="color2">Fechas</p>
      		<input id="fechaCotizacion" type="date"  name="fechaCotizacion" placeholder="Fecha de Cotización" value="<?php echo $fecha1?>">
            <input id="fechaPagoCotizacion" type="date"  name="fechaPagoCotizacion" placeholder="Fecha de Pago" value="<?php echo $fecha2?>">
      	</div>
       </div>
      </div>

      <div class="section items ">
      	<div class="innerHolder relative">
      	 <div class="descriptionRow" layout="row" layout-align="center start">
           <div class="itemNameCol col"><p class="color2">Producto/servicio</p></div>
           <div class="qtyCol col"><p class="color2">Cantidad</p></div>
           <div class="priceCol col"><p class="color2">Precio</p></div>
           <div class="amountCol col"><p class="color2">Total</p></div>
           <div class="removeCol col"><p class="color2"></p></div>
         </div>


      	 <div id="items" class="">

           <?php echo $itemArray?>

      	 </div>
         <div class="btnHolder" layout="column" layout-align="center center">
         <input hidden type="text" name="itemArray" id="itemArray" >
         
         <select id="selectItems"  class="middleWidth marginAuto"onchange="selectBlurCot();">
            <option value="-1" selected>nuevo producto</option>
            
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
              $productoID = get_the_ID();
              $desc=get_post_field('descPost', $productoID);
              $precio=get_post_field('precioPost', $productoID);
              ?>
                 <option value="<?php echo $productoID; ?>"><?php the_title();?> - $<?php echo $precio;?></option>

              <?php wp_reset_postdata(); ?>
              <?php endwhile; ?>
              <?php wp_reset_query(); ?>
         </select>
      	 <div onclick="newItem()" class="btnBox middleWidth marginAuto">
      	 	  <p id="messageNewItem">Agregar producto/servicio en blanco</p>
      	 </div>
        </div>

      	 
      	</div>


      	<div class="innerHolder totalHolder" layout="row" layout-align="center start" layout-wrap>
         <div class="width50 column">
         	<textarea id="notasCotizacion" name="notasCotizacion" placeholder="notas"><?php echo $notas?></textarea>
      	 </div>
      	 <div class="width50 column" layout="row">
          <br>
          <br>
      	 	<div class="width50">
               <div class="total row" layout="row" layout-align="space-between">
                 <p class="color2">Subtotal: </p>
               </div>
               <div class="total row" layout="row" layout-align="space-between">
                 <p class="color2">IVA: </p>
                 <input type="number"  onchange="calculate(-1);" id="ivaCotizacion" name="ivaCotizacion" placeholder="IVA" value="<?php echo $iva; ?>">
               </div>
               <div class="total row" layout="row" layout-align="space-between">
                 <p class="color2">Total: </p>
                 <input type="text"  id="monedaCotizacion" name="monedaCotizacion" placeholder="moneda" value="<?php echo $moneda; ?>">
               </div>
      	 	</div>
      	 	<div class="totalCol">
               
               <div class="total row" layout="row" layout-align="space-between">
                 <p id="resSubtotalCotizacion" class="color2">0</p>
               </div>
               <div class="total row" layout="row" layout-align="space-between">
                 <p id="resIvaCotizacion" class="color2">0</p>
               </div>
               <div class="total row" layout="row" layout-align="space-between">
                 <p id="resTotalCotizacion" class="color2">0</p>
               </div>
      	 	</div>
      		
      	 </div>
         </div>
      </div>
              
    </div>
    
    <div layout="column" layout-align="center center">
        <div  onclick="preview(true)" class="btnBox middleWidth">
          	<p  >Visualizar</p>
        </div>
        <!-- <div  class="btnBox middleWidth marginAuto">
            <p onclick="updateCot('<?php echo $postID?>','<?php bloginfo("template_directory");?>')">Guardar</p>
        </div> -->
        <input class="middleWidth marginAuto" type="submit" name="submit" value="Guardar"/>
    </div>
    </form>


  </div>

  <div id="previewCot" class="contentPad10 relative">
    <p class="title montseBold color2">Cotización</p>
    
    <div class="previewBorder">
      <div id="preview" class="z5 backColorWhite">

           <div class="section header">
      	      <div class="innerHolder" layout="row" layout-align="center start">
      	         <div class="width50 column">
      		        <div id="imagenLogoPreview"></div>
      	         </div>
      	         <div class="width50 column">
      	            <!-- <p id="informacionEmpresaPreview"></p> -->
                    <strong><p id="nombreEmpresaPreview" class="textRight fontSize25"></p></strong>
                    <br>
                    <p class="textRight"><strong>Telefono:</strong> <span id="telEmpresaPreview" ></span></p>
                    <p class="textRight"><strong>Correo:</strong> <span id="correoEmpresaPreview" ></span></p>
                    <p class="textRight"><strong>Dirección:</strong> <span id="direccionEmpresaPreview" ></span></p>
      	         </div>
              </div>
           </div>

           <div class="divider"></div>
           <div class="section billTo" >
      	      <div class="innerHolder" layout="row" layout-align="center start">
      	         <div class="width50 column">
      	         	 <p><strong class="color2">Para:</strong></p>
      		           <p id="nombreEmpresaClientePreview"></p>
                     <p id="personaDirijidaPreview"></p>
      	         </div>
      	         <div class="width50 column" layout="row" layout-align="end">
      		          <div class="">
                        <p class="textRight"><strong class="color2">Fecha de Cotizacion: </strong></p>
      		            <p class="textRight"><strong class="color2">Fecha de Pago: </strong></p>
      		            <p class="totalFinal textRight color2"><strong>Total Final </strong>(<span id="monedaPreview"></span>): </p>
                      
      		          </div>
      		          <div class="fechaHolder">
                        <p class="textLeft" id="fechaPreview"></p>
      		            <p class="textLeft" id="fechaPagoPreview"></p>
      		            <p class="totalFinal textLeft" id="resTotalPreview"></p>
      		          </div>


      	         </div>
             </div>
           </div>
          
          <!-- <div class="divider"></div> -->
          <div class="section items ">
      	     <div class="innerHolder relative">
      	        <div class="descriptionRow" layout="row" layout-align="center start">
                  <div class="itemNameCol col"><p class="color2"><strong>Producto/servicio</p></strong></div>
                  <div class="qtyCol col"><p class="color2"><strong>Cantidad</p></strong></div>
                  <div class="priceCol col"><p class="color2"><strong>Precio</p></strong></div>
                  <div class="amountCol col"><p class="color2"><strong>Total</p></strong></div>
                </div>


      	        <div id="itemsPreview" class="">

              
      	       </div>

      	 
      	     </div>

            <div class="divider"></div>
            <div class="innerHolder totalesHolder" layout="row" layout-align="center start">
                 <div class="width50 column">
                 </div>
                 <div class="width50 column" layout="row" layout-align="end">
                    <div class="">
                      <p class="color2 textRight">Subtotal: </p>
                      <p class="textRight color2">IVA (<span id="ivaPreview"></span>)%: </p>
                      <p class="totalFinal textRight color2"><strong >Total Final </strong>(<span id="monedaPreview2"></span>): </p>
                    </div>
                    <div class="fechaHolder">
                      <p id="resSubtotalPreview" >0</p>
                      <p id="resIvaPreview">0</p>
                      <p class="totalFinal" id="resTotalPreview2">0</p>
                    </div>


                 </div>
            </div>
            <div class="innerHolder column">
                <p id="notasPreview"></p>
            </div>

        </div>

       </div><!-- preview end -->

    </div>

    <!-- vizualizar -->
    
    <div  onclick="printPDF()" class="btnBox middleWidth marginAuto">
      	<p  >Obtener PDF</p>
    </div>
    

    <div  onclick="preview(false,'')"  class="btnBox middleWidth marginAuto">
      	<p >Editar</p>
    </div>




     
   
  </div>

  <div id="output"></div>
   
</div>


   <script>
        $(document).ready(function() { 
          
          calculate(-1);
         });
        window.onbeforeunload = function(){
           return '¿Estas seguro?';
        };
   </script>
  

<?php get_footer();?>

