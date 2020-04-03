<?php
function save_user_data(){
    global $current_user;
    get_currentuserinfo();
    update_user_meta( $current_user->ID, 'user_notes', 'notes');
            
    
}

function get_user_notes(){
    global $current_user;
        // get current user info
        get_currentuserinfo();
        $old_notes = get_user_meta($current_user->ID, 'user_notes', true);
        
        if (isset($old_notes)){
            if (is_array($old_notes)){//more then one
                foreach($old_notes as $note){
                    $re .= '<p><strong>note:</strong></p>' . $note . '<br />'; 
                }
            }
        }
        return $re;
    
}

save_user_data();
echo (get_user_notes());







?>