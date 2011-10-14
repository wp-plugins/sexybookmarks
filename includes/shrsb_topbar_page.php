<?php
/* 
 * @desc All Topbar functions and values which are used on every page load
*/

//Initialing the topbar settings array
$shrsb_tb_plugopts = shrsb_tb_set_options();

/*
 * @desc Set the settings either from database or default
 */
function shrsb_tb_set_options($action = NULL){
    
    //Default Settigs array
    $shrsb_tb_plugopts_default = array(
        'topbar' => '1',
        'useSbSettings' => '1',
        'tb_bg_color' => '#000000',
        'tb_button_color' => '#7777cc',
        'addv' => '1'
    );
    
    //Return default settings 
    if($action == "reset"){
        update_option("ShareaholicTopbar",$shrsb_tb_plugopts_default);
        return $shrsb_tb_plugopts_default;
    }
    
    //Get the settings from the database
    $database_Settings =  get_option('ShareaholicTopbar');
    if($database_Settings){
        $need_to_update = false;
            
            //Check whether all the settings are present or not
            foreach($shrsb_tb_plugopts_default as $k => $v){
                //echo "$k => $v <br/>";
                if( !isset( $database_Settings[$k] )) {
                    $database_Settings[$k] = $v;
                    $need_to_update = true;
                }
            }
            if($need_to_update) update_option("ShareaholicTopbar",$database_Settings);
        return $database_Settings;
    }else{
        //Add the settings
        add_option('ShareaholicTopbar',$shrsb_tb_plugopts_default);
        return $shrsb_tb_plugopts_default;
    }
}

?>

