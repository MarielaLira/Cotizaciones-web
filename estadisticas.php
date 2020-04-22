<?php
/* Template Name: estadisticas */

?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.bundle.min.js"></script>

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
      <p class="title montseBold color2">Estadisticas</p>
      
    </div>
    


    <div class="cotizaciones hide content contentPad10 relative" layout="row" layout-wrap>
      <?php 
          $args = array(
             'author' =>  $current_user->ID,
             'order' => 'DSC',
             'orderby' => 'post_date',
             'post_status' => 'publish',
             'posts_per_page'=>'-1',
             'post_type'=>'postcotis'
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

    $clienteEmp=get_post_field('clienteEmpPost', $post_id);
    $fecha1=get_post_field('fecha1Post', $post_id);
    $fecha2=get_post_field('fecha2Post', $post_id);
    $desc=get_post_field('descPost', $post_id);
    $status=get_post_field('statusPost', $post_id);
    $itemsArray = get_post_field('itemPost', $post_id);
    
    ?>

     <?php echo $itemsArray;?>


    <?php wp_reset_postdata(); ?>
    <?php endwhile; ?>
    <?php wp_reset_query(); ?>
      
    </div>
    
    <div class="content contentPad10 relative">
      <p class="montseBold color2 textCenter fontSize25">Productos utilizados</p>
    </div>
    <div class="content contentPad10 relative" layout="row" layout-wrap>
       <div class="relative chartHolder">
          <canvas id="productosUtilizados"></canvas>
       </div>
       <div class="relative chartHolder">
          <canvas id="productosValorados"></canvas>
       </div>

    </div>
    
    

    


  </div>

   <script>
   $(document).ready(function() { 
       // countProducts();
       var items= document.getElementsByClassName("itemName");
       var qty = document.getElementsByClassName("itemQty");
       var price = document.getElementsByClassName("itemVal");

       
       var itemsArray = [];
       var stringArray = '';
       
       for(var i = 0; i < items.length; i++){
          for(var j = 0; j < qty[i].value; j++){
              if(items[i].value == ''){
                itemsArray[itemsArray.length] = 'sin nombre';
              }
              else{
                itemsArray[itemsArray.length] = items[i].value;
              }
          }
          stringArray = stringArray+' '+items[i].value;
       }
       

       var hist = {};
       
       for(var i = 0; i < itemsArray.length; i++){
        var a = itemsArray[i]
        if (a in hist){
          hist[a] ++;

        }
        else{
          hist[a] = 1;
        }
       }

       var prices = {};
       for(var i = 0; i < items.length; i++){
        var a = items[i].value;
        if (a in prices){
          prices[a] += price[i].value*qty[i].value;
        }
        else{
          prices[a] = price[i].value*qty[i].value;
        }
       }

       var valoracion = {};
       for(var i = 0; i < items.length; i++){
        var a = items[i].value;
        if (a in valoracion){

          if(valoracion[a] < price[i].value){
            valoracion[a] = price[i].value;
          }
        }
        else{
          valoracion[a] = price[i].value;
        }
       }
       

       
       var keys = Object.keys(hist);
       var values = Object.values(hist);

       var values2 = Object.values(prices);
       var values3 = Object.values(valoracion);
      
          var colors = [
                       'rgba(255, 99, 132, 0.9)',
                       'rgba(54, 162, 235, 0.9)',
                       'rgba(255, 206, 86, 0.9)',
                       'rgba(75, 192, 192, 0.9)',
                       'rgba(153, 102, 255, 0.9)',
                       'rgba(255, 159, 64, 0.9)',

                       'rgba(255, 99, 140, 0.9)',
                       'rgba(54, 162, 240, 0.9)',
                       'rgba(255, 206, 86, 0.9)',
                       'rgba(75, 192, 192, 0.9)',
                       'rgba(153, 102, 255, 0.9)',
                       'rgba(255, 159, 64, 0.9)',

                       'rgba(255, 99, 145, 0.9)',
                       'rgba(54, 162, 245, 0.9)',
                       'rgba(255, 206, 86, 0.9)',
                       'rgba(75, 192, 192, 0.9)',
                       'rgba(153, 102, 255, 0.9)',
                       'rgba(255, 159, 64, 0.9)',

                       'rgba(255, 99, 155, 0.9)',
                       'rgba(54, 162, 245, 0.9)',
                       'rgba(255, 206, 86, 0.9)',
                       'rgba(75, 192, 192, 0.9)',
                       'rgba(153, 102, 255, 0.9)',
                       'rgba(255, 159, 64, 0.9)'
                   ]
          
          var ctx = document.getElementById("productosUtilizados").getContext('2d');
          var myChart = new Chart(ctx, {
           type: "doughnut",
           data: {
               labels: keys,
               datasets: [{
                   label: "# de utilizaciones",
                   data: values,
                   backgroundColor: colors,
               },
               ]

           },
           options: {
               responsive: true,
               aspectRatio: 1.6,
               
           }
          });

          var ctx = document.getElementById("productosValorados").getContext('2d');
          var myChart = new Chart(ctx, {
           type: "bar",
           data: {
               labels: keys,
               datasets: [
               {
                   label: "mejor valoración",
                   data: values3,
                   backgroundColor: colors,
                   type: "bar",
                   order: 2
               },
               {
                   label: "monto total",
                   data: values2,
                   backgroundColor: colors,
                   type: "bar",
                   order: 1
               }
               ]

           },
           options: {
               responsive: true,
               aspectRatio: 1.6,
               scales: {
                   yAxes: [{
                       ticks: {
                           beginAtZero: true
                       }
                   }]
               }
           }
          });


          
       



    });
   </script>
   
  

<?php get_footer();?>

