<?php
 
// WordPress environment
require( dirname(__FILE__) . '/../../../wp-load.php' );



global $user_ID;
$titulo = '';



$titulo = $_POST['tituloCotizacion'];



if($titulo == ''){
  wp_redirect("/cotizaciones");  
}


$new_post = array(
  'post_title' => $titulo,
  'post_status' => 'publish',
  'post_date' => date('Y-m-d H:i:s'),
  'post_author' => $user_ID,
  'post_type' => 'postcotis'
  );
$post_id = wp_insert_post($new_post);

$item = '<div class="itemHolder">
             <div id="singleItem0" class="singleItem layout-align-center-start layout-row layout-wrap" >
             <div class="itemNameCol col"><input onchange="calculate(0);" type="text" placeholder="nombre del producto/servicio" class="itemName" id="item0Cotizacion" name="item0Cotizacion" value="" />
             <input onchange="calculate(0);" type="text"  placeholder="descripción" id="itemDes0Cotizacion" name="itemDes0Cotizacion" value="" /></div>
             <div class="qtyCol col"><input onchange="calculate(0);" type="number" class="itemQty" placeholder="" id="qty0Cotizacion" name="qty0Cotizacion" value="1" /></div>
             <div class="priceCol col"><input onchange="calculate(0);" type="number" class="itemVal" id="price0Cotizacion" name="price0Cotizacion" value="0" /></div>
             <div class="amountCol col"><p class="color2 amountRow" id="amountRow0">0</p></div>
             <div class="removeCol col btnBox" onclick="removeRow(0)"><p  >X</p></div></div>
           </div>';

if ($post_id) {
  add_post_meta($post_id, 'itemPost', $item);
}


wp_redirect("/cotizaciones");
