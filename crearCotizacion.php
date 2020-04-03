<?php
/* Template Name: crear cotizacion */

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
get_template_part( 'menu' );
?>
<div id="mainContainer" class="backColorWhite relative z2" layout="column" layout-align="start center">
   <div id="nuevaCot" class="expanded content contentPad10 relative">
    <p class="title montseBold color2">Editar Cotización</p>
    
    <form method="POST" action="" name="cotizacion" id="newCot">
    
    <div class="cotizacion">

      <div class="section header">
      	<div class="innerHolder" layout="row" layout-align="center start">
      	<div class="width50 column">
      		<img id="imagenLogoCotizacion" class="cotizacionImg" src="<?php bloginfo("template_directory"); ?>/assets/images/logoprueba.jpg">
      	</div>
      	<div class="width50 column">
      		<input type="text"  id="tituloCotizacion" name="tituloCotizacion" placeholder="Titulo de Cotización" value="Cotización">
            <input type="text"  name="resumenCotizacion" placeholder="Descripcion de Cotización" value="">
      	    <textarea id="informacionEmpresaCotizacion" name="informacionEmpresaCotizacion" placeholder="Datos de tu Empresa"></textarea>
      	</div>
       </div>
      </div>
     
      <div class="section billTo" >
      	<div class="innerHolder" layout="row" layout-align="center start">
      	<div class="width50 column">
      		<input id="nombreEmpresaClienteCotizacion" type="text"  name="nombreEmpresaClienteCotizacion" placeholder="Nombre de la empresa del cliente" value="">
            <input id="personaDirijidaCotizacion" type="text"  name="personaDirijidaCotizacion" placeholder="Nombre de a quien es dirijido" value="">
      	</div>
      	<div class="width50 column">
      		<input id="fechaCotizacion" type="date"  name="fechaCotizacion" placeholder="Fecha de Cotización" value="">
            <input id="fechaPagoCotizacion" type="date"  name="fechaPagoCotizacion" placeholder="Fecha de Pago" value="">
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

             <div class="itemHolder">
         <div id="singleItem0" class="singleItem layout-align-center-start layout-row" >
        <div class="itemNameCol col"><input  type="text" placeholder="nombre del producto/servicio" id="item0Cotizacion" name="item0Cotizacion" value="" />
        <input type="text" placeholder="descripcion" id="itemDes0Cotizacion" name="itemDes0Cotizacion" value="" /></div>
        <div class="qtyCol col"><input onblur="calculate(0);" type="number" placeholder="" id="qty0Cotizacion" name="qty0Cotizacion" value="1" /></div>
        <div class="priceCol col"><input onblur="calculate(0);" type="number" id="price0Cotizacion" name="price0Cotizacion" value="0" /></div>
        <div class="amountCol col"><p class="color2" id="amountRow0" class="amountRow">0</p></div>
        <div class="removeCol col "><p class="btn backColor2 color1" onclick="removeRow(0)">Remover</p></div></div>
        
        </div>

             
      	 </div>
      	 <div  class="additem" layout="column" layout-align="center center">
      	 	  <p onclick="newItem()" class="btn textCenter color1 backColor2">Agregar producto/servicio en blanco</p>
      	 </div>

      	 
      	</div>


      	<div class="innerHolder totalHolder" layout="row" layout-align="center start">
         <div class="width50 column">
         	<textarea id="notasCotizacion" name="notasCotizacion" placeholder="notas"></textarea>
      	 </div>
      	 <div class="width50 column" layout="row">
      	 	<div class="width50">
               <div class="total row" layout="row" layout-align="space-between">
                 <p class="color2">Subtotal: </p>
               </div>
               <div class="total row" layout="row" layout-align="space-between">
                 <p class="color2">IVA: </p>
                 <input type="number"  onblur="calculate(-1);" id="ivaCotizacion" name="ivaCotizacion" placeholder="IVA" value="16">
               </div>
               <div class="total row" layout="row" layout-align="space-between">
                 <p class="color2">Total: </p>
                 <input type="text"  id="monedaCotizacion" name="monedaCotizacion" placeholder="moneda" value="USD">
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
    
    
    <div  class="additem visualizarBtn" layout="column" layout-align="center center">
      	<p onclick="preview(true)" class="btn textCenter color1 backColor2">Visualizar</p>
    </div>
    <div  class="additem visualizarBtn" layout="column" layout-align="center center">
        <p onclick="createCot('<?php bloginfo("template_directory"); ?>')" class="btn textCenter color1 backColor2">Guardar</p>
    </div>
    
    
    </form>


  </div>

  <div id="previewCot" class="content contentPad10 relative">
    <p class="title montseBold color2">Cotización</p>
    
    <div class="previewBorder">
      <div id="preview" class="z5 backColorWhite">

           <div class="section header">
      	      <div class="innerHolder" layout="row" layout-align="center start">
      	         <div class="width50 column">
      		        <div id="imagenLogoPreview"></div>
      	         </div>
      	         <div class="width50 column">
      	            <p id="informacionEmpresaPreview"></p>
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
    
    <div  class="additem " layout="column" layout-align="center center">
      	<p onclick="printPDF()" class="textCenter color1 backColor2 btn">Obtener PDF</p>
    </div>
    

    <div  class="additem visualizarBtn" layout="column" layout-align="center center">
      	<p onclick="preview(false,'')" class="textCenter color1 backColor2 btn">Editar</p>
    </div>


     
   
  </div>

  <div id="output"></div>
   
</div>


   
  

<?php get_footer();?>

