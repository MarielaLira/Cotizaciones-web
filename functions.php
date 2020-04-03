<?php
function my_login_logo() { ?>
    <style type="text/css">
        #login h1 a, .login h1 a {
            display: none;
        }
    </style>
<?php }
add_action( 'login_enqueue_scripts', 'my_login_logo' );


function theme_slug_setup() {
   add_theme_support( 'title-tag' );
}
add_action( 'after_setup_theme', 'theme_slug_setup' );

if ( ! function_exists( '_wp_render_title_tag' ) ) :
    function theme_slug_render_title() {
?>
<title><?php wp_title( '|', true, 'right' ); ?></title>
<?php
    }
    add_action( 'wp_head', 'theme_slug_render_title' );
endif;




add_theme_support( 'post-thumbnails' );
function excerpt($limit) {
  $excerpt = explode(' ', get_the_excerpt(), $limit);
  if (count($excerpt)>=$limit) {
    array_pop($excerpt);
    $excerpt = implode(" ",$excerpt).'...';
  } else {
    $excerpt = implode(" ",$excerpt);
  } 
  $excerpt = preg_replace('`[[^]]*]`','',$excerpt);
  return $excerpt;
}

function content($limit) {
  $content = explode(' ', get_the_content(), $limit);
  if (count($content)>=$limit) {
    array_pop($content);
    $content = implode(" ",$content).'...';
  } else {
    $content = implode(" ",$content);
  } 
  $content = preg_replace('/[.+]/','', $content);
  $content = apply_filters('the_content', $content); 
  $content = str_replace(']]>', ']]&gt;', $content);
  return $content;
}


function SearchFilter($query) {
    if ($query->is_search) {
        $query->set('post_type', 'post');
    }
    return $query;
}




add_action( 'wp_ajax_update_view_pref', 'update_view_pref');
function update_view_pref() {
    if(empty($_POST) || !isset($_POST)) {
        ajaxStatus('error', 'Nothing to update.');
    } else {
        try {
            $user = wp_get_current_user();
            $viewPref = $_POST['viewPref'];
            $name = $_POST['name'];
            
            update_user_meta( $user->ID, $name, $viewPref );
            echo (get_user_notes());
            die();
        } catch (Exception $e){
            echo 'Caught exception: ',  $e->getMessage(), "\n";
        }
    }

    
}

function get_user_notes($dataName){
        $user = wp_get_current_user();
        $old_notes = get_user_meta($user->ID, $dataName, true);
        
       
        return $old_notes;
}
// echo (get_user_notes());



if ( is_user_logged_in() && is_admin() ) {
    global $current_user;
    get_currentuserinfo();
    $user_info = get_userdata($current_user->ID);
    $role = implode(',', $current_user->roles);
    $role .= '';
    if ($role != 'administrator')
    {
        header( 'Location: '.get_bloginfo('home'));
    }
}






///////////////////////////////////////////////////////custom posts 


function custom_post_type() {
     
    ///////////////////////////////////////////////cuenta post 
    // Set UI labels for Custom Post Type
    $labels = array(
        'name'                => _x( 'cuentas', 'Post Type General Name', 'cot' ),
        'singular_name'       => _x( 'cuenta', 'Post Type Singular Name', 'cot' ),
        'menu_name'           => __( 'cuentas', 'cot' ),
        'parent_item_colon'   => __( 'Parent cuenta', 'cot' ),
        'all_items'           => __( 'All cuentas', 'cot' ),
        'view_item'           => __( 'View cuenta', 'cot' ),
        'add_new_item'        => __( 'Add New cuenta', 'cot' ),
        'add_new'             => __( 'Add New', 'cot' ),
        'edit_item'           => __( 'Edit cuenta', 'cot' ),
        'update_item'         => __( 'Update cuenta', 'cot' ),
        'search_items'        => __( 'Search cuenta', 'cot' ),
        'not_found'           => __( 'Not Found', 'cot' ),
        'not_found_in_trash'  => __( 'Not found in Trash', 'cot' ),
    );
     
    // Set other options for Custom Post Type
     
    $args = array(
        'label'               => __( 'cuentas', 'cot' ),
        'description'         => __( 'cot cuentas', 'cot' ),
        'labels'              => $labels,
        // Features this CPT supports in Post Editor
        'supports'            => array( 'title', 'editor', 'thumbnail'),
        // You can associate this CPT with a taxonomy or custom taxonomy. 
        'taxonomies'          => array( 'genres', 'category' ),
        /* A hierarchical CPT is like Pages and can have
        * Parent and child items. A non-hierarchical CPT
        * is like Posts.
        */ 
        'hierarchical'        => false,
        'public'              => false,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'show_in_nav_menus'   => true,
        'show_in_admin_bar'   => true,
        'menu_position'       => 5,
        'can_export'          => true,
        'has_archive'         => false,
        'exclude_from_search' => true,
        'publicly_queryable'  => true,
        'capability_type'     => 'post',
    );
     
    // Registering your Custom Post Type
    register_post_type( 'postcuentas', $args );


    ///////////////////////////////////////////////coti post 
    // Set UI labels for Custom Post Type
    $labels = array(
        'name'                => _x( 'cotis', 'Post Type General Name', 'cot' ),
        'singular_name'       => _x( 'coti', 'Post Type Singular Name', 'cot' ),
        'menu_name'           => __( 'cotis', 'cot' ),
        'parent_item_colon'   => __( 'Parent coti', 'cot' ),
        'all_items'           => __( 'All cotis', 'cot' ),
        'view_item'           => __( 'View coti', 'cot' ),
        'add_new_item'        => __( 'Add New coti', 'cot' ),
        'add_new'             => __( 'Add New', 'cot' ),
        'edit_item'           => __( 'Edit coti', 'cot' ),
        'update_item'         => __( 'Update coti', 'cot' ),
        'search_items'        => __( 'Search coti', 'cot' ),
        'not_found'           => __( 'Not Found', 'cot' ),
        'not_found_in_trash'  => __( 'Not found in Trash', 'cot' ),
    );
     
    // Set other options for Custom Post Type
     
    $args = array(
        'label'               => __( 'cotis', 'cot' ),
        'description'         => __( 'cot cotis', 'cot' ),
        'labels'              => $labels,
        // Features this CPT supports in Post Editor
        'supports'            => array( 'title', 'editor', 'thumbnail'),
        // You can associate this CPT with a taxonomy or custom taxonomy. 
        'taxonomies'          => array( 'genres', 'category' ),
        /* A hierarchical CPT is like Pages and can have
        * Parent and child items. A non-hierarchical CPT
        * is like Posts.
        */ 
        'hierarchical'        => false,
        'public'              => false,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'show_in_nav_menus'   => true,
        'show_in_admin_bar'   => true,
        'menu_position'       => 5,
        'can_export'          => true,
        'has_archive'         => false,
        'exclude_from_search' => true,
        'publicly_queryable'  => true,
        'capability_type'     => 'post',
    );
     
    // Registering your Custom Post Type
    register_post_type( 'postcotis', $args );




    ///////////////////////////////////////////////producto post 
    // Set UI labels for Custom Post Type
    $labels = array(
        'name'                => _x( 'productos', 'Post Type General Name', 'cot' ),
        'singular_name'       => _x( 'producto', 'Post Type Singular Name', 'cot' ),
        'menu_name'           => __( 'productos', 'cot' ),
        'parent_item_colon'   => __( 'Parent producto', 'cot' ),
        'all_items'           => __( 'All productos', 'cot' ),
        'view_item'           => __( 'View producto', 'cot' ),
        'add_new_item'        => __( 'Add New producto', 'cot' ),
        'add_new'             => __( 'Add New', 'cot' ),
        'edit_item'           => __( 'Edit producto', 'cot' ),
        'update_item'         => __( 'Update producto', 'cot' ),
        'search_items'        => __( 'Search producto', 'cot' ),
        'not_found'           => __( 'Not Found', 'cot' ),
        'not_found_in_trash'  => __( 'Not found in Trash', 'cot' ),
    );
     
    // Set other options for Custom Post Type
     
    $args = array(
        'label'               => __( 'productos', 'cot' ),
        'description'         => __( 'cot productos', 'cot' ),
        'labels'              => $labels,
        // Features this CPT supports in Post Editor
        'supports'            => array( 'title', 'editor', 'thumbnail'),
        // You can associate this CPT with a taxonomy or custom taxonomy. 
        'taxonomies'          => array( 'genres', 'category' ),
        /* A hierarchical CPT is like Pages and can have
        * Parent and child items. A non-hierarchical CPT
        * is like Posts.
        */ 
        'hierarchical'        => false,
        'public'              => false,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'show_in_nav_menus'   => true,
        'show_in_admin_bar'   => true,
        'menu_position'       => 5,
        'can_export'          => true,
        'has_archive'         => false,
        'exclude_from_search' => true,
        'publicly_queryable'  => true,
        'capability_type'     => 'post',
    );
     
    // Registering your Custom Post Type
    register_post_type( 'postproductos', $args );




    ///////////////////////////////////////////////cliente post 
    // Set UI labels for Custom Post Type
    $labels = array(
        'name'                => _x( 'clientes', 'Post Type General Name', 'cot' ),
        'singular_name'       => _x( 'cliente', 'Post Type Singular Name', 'cot' ),
        'menu_name'           => __( 'clientes', 'cot' ),
        'parent_item_colon'   => __( 'Parent cliente', 'cot' ),
        'all_items'           => __( 'All clientes', 'cot' ),
        'view_item'           => __( 'View cliente', 'cot' ),
        'add_new_item'        => __( 'Add New cliente', 'cot' ),
        'add_new'             => __( 'Add New', 'cot' ),
        'edit_item'           => __( 'Edit cliente', 'cot' ),
        'update_item'         => __( 'Update cliente', 'cot' ),
        'search_items'        => __( 'Search cliente', 'cot' ),
        'not_found'           => __( 'Not Found', 'cot' ),
        'not_found_in_trash'  => __( 'Not found in Trash', 'cot' ),
    );
     
    // Set other options for Custom Post Type
     
    $args = array(
        'label'               => __( 'clientes', 'cot' ),
        'description'         => __( 'cot clientes', 'cot' ),
        'labels'              => $labels,
        // Features this CPT supports in Post Editor
        'supports'            => array( 'title', 'editor', 'thumbnail'),
        // You can associate this CPT with a taxonomy or custom taxonomy. 
        'taxonomies'          => array( 'genres', 'category' ),
        /* A hierarchical CPT is like Pages and can have
        * Parent and child items. A non-hierarchical CPT
        * is like Posts.
        */ 
        'hierarchical'        => false,
        'public'              => false,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'show_in_nav_menus'   => true,
        'show_in_admin_bar'   => true,
        'menu_position'       => 5,
        'can_export'          => true,
        'has_archive'         => false,
        'exclude_from_search' => true,
        'publicly_queryable'  => true,
        'capability_type'     => 'post',
    );
     
    // Registering your Custom Post Type
    register_post_type( 'postclientes', $args );



    
}
add_action( 'init', 'custom_post_type', 0 );





add_action( 'add_meta_boxes', 'm_param_meta_box_add' );
function m_param_meta_box_add() {
  
    //logo
    add_meta_box(
       'logoPost',          // $id
       'logo',                  // $title
       'logoCall',     // $callback
       'postcuentas',                 // $page
       'normal',                     // $context
       'high'                        // $priority
    );
    //nombre empresa
    add_meta_box(
       'empresaPost',          // $id
       'empresa',                  // $title
       'empresaCall',     // $callback
       'postcuentas',                 // $page
       'normal',                     // $context
       'high'                        // $priority
    );
    //direccion empresa
    add_meta_box(
       'dirPost',          // $id
       'dir',                  // $title
       'dirCall',     // $callback
       'postcuentas',                 // $page
       'normal',                     // $context
       'high'                        // $priority
    );
    //mail empresa
    add_meta_box(
       'mailPost',          // $id
       'mail',                  // $title
       'mailCall',     // $callback
       'postcuentas',                 // $page
       'normal',                     // $context
       'high'                        // $priority
    );
    //tel empresa
    add_meta_box(
       'telPost',          // $id
       'tel',                  // $title
       'telCall',     // $callback
       'postcuentas',                 // $page
       'normal',                     // $context
       'high'                        // $priority
    );
   
    add_meta_box(
       'logoPost',          // $id
       'logo',                  // $title
       'logoCall',     // $callback
       'postcotis',                 // $page
       'normal',                     // $context
       'high'                        // $priority
    );
    add_meta_box(
       'empresaPost',          // $id
       'empresa',                  // $title
       'empresaCall',     // $callback
       'postcotis',                 // $page
       'normal',                     // $context
       'high'                        // $priority
    );
    add_meta_box(
       'dirPost',          // $id
       'dir',                  // $title
       'dirCall',     // $callback
       'postcotis',                 // $page
       'normal',                     // $context
       'high'                        // $priority
    );
    add_meta_box(
       'mailPost',          // $id
       'mail',                  // $title
       'mailCall',     // $callback
       'postcotis',                 // $page
       'normal',                     // $context
       'high'                        // $priority
    );
    add_meta_box(
       'telPost',          // $id
       'tel',                  // $title
       'telCall',     // $callback
       'postcotis',                 // $page
       'normal',                     // $context
       'high'                        // $priority
    );
    add_meta_box(
       'clienteEmpPost',          // $id
       'clienteEmp',                  // $title
       'clienteEmpCall',     // $callback
       'postcotis',                 // $page
       'normal',                     // $context
       'high'                        // $priority
    );
    add_meta_box(
       'clienteNomPost',          // $id
       'clienteNom',                  // $title
       'clienteNomCall',     // $callback
       'postcotis',                 // $page
       'normal',                     // $context
       'high'                        // $priority
    );
    add_meta_box(
       'fecha1Post',          // $id
       'fecha1',                  // $title
       'fecha1Call',     // $callback
       'postcotis',                 // $page
       'normal',                     // $context
       'high'                        // $priority
    );
    add_meta_box(
       'fecha2Post',          // $id
       'fecha2',                  // $title
       'fecha2Call',     // $callback
       'postcotis',                 // $page
       'normal',                     // $context
       'high'                        // $priority
    );
    add_meta_box(
       'descPost',          // $id
       'desc',                  // $title
       'descCall',     // $callback
       'postcotis',                 // $page
       'normal',                     // $context
       'high'                        // $priority
    );
    add_meta_box(
       'notasPost',          // $id
       'notas',                  // $title
       'notasCall',     // $callback
       'postcotis',                 // $page
       'normal',                     // $context
       'high'                        // $priority
    );
    add_meta_box(
       'ivaPost',          // $id
       'iva',                  // $title
       'ivaCall',     // $callback
       'postcotis',                 // $page
       'normal',                     // $context
       'high'                        // $priority
    );
    add_meta_box(
       'monedaPost',          // $id
       'moneda',                  // $title
       'monedaCall',     // $callback
       'postcotis',                 // $page
       'normal',                     // $context
       'high'                        // $priority
    );
    add_meta_box(
       'itemPost',          // $id
       'item',                  // $title
       'itemCall',     // $callback
       'postcotis',                 // $page
       'normal',                     // $context
       'high'                        // $priority
    );
    add_meta_box(
       'statusPost',          // $id
       'status',                  // $title
       'statusCall',     // $callback
       'postcotis',                 // $page
       'normal',                     // $context
       'high'                        // $priority
    );


    add_meta_box(
       'descPost',          // $id
       'desc',                  // $title
       'descCall',     // $callback
       'postproductos',                 // $page
       'normal',                     // $context
       'high'                        // $priority
    );
    add_meta_box(
       'precioPost',          // $id
       'precio',                  // $title
       'precioCall',     // $callback
       'postproductos',                 // $page
       'normal',                     // $context
       'high'                        // $priority
    );



    add_meta_box(
       'clienteEmpPost',          // $id
       'clienteEmp',                  // $title
       'clienteEmpCall',     // $callback
       'postclientes',                 // $page
       'normal',                     // $context
       'high'                        // $priority
    );
    add_meta_box(
       'clienteNomPost',          // $id
       'clienteNom',                  // $title
       'clienteNomCall',     // $callback
       'postclientes',                 // $page
       'normal',                     // $context
       'high'                        // $priority
    );


}



function statusCall( $post ) {
    $values = get_post_custom( $post->ID );
    if ( isset( $values['statusPost'] ) ) {
        $text = esc_attr( $values['statusPost'][0]);
    }
    wp_nonce_field( 'my_meta_box_nonce', 'meta_box_nonce' );
    ?>
    <input style="width:100%;" placeholder="" name="statusPost" value="<?php echo $text; ?>">
    <?php
}
function logoCall( $post ) {
    $values = get_post_custom( $post->ID );
    if ( isset( $values['logoPost'] ) ) {
        $text = esc_attr( $values['logoPost'][0]);
    }
    wp_nonce_field( 'my_meta_box_nonce', 'meta_box_nonce' );
    ?>
    <input style="width:100%;" placeholder="" name="logoPost" value="<?php echo $text; ?>">
    <?php
}
function dirCall( $post ) {
    $values = get_post_custom( $post->ID );
    if ( isset( $values['dirPost'] ) ) {
        $text = esc_attr( $values['dirPost'][0]);
    }
    wp_nonce_field( 'my_meta_box_nonce', 'meta_box_nonce' );
    ?>
    <input style="width:100%;" placeholder="" name="dirPost" value="<?php echo $text; ?>">
    <?php
}
function empresaCall( $post ) {
    $values = get_post_custom( $post->ID );
    if ( isset( $values['empresaPost'] ) ) {
        $text = esc_attr( $values['empresaPost'][0]);
    }
    wp_nonce_field( 'my_meta_box_nonce', 'meta_box_nonce' );
    ?>
    <input style="width:100%;" placeholder="" name="empresaPost" value="<?php echo $text; ?>">
    <?php
}
function telCall( $post ) {
    $values = get_post_custom( $post->ID );
    if ( isset( $values['telPost'] ) ) {
        $text = esc_attr( $values['telPost'][0]);
    }
    wp_nonce_field( 'my_meta_box_nonce', 'meta_box_nonce' );
    ?>
    <input style="width:100%;" placeholder="" name="telPost" value="<?php echo $text; ?>">
    <?php
}
function mailCall( $post ) {
    $values = get_post_custom( $post->ID );
    if ( isset( $values['mailPost'] ) ) {
        $text = esc_attr( $values['mailPost'][0]);
    }
    wp_nonce_field( 'my_meta_box_nonce', 'meta_box_nonce' );
    ?>
    <input style="width:100%;" placeholder="" name="mailPost" value="<?php echo $text; ?>">
    <?php
}
function clienteEmpCall( $post ) {
    $values = get_post_custom( $post->ID );
    if ( isset( $values['clienteEmpPost'] ) ) {
        $text = esc_attr( $values['clienteEmpPost'][0]);
    }
    wp_nonce_field( 'my_meta_box_nonce', 'meta_box_nonce' );
    ?>
    <input style="width:100%;" placeholder="" name="clienteEmpPost" value="<?php echo $text; ?>">
    <?php
}
function clienteNomCall( $post ) {
    $values = get_post_custom( $post->ID );
    if ( isset( $values['clienteNomPost'] ) ) {
        $text = esc_attr( $values['clienteNomPost'][0]);
    }
    wp_nonce_field( 'my_meta_box_nonce', 'meta_box_nonce' );
    ?>
    <input style="width:100%;" placeholder="" name="clienteNomPost" value="<?php echo $text; ?>">
    <?php
}
function descCall( $post ) {
    $values = get_post_custom( $post->ID );
    if ( isset( $values['descPost'] ) ) {
        $text = esc_attr( $values['descPost'][0]);
    }
    wp_nonce_field( 'my_meta_box_nonce', 'meta_box_nonce' );
    ?>
    <input style="width:100%;" placeholder="" name="descPost" value="<?php echo $text; ?>">
    <?php
}
function fecha1Call( $post ) {
    $values = get_post_custom( $post->ID );
    if ( isset( $values['fecha1Post'] ) ) {
        $text = esc_attr( $values['fecha1Post'][0]);
    }
    wp_nonce_field( 'my_meta_box_nonce', 'meta_box_nonce' );
    ?>
    <input style="width:100%;" placeholder="" name="fecha1Post" value="<?php echo $text; ?>">
    <?php
}
function fecha2Call( $post ) {
    $values = get_post_custom( $post->ID );
    if ( isset( $values['fecha2Post'] ) ) {
        $text = esc_attr( $values['fecha2Post'][0]);
    }
    wp_nonce_field( 'my_meta_box_nonce', 'meta_box_nonce' );
    ?>
    <input style="width:100%;" placeholder="" name="fecha2Post" value="<?php echo $text; ?>">
    <?php
}
function notasCall( $post ) {
    $values = get_post_custom( $post->ID );
    if ( isset( $values['notasPost'] ) ) {
        $text = esc_attr( $values['notasPost'][0]);
    }
    wp_nonce_field( 'my_meta_box_nonce', 'meta_box_nonce' );
    ?>
    <input style="width:100%;" placeholder="" name="notasPost" value="<?php echo $text; ?>">
    <?php
}
function ivaCall( $post ) {
    $values = get_post_custom( $post->ID );
    if ( isset( $values['ivaPost'] ) ) {
        $text = esc_attr( $values['ivaPost'][0]);
    }
    wp_nonce_field( 'my_meta_box_nonce', 'meta_box_nonce' );
    ?>
    <input style="width:100%;" placeholder="" name="ivaPost" value="<?php echo $text; ?>">
    <?php
}
function monedaCall( $post ) {
    $values = get_post_custom( $post->ID );
    if ( isset( $values['monedaPost'] ) ) {
        $text = esc_attr( $values['monedaPost'][0]);
    }
    wp_nonce_field( 'my_meta_box_nonce', 'meta_box_nonce' );
    ?>
    <input style="width:100%;" placeholder="" name="monedaPost" value="<?php echo $text; ?>">
    <?php
}
function itemCall( $post ) {
    $values = get_post_custom( $post->ID );
    if ( isset( $values['itemPost'] ) ) {
        $text = esc_attr( $values['itemPost'][0]);
    }
    wp_nonce_field( 'my_meta_box_nonce', 'meta_box_nonce' );
    ?>
    <input style="width:100%;" placeholder="" name="itemPost" value="<?php echo $text; ?>">
    <?php
}
function precioCall( $post ) {
    $values = get_post_custom( $post->ID );
    if ( isset( $values['precioPost'] ) ) {
        $text = esc_attr( $values['precioPost'][0]);
    }
    wp_nonce_field( 'my_meta_box_nonce', 'meta_box_nonce' );
    ?>
    <input style="width:100%;" placeholder="" name="precioPost" value="<?php echo $text; ?>">
    <?php
}



add_action( 'save_post', 'cd_meta_box_save' );
function cd_meta_box_save( $post_id ){
    // Bail if we're doing an auto save
    if( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;

     // if our nonce isn't there, or we can't verify it, bail
    if( !isset( $_POST['meta_box_nonce'] ) || !wp_verify_nonce( $_POST['meta_box_nonce'], 'my_meta_box_nonce' ) ) return;

    // if our current user can't edit this post, bail
    if( !current_user_can( 'edit_post' ) ) return;
    

    $allowed_protocols = array(
          'a' => array(
              'href' => array(),
              'title' => array()
          ),
          'br' => array(),
          'em' => array(),
          'strong' => array(),
        );

    if( isset( $_POST['logoPost'] ) ) {
        update_post_meta( $post_id, 'logoPost', wp_kses($_POST['logoPost'],$allowed_protocols) );
    } 
    if( isset( $_POST['empresaPost'] ) ) {
        update_post_meta( $post_id, 'empresaPost', wp_kses($_POST['empresaPost'],$allowed_protocols) );
    } 
    if( isset( $_POST['dirPost'] ) ) {
        update_post_meta( $post_id, 'dirPost', wp_kses($_POST['dirPost'],$allowed_protocols) );
    } 
    if( isset( $_POST['telPost'] ) ) {
        update_post_meta( $post_id, 'telPost', wp_kses($_POST['telPost'],$allowed_protocols) );
    } 
    if( isset( $_POST['mailPost'] ) ) {
        update_post_meta( $post_id, 'mailPost', wp_kses($_POST['mailPost'],$allowed_protocols) );
    } 
    if( isset( $_POST['descPost'] ) ) {
        update_post_meta( $post_id, 'descPost', wp_kses($_POST['descPost'],$allowed_protocols) );
    } 
    if( isset( $_POST['clienteEmpPost'] ) ) {
        update_post_meta( $post_id, 'clienteEmpPost', wp_kses($_POST['clienteEmpPost'],$allowed_protocols) );
    } 
    if( isset( $_POST['clienteNomPost'] ) ) {
        update_post_meta( $post_id, 'clienteNomPost', wp_kses($_POST['clienteNomPost'],$allowed_protocols) );
    } 
    if( isset( $_POST['fecha1Post'] ) ) {
        update_post_meta( $post_id, 'fecha1Post', wp_kses($_POST['fecha1Post'],$allowed_protocols) );
    } 
    if( isset( $_POST['fecha2Post'] ) ) {
        update_post_meta( $post_id, 'fecha2Post', wp_kses($_POST['fecha2Post'],$allowed_protocols) );
    }
    if( isset( $_POST['notasNomPost'] ) ) {
        update_post_meta( $post_id, 'notasNomPost', wp_kses($_POST['notasNomPost'],$allowed_protocols) );
    } 
    if( isset( $_POST['ivaPost'] ) ) {
        update_post_meta( $post_id, 'ivaPost', wp_kses($_POST['ivaPost'],$allowed_protocols) );
    } 
    if( isset( $_POST['monedaPost'] ) ) {
        update_post_meta( $post_id, 'monedaPost', wp_kses($_POST['monedaPost'],$allowed_protocols) );
    } 
    if( isset( $_POST['itemPost'] ) ) {
        update_post_meta( $post_id, 'itemPost', wp_kses($_POST['itemPost'],$allowed_protocols) );
    } 
    if( isset( $_POST['precioPost'] ) ) {
        update_post_meta( $post_id, 'precioPost', wp_kses($_POST['precioPost'],$allowed_protocols) );
    } 
    if( isset( $_POST['statusPost'] ) ) {
        update_post_meta( $post_id, 'statusPost', wp_kses($_POST['statusPost'],$allowed_protocols) );
    } 
    
}

?>