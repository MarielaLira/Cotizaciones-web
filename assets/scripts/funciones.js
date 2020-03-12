$(document).ready(function() { 

setCss();






});//fin jguery initial




/////////////hide info in scroll
$(window).scroll(function() {    
    var scroll = $(window).scrollTop();
    if (scroll >= 200) {
        $(".headerFixed").addClass("reveled");
    } 
    else {
        $(".headerFixed").removeClass("reveled");
    }
});

var scroll = $(window).scrollTop();
function moveTo(num){
  var extra = 0;
  if($('body').width() < 730){
    closeMenu();
    extra = 120;
  }
  var num = parseInt(num);
  $('html, body').animate({
        scrollTop: $("#"+num).offset().top-extra

  }, 800);
  return 0;
}

///////////////header

function openMenu(){
  $("#menu").addClass("expanded");
  $("#menuShadow").addClass("expanded");
  // $("#menu").addClass("expanded");
}
function closeMenu(){
  $("#menu").removeClass("expanded");
  $("#menuShadow").removeClass("expanded");
}


function openRes(){
  $("#reservas").addClass("expanded");
}
function closeRes(){
  $("#reservas").removeClass("expanded");
}


////////////////////////show info
function showInfo(num){
  var temp = "#info"+num;
  $(temp).addClass("active");
}





function selectBlurCliente(){
   var selectval = document.getElementById("selectClientes").value;
   if(selectval != -1){
     var nombre = document.getElementById("clienteNombre"+selectval).value;
     var empresa = document.getElementById("clienteEmpresa"+selectval).value;
   }
   else{
     var nombre = null;
     var empresa = null;
   }
   document.getElementById("nombreEmpresaClienteCotizacion").value = empresa;
   document.getElementById("personaDirijidaCotizacion").value = nombre;
}

function selectBlurCot(){
   var selectval = document.getElementById("selectItems").value;
   var text = "Agregar producto/servicio en blanco";
   if(selectval != -1){
     text = "Agregar producto/servicio existente";
   }
   document.getElementById("messageNewItem").innerHTML = text;
}
function newItem(){
    var selectval = document.getElementById("selectItems").value;
    
    var precio = 0;
    var nombre = '';
    var desc = '';
    if(selectval != -1){
     nombre = document.getElementById("productoNombre"+selectval).value;
     precio = document.getElementById("productoPrecio"+selectval).value;
     desc = document.getElementById("productoDesc"+selectval).value;
    }
    var itemsCount = getItemNewNum();
    var div = document.createElement('div');

    div.className = 'itemHolder';

    div.innerHTML =
        '<div id="singleItem'+itemsCount+'" class="singleItem layout-align-center-start layout-row layout-wrap" >\
        <div class="itemNameCol col"><input onchange="calculate('+itemsCount+');" type="text" placeholder="nombre del producto/servicio" class="itemClass" id="item'+itemsCount+'Cotizacion" name="item'+itemsCount+'Cotizacion" value="'+nombre+'" />\
        <input onchange="calculate('+itemsCount+');" type="text" placeholder="descripcion" id="itemDes'+itemsCount+'Cotizacion" name="itemDes'+itemsCount+'Cotizacion" value="'+desc+'" /></div>\
        <div class="qtyCol col"><input onchange="calculate('+itemsCount+');" type="number" placeholder="" class="itemQty" id="qty'+itemsCount+'Cotizacion" name="qty'+itemsCount+'Cotizacion" value="1" /></div>\
        <div class="priceCol col"><input onchange="calculate('+itemsCount+');" type="number" class="itemVal" id="price'+itemsCount+'Cotizacion" name="price'+itemsCount+'Cotizacion" value="'+precio+'" /></div>\
        <div class="amountCol col"><p class="color2 amountRow" id="amountRow'+itemsCount+'">0</p></div>\
        <div class="removeCol col btnBox" onclick="removeRow('+itemsCount+')"><p >X</p></div></div>';

    document.getElementById('items').appendChild(div);
    
    calculate(-1);
    updateItemArray();
 
}

function removeRow(id) {
    var confirmation = confirm("¿Esta seguro?");
   
    if(confirmation == false){
       return 0;
    }

    var temp = document.getElementById('singleItem'+id);
    document.getElementById('items').removeChild(temp.parentNode);
    
    calculate(-1);
    updateItemArray();
}

function getItemNewNum(){
  var items = document.getElementsByClassName("singleItem");
  var itemsCount = items.length;
  
  var tempLarge = 0;
  for(var i= 0; i<itemsCount; i++){
    var id = items[i].id;
    var matches = id.match(/(\d+)/);
    var num = parseInt(matches[0]);
    if(num > tempLarge){
      tempLarge = num;
    }
  }

  return tempLarge+=1;

}


function calculate(ID){
  var items = document.getElementsByClassName('singleItem');
  for(var i = 0; i<items.length; i++){
     var id = items[i].id;
     id = id.match(/(\d+)/);
     id = parseInt(id[0]);

     var totalAmount = document.getElementById('amountRow'+id);
  
     var qty = document.getElementById('qty'+id+'Cotizacion').value;
     var price = document.getElementById('price'+id+'Cotizacion').value;
   
     var total = qty*price;
     totalAmount.innerHTML = toFixed(total,2);
  }
  
  ///////update totales
  var subtotal = document.getElementById('resSubtotalCotizacion');

  var items = document.getElementsByClassName("amountRow");
  var itemsCount = items.length;

  total = 0
  for(var i= 0; i<itemsCount; i++){
    var temp = parseInt(document.getElementById(items[i].id).innerHTML);
    if(temp != null){
      total += temp
    }
  }
  subtotal.innerHTML = toFixed(total,2);

  var ivatotal = document.getElementById('resIvaCotizacion');
  var iva = parseInt(document.getElementById('ivaCotizacion').value);
  
  iva = iva/100;
  iva = iva * total;

  ivatotal.innerHTML = toFixed(iva,2);


  totalFinal = document.getElementById('resTotalCotizacion');

  total = iva+total;
  totalFinal.innerHTML = toFixed(total,2);

  updateItemArray();
}



function toFixed(value, precision) {
    var precision = precision || 0,
        power = Math.pow(10, precision),
        absValue = Math.abs(Math.round(value * power)),
        result = (value < 0 ? '-' : '') + String(Math.floor(absValue / power));

    if (precision > 0) {
        var fraction = String(absValue % power),
            padding = new Array(Math.max(precision - fraction.length, 0) + 1).join('0');
        result += '.' + padding + fraction;
    }
    return result;
}


function preview(state){
    if(state == true){
      $("#previewCot").addClass("expanded");
      $("#nuevaCot").removeClass("expanded");
      

      var logo = document.getElementById('imagenLogoCotizacion');
      logo = logo.cloneNode(true);
      var logoPre = document.getElementById('imagenLogoPreview').appendChild(logo);
  
      //var infoMiEmpresa = document.getElementById('informacionEmpresaCotizacion').value;
      //var infoMiEmpresaPre = document.getElementById('informacionEmpresaPreview')
      //infoMiEmpresaPre.innerHTML = infoMiEmpresa;
      //var infoMiEmpresa = $.trim($("#informacionEmpresaCotizacion").val());
      //infoMiEmpresaPre.innerHTML = infoMiEmpresa;

      var nombreEmpresaCotizacion = document.getElementById('nombreEmpresaCotizacion').value;
      document.getElementById('nombreEmpresaPreview').innerHTML = nombreEmpresaCotizacion;
      var telEmpresaCotizacion = document.getElementById('telEmpresaCotizacion').value;
      document.getElementById('telEmpresaPreview').innerHTML = telEmpresaCotizacion;
      var correoEmpresaCotizacion = document.getElementById('correoEmpresaCotizacion').value;
      document.getElementById('correoEmpresaPreview').innerHTML = correoEmpresaCotizacion;
      var direccionEmpresaCotizacion = document.getElementById('direccionEmpresaCotizacion').value;
      document.getElementById('direccionEmpresaPreview').innerHTML = direccionEmpresaCotizacion;
  
      var infoClienteEmpresa = document.getElementById('nombreEmpresaClienteCotizacion').value;
      var infoClienteEmpresaPre = document.getElementById('nombreEmpresaClientePreview')
      infoClienteEmpresaPre.innerHTML = infoClienteEmpresa;
  
      var personaDirijido = document.getElementById('personaDirijidaCotizacion').value;
      var personaDirijidoPre = document.getElementById('personaDirijidaPreview')
      personaDirijidoPre.innerHTML = personaDirijido;

      var fechaCotizacion = document.getElementById('fechaCotizacion').value;
      var fechaPre = document.getElementById('fechaPreview')
      fechaPre.innerHTML = fechaCotizacion;

      var fechaPagoCotizacion = document.getElementById('fechaPagoCotizacion').value;
      var fechaPagoPre = document.getElementById('fechaPagoPreview')
      fechaPagoPre.innerHTML = fechaPagoCotizacion;

      var resSubtotalCotizacion = document.getElementById('resSubtotalCotizacion').innerHTML;
      var resSubtotalPre = document.getElementById('resSubtotalPreview')
      resSubtotalPre.innerHTML = "$"+resSubtotalCotizacion;

      var resIvaCotizacion = document.getElementById('resIvaCotizacion').innerHTML;
      var resIvaPre = document.getElementById('resIvaPreview')
      resIvaPre.innerHTML = "$"+resIvaCotizacion;

      var ivaCotizacion = document.getElementById('ivaCotizacion').value;
      var ivaPre = document.getElementById('ivaPreview')
      ivaPre.innerHTML = ivaCotizacion;

      var monedaCotizacion = document.getElementById('monedaCotizacion').value;
      var monedaPre = document.getElementById('monedaPreview')
      monedaPre.innerHTML = monedaCotizacion;
      var monedaPre = document.getElementById('monedaPreview2')
      monedaPre.innerHTML = monedaCotizacion;

      var resTotalCotizacion = document.getElementById('resTotalCotizacion').innerHTML;
      var resTotalPre = document.getElementById('resTotalPreview')
      resTotalPre.innerHTML = "$"+resTotalCotizacion;
      var resTotalPre = document.getElementById('resTotalPreview2')
      resTotalPre.innerHTML = "$"+resTotalCotizacion;

      var notasCotizacion = document.getElementById('notasCotizacion').value;
      var notasPre = document.getElementById('notasPreview')
      notasPre.innerHTML = notasCotizacion;


      var items= document.getElementsByClassName("singleItem");
      var itemsCount = items.length;
      
      total = 0
      for(var i= 0; i<itemsCount; i++){

        var id = items[i].id;
            id = id.match(/(\d+)/);
            id = parseInt(id[0]);

        var div = document.createElement('div');
        
        var name = document.getElementById('item'+id+'Cotizacion').value;
        var des = document.getElementById('itemDes'+id+'Cotizacion').value;
        var qty = document.getElementById('qty'+id+'Cotizacion').value;
        var price = document.getElementById('price'+id+'Cotizacion').value;
        var amount = document.getElementById('amountRow'+id).innerHTML;

        div.className = 'itemHolder';

        div.innerHTML =
        '<div id="singleItem'+id+'" class="singleItem layout-align-center-start layout-row" >\
        <div class="itemNameCol col"><p class="name color2">'+name+'</p>\
        <p class="color2 description">'+des+'</p></div>\
        <div class="qtyCol col"><p class="color2">'+qty+'</p></div>\
        <div class="priceCol col"><p class="color2">'+"$"+price+'</p></div>\
        <div class="amountCol col"><p class="color2 amountRow">'+"$"+amount+'</p></div>\
        </div>';

        document.getElementById('itemsPreview').appendChild(div);
      }
     
      // printPDF();  +document.getElementById('tituloCotizacion').value
      //saveData("cotizacion", document.getElementById('newCot').innerHTML,dir);

    }
    else{
      $("#previewCot").removeClass("expanded");
      $("#nuevaCot").addClass("expanded");


      document.getElementById('imagenLogoPreview').innerHTML= null;
      document.getElementById('itemsPreview').innerHTML = null;
    }
}



function getDataUri(url) {
    var image = new Image();

    image.src = url;

        var canvas = document.createElement('canvas');
        canvas.width = this.naturalWidth; // or 'width' if you want a special/scaled size
        canvas.height = this.naturalHeight; // or 'height' if you want a special/scaled size

        canvas.getContext('2d').drawImage(image, 0, 0);

        // Get raw image data
        // callback(canvas.toDataURL('image/png').replace(/^data:image\/(png|jpg);base64,/, ''));

        // ... or get as Data URI
        return canvas.toDataURL('image/png').replace(/^data:image\/(png|jpg);base64,/, '');
    

    
}

function printPDF() {
    var filename2 = document.getElementById('tituloCotizacion').value;
    
    var element = document.getElementById('preview');
    var opt = {
      margin:       0,
      filename:     filename2,
      image: { type: 'jpeg', quality: 1 },
      html2canvas: { scale:5},
      jsPDF: { unit: 'in', format: 'a4', orientation: 'portrait' }
    };
    
    html2pdf().set(opt).from(element).save();
}


function setListaInfoCot(){
  var items= document.getElementsByClassName("boxCot");
  var itemsCount = items.length;
      
  for(var i= 0; i<itemsCount; i++){

        var id = items[i].id;
            id = id.match(/(\d+)/);
            id = parseInt(id[0]);

        
        
        
        var fecha2 = $('#'+id+' #fechaLimite'+id).html();
        if(fecha2 == null){
           document.getElementById('fechaLimite'+id).innerHTML = 'Sin fecha limite';
        }
        else{

           var today = new Date();
           var dd = String(today.getDate()).padStart(2, '0');
           var mm = String(today.getMonth() + 1).padStart(2, '0'); //January is 0!
           var yyyy = today.getFullYear();
           
           today = yyyy + '-' + mm + '-' + dd;


           var date1= new Date(today);
           var date2 = new Date(fecha2); 
           
          
           // To calculate the time difference of two dates 
           var Difference_In_Time = date2.getTime() - date1.getTime(); 
          
           // To calculate the no. of days between two dates 
           var Difference_In_Days = Difference_In_Time / (1000 * 3600 * 24); 
          
           
           if(Difference_In_Days <= 0){
            document.getElementById('tiempoRestante'+id).innerHTML = 'Tiempo vencido';
           }
           else{
            document.getElementById('tiempoRestante'+id).innerHTML = Difference_In_Days+' Días restante(s)';
           }

        }


  }
}


function updateItemArray(){
    var data = "";

    var items = document.getElementsByClassName("singleItem");
    var itemsCount = items.length;
      
    for(var i= 0; i<itemsCount; i++){
        var id = items[i].id;
        id = id.match(/(\d+)/);
        id = parseInt(id[0]);

        var name = document.getElementById('item'+id+'Cotizacion').value;
        var des = document.getElementById('itemDes'+id+'Cotizacion').value;
        var qty = document.getElementById('qty'+id+'Cotizacion').value;
        var price = document.getElementById('price'+id+'Cotizacion').value;
        var amount = document.getElementById('amountRow'+id).innerHTML;
        data += '<div class="itemHolder"><div id="singleItem'+id+'" class="singleItem layout-wrap layout-align-center-start layout-row"><div class="itemNameCol col"><input onchange="calculate('+id+');" type="text" placeholder="nombre del producto/servicio" class="itemName" id="item'+id+'Cotizacion" name="item'+id+'Cotizacion" value="'+name+'" /><input onchange="calculate('+id+');" type="text" placeholder="descripcion" id="itemDes'+id+'Cotizacion" name="itemDes'+id+'Cotizacion" value="'+des+'" /></div><div class="qtyCol col"><input class="itemQty" onchange="calculate('+id+');" type="number" placeholder="" id="qty'+id+'Cotizacion" name="qty'+id+'Cotizacion" value="'+qty+'" /></div><div class="priceCol col"><input class="itemVal" onchange="calculate('+id+');" type="number" id="price'+id+'Cotizacion" name="price'+id+'Cotizacion" value="'+price+'" /></div><div class="amountCol col"><p class="color2 amountRow" id="amountRow'+id+'">'+amount+'</p></div><div class="removeCol col btnBox" onclick="removeRow('+id+')"><p >X</p></div></div></div>';
    }

    //console.log(data);
    document.getElementById('itemArray').value = data;
}



function duplicateCot(id,dir){
    var dataName = $('#'+id+' #tituloCotizacion').val();
    dataName += ' - Copia';

    
  
    saveData(dataName, data, dir, 2, '', '');
    
}



$('#cuentaLogo').change( function(event) {
    var tmppath = URL.createObjectURL(event.target.files[0]);
    $("#logoHolder").fadeIn("fast").attr('src',URL.createObjectURL(event.target.files[0]));

});

function setCuenta(){

    var empresa = document.getElementById('empresaNombreCuenta').innerHTML;

    var logo = document.getElementById('empresaLogoInfo').innerHTML;

    var infoEmpresa = document.getElementById('correoEmpresaCuenta').innerHTML;
    document.getElementById('correoEmpresaCotizacion').value = infoEmpresa;

    infoEmpresa = document.getElementById('direccionEmpresaCuenta').innerHTML;
    document.getElementById('direccionEmpresaCotizacion').value = infoEmpresa;

    infoEmpresa = document.getElementById('telEmpresaCuenta').innerHTML;
    document.getElementById('telEmpresaCotizacion').value = infoEmpresa;


    document.getElementById('cuentaEmpresa').value = empresa;
    document.getElementById('logoHolder').src = logo;
    document.getElementById('cuentaLogoHide').value = logo;
    
}
function setCuentaCot(){


    if(document.getElementById('empresaNombreCuenta') != null){
      var empresa = document.getElementById('empresaNombreCuenta').innerHTML;
      document.getElementById('nombreEmpresaCotizacion').value = empresa;
    }

    if(document.getElementById('empresaLogoInfo')!= null){
      var logo = document.getElementById('empresaLogoInfo').innerHTML;
      document.getElementById('imagenLogoCotizacion').src = logo;
      console.log(logo);
    }
    
    if(document.getElementById('telEmpresaCuenta')!= null){
      var infoEmpresa = document.getElementById('telEmpresaCuenta').innerHTML;
      document.getElementById('telEmpresaCotizacion').value = infoEmpresa;
    }
     if(document.getElementById('correoEmpresaCuenta') != null){
      infoEmpresa = document.getElementById('correoEmpresaCuenta').innerHTML;
      document.getElementById('correoEmpresaCotizacion').value = infoEmpresa;
     }

     if(document.getElementById('direccionEmpresaCuenta') != null){
       infoEmpresa = document.getElementById('direccionEmpresaCuenta').innerHTML;
       document.getElementById('direccionEmpresaCotizacion').value = infoEmpresa;
     }

    

    



    
    
}

function saveData(dataName, data, dir, cat, img, id) {
        try {
            // Opera 8.0+, Firefox, Safari
            ajaxPOSTTestRequest = new XMLHttpRequest();
        } catch (e) {
            // Internet Explorer Browsers
            try {
                ajaxPOSTTestRequest = new ActiveXObject("Msxml2.XMLHTTP");
            } catch (e) {
                try {
                    ajaxPOSTTestRequest = new ActiveXObject("Microsoft.XMLHTTP");
                } catch (e) {
                    // Something went wrong
                    alert("Your browser broke!");
                    return false;
                }
            }
        }
        
      
           ajaxPOSTTestRequest.onreadystatechange = ajaxCalled_POSTTest;
           if(id == ''){
             var url = dir+"/createPostPHP.php";
             var params = "name="+dataName+"&viewPref="+data+"&cat="+cat+"&img="+img;
           }
           else{
             var url = dir+"/updatePostPHP.php";
             var params = "name="+dataName+"&viewPref="+data+"&cat="+cat+"&img="+img+"&postId="+id;
           }
           
           ajaxPOSTTestRequest.open("POST", url, true);
           ajaxPOSTTestRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
           ajaxPOSTTestRequest.send(params);
        
}






function deletePost(id,dir){
   var confirmation = confirm("¿Esta seguro?");
   
   if(confirmation == false){
      return 0;
   }

   try {
            // Opera 8.0+, Firefox, Safari
            ajaxPOSTTestRequest = new XMLHttpRequest();
        } catch (e) {
            // Internet Explorer Browsers
            try {
                ajaxPOSTTestRequest = new ActiveXObject("Msxml2.XMLHTTP");
            } catch (e) {
                try {
                    ajaxPOSTTestRequest = new ActiveXObject("Microsoft.XMLHTTP");
                } catch (e) {
                    // Something went wrong
                    alert("Your browser broke!");
                    return false;
                }
            }
        }
        
      
           ajaxPOSTTestRequest.onreadystatechange = ajaxCalled_POSTTest;
           var url = dir+"/removePostPHP.php";
           var params = "id="+id;
           ajaxPOSTTestRequest.open("POST", url, true);
           ajaxPOSTTestRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
           ajaxPOSTTestRequest.send(params);


    
}


//Create a function that will receive data sent from the server
function ajaxCalled_POSTTest() {
        if (ajaxPOSTTestRequest.readyState == 4) {
            window.location.reload(true);
        }
}




function countProducts(){
   var items= document.getElementsByClassName("itemName");
  
   var itemsArray = [];
   var stringArray = '';
   for(var i = 0; i < items.length; i++){
      itemsArray[i] = items[i].value;
      stringArray = stringArray+' '+items[i].value;
   }
   console.log(itemsArray);
   var out = document.getElementById("array");
   out.innerHTML = stringArray;
}






function setCss(){
   // var sheet = document.styleSheets;
   // for(var i= 0; i<sheet.length; i++){
   //    if(sheet[i].href != null){
   //      if(sheet[i].href.split('/').pop() == "main.css"){
   //        sheet = sheet[i];
   //        break;
   //      }
   //    }
   // }
   

   var items= document.getElementsByClassName("BR");
   var itemsCount = items.length;
      
   for(var i= 0; i<itemsCount; i++){
     var classes = items[i].className.split(' ');
     for(var j = 0; j<classes.length; j++){
        
        /////////margin
        var tempClass =  classes[j].includes("BRmargin");
        if(tempClass){
            var tempVal = replaceAll(classes[j],"BRmargin","");
            var tempVal = replaceAll(tempVal,"px","px ");
            tempVal = replaceAll(tempVal,"%","% ");

            items[i].style.margin = tempVal;
        }
        
        ////////padding
        var tempClass =  classes[j].includes("BRpadding");
        if(tempClass){
            var tempVal = replaceAll(classes[j],"BRpadding","");
            var tempVal = replaceAll(tempVal,"px","px ");
            tempVal = replaceAll(tempVal,"%","% ");

            items[i].style.padding = tempVal;
        }

        ////////width
        var tempClass =  classes[j].includes("BRwidth");
        if(tempClass){
            var tempVal = replaceAll(classes[j],"BRwidth","");
            var tempVal = replaceAll(tempVal,"px","px ");
            tempVal = replaceAll(tempVal,"%","% ");

            items[i].style.width = tempVal;
        }
     }

   }
}

function replaceAll(str, find, replace) {
    return str.replace(new RegExp(find, 'g'), replace);
}
function addCSSRule(sheet, selector, rules, index) {
  if("insertRule" in sheet) {
    sheet.insertRule(selector + "{" + rules + "}", index);
  }
  else if("addRule" in sheet) {
    sheet.addRule(selector, rules, index);
  }
}
