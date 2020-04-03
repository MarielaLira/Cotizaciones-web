<?php
    require_once('../../../wp-load.php');
    if(empty($_POST) || !isset($_POST)) {
        ajaxStatus('error', 'Nothing to update.');
    } else {
        try {
            $user = wp_get_current_user();
            $viewPref = $_POST['viewPref'];
            $name = $_POST['name'];
            
            update_user_meta( $user->ID, $name, $viewPref );
            // echo (get_user_notes($name));
            die();
        } catch (Exception $e){
            echo 'Caught exception: ',  $e->getMessage(), "\n";
        }
    }

    



?>