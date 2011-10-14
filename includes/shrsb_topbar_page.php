<?php
/* 
 * Feature: Topbar
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
        return $database_Settings;
    }else{
        //Add the settings
        add_option($shrsb_tb_plugopts_default);
        return $shrsb_tb_plugopts_default;
    }
}


//write settings page
function shrsb_tb_settings_page() {
	global $shrsb_tb_plugopts;
    // Add all the global varaible declarations for the $shrsb_tb_plugopts
	echo '<div class="wrap""><div class="icon32" id="icon-options-general"><br></div><h2>Shareaholic Topbar Settings</h2></div>';
    //Defaults - set if not present
    if (!isset($_POST['reset_all_options'])){$_POST['reset_all_options'] = '1';}
    if (!isset($_POST['shrsbresetallwarn-choice'])){$_POST['shrsbresetallwarn-choice'] = 'no';}
    
	if($_POST['reset_all_options'] == '0') {
		echo '
		<div id="shrsbresetallwarn" class="dialog-box-warning" style="float:none;width:97%;">
			<div class="dialog-left fugue f-warn">
				'.__("WARNING: You are about to reset all settings to their default state! Do you wish to continue?", "shrsb").'
			</div>
			<div class="dialog-right">
				<form action="" method="post" id="resetalloptionsaccept">
					<label><input name="shrsbresetallwarn-choice" id="shrsbresetallwarn-yes" type="radio" value="yes" />'.__('Yes', 'shrsb').'</label> &nbsp; <label><input name="shrsbresetallwarn-choice" id="shrsbresetallwarn-cancel" type="radio" value="cancel" />'.__('Cancel', 'shrsb').'</label>
				</form>
			</div>
		</div>';
	}

	//Reset all options to default settings if user clicks the reset button
	if($_POST['shrsbresetallwarn-choice'] == "yes") { //check for reset button click
		delete_option('ShareaholicTopbar');
		$shrsb_tb_plugopts = shrsb_tb_set_options("reset");
        
		//delete_option('SHRSB_CustomSprite');
		echo '
		<div id="statmessage" class="shrsb-success">
			<div class="dialog-left fugue f-success">
				'.__('All settings have been reset to their default values.', 'shrsb').'
			</div>
			<div class="dialog-right">
				<img src="'.SHRSB_PLUGPATH.'images/success-delete.jpg" class="del-x" alt=""/>
			</div>
		</div>';
	}

	// processing form submission
	$status_message = "";
	$error_message = "";
	if(isset($_POST['save_changes'])) {

    	// Set success message
		$status_message = __('Your changes have been saved successfully!', 'shrsb');

        foreach (array(
                'topbar', 'useSbSettings' , 'tb_bg_color' ,'tb_button_color', 'addv'
            )as $field) {
                if(isset($_POST[$field])) { // this is to prevent warning if $_POST[$field] is not defined
                    $shrsb_tb_plugopts[$field] = $_POST[$field];
                } else {
                    $shrsb_tb_plugopts[$field] = NULL;
                }
          }
          
          update_option('ShareaholicTopbar', $shrsb_tb_plugopts);
          
      
  }//Closed Save

	//if there was an error, construct error messages
	if ($error_message != '') {
		echo '
		<div id="errmessage" class="shrsb-error">
			<div class="dialog-left fugue f-error">
				'.$error_message.'
			</div>
			<div class="dialog-right">
				<img src="'.SHRSB_PLUGPATH.'images/error-delete.jpg" class="del-x" alt=""/>
			</div>
		</div>';
	} elseif ($status_message != '') {
		echo '<style type="text/css">#update_sb{display:none !important;}</style>
		<div id="statmessage" class="shrsb-success">
			<div class="dialog-left fugue f-success">
				'.$status_message.'
			</div>
			<div class="dialog-right">
				<img src="'.SHRSB_PLUGPATH.'images/success-delete.jpg" class="del-x" alt=""/>
			</div>
		</div>';
	}
?>

<form name="sexy-bookmarks" id="sexy-bookmarks" action="" method="post">
	<div id="shrsb-col-left">
		<ul id="shrsb-sortables">
            
            <li>
				<div class="box-mid-head">
					<h2 class="fugue f-globe-plus"><?php _e('Top Sharing Bar [BETA]', 'shrsb'); ?></h2>
				</div>
                <div class="box-mid-body" id="toggle2">
					<div class="padding">
						<div id="genopts">

                                    <table><tbody>
                                    <tr>
                                        <td><span class="shrsb_option"><?php _e('Enable the Top Sharing Bar?', 'shrsb'); ?> <span style="color:red;">*</span></span>
                                        </td>
                                        <td style="width:125px"><label><input <?php echo (($shrsb_tb_plugopts['topbar'] == "1")? 'checked="checked"' : ""); ?> name="topbar" id="topbar-yes" type="radio" value="1" /> <?php _e('Yes', 'shrsb'); ?></label>
                                        </td><td><label><input <?php echo (($shrsb_tb_plugopts['topbar'] == "0")? 'checked="checked"' : ""); ?> name="topbar" id="topbar-no" type="radio" value="0" /> <?php _e('No', 'shrsb'); ?></label>
                                        </td>
                                    </tr>
                                    
                                    <tr>
                                        <td><span class="shrsb_option"><?php _e('Use Sexybookmark Settings?', 'shrsb'); ?> <span style="color:red;">*</span></span>
                                        </td>
                                        <td style="width:125px"><label><input <?php echo (($shrsb_tb_plugopts['useSbSettings'] == "1")? 'checked="checked"' : ""); ?> name="useSbSettings" id="useSbSettings-yes" type="radio" value="1" /> <?php _e('Yes', 'shrsb'); ?></label>
                                        </td><td><label><input <?php echo (($shrsb_tb_plugopts['useSbSettings'] == "0")? 'checked="checked"' : ""); ?> name="useSbSettings" id="useSbSettings-no" type="radio" value="0" /> <?php _e('No', 'shrsb'); ?></label>
                                        </td>
                                    </tr>
                                    <tr class="topbar_prefs" style="display:none">
                                                <td><label class="tab" for="tb_bg_color" style="margin-top:7px;"><?php _e('Background Color for Toolbar:', 'shrsb'); ?></label></td>
                                                <td><input style="margin-top:7px;" type="text" id="tb_bg_color" name="tb_bg_color" value="<?php echo $shrsb_tb_plugopts['tb_bg_color']; ?>" /></td>
                                                <td><div id="tb_bg_color_picker" class ="color_selector">
                                                    <div style="background-color:<?php echo $shrsb_tb_plugopts['tb_bg_color']; ?>; "></div>
                                                </div>
                                                </td>
                                                <td><div id="tb_bg_color_picker_holder" style="display:none; margin-top: 5px; position: absolute;" ></div></td>
                                                <td> <div id="tb_bg_color_reset" style="margin-left: 5px;"><a href="javascript:void(0);"><?php _e('reset', 'shrsb'); ?></a></div></td>
                                    </tr>
                                    <tr class="topbar_prefs" style="display:none">
                                                <td><label class="tab" for="tb_button_color" style="margin-top:7px;"><?php _e('Button Color for Toolbar:', 'shrsb'); ?></label></td>
                                                <td><input style="margin-top:7px;" type="text" id="tb_button_color" name="tb_button_color" value="<?php echo $shrsb_tb_plugopts['tb_button_color']; ?>" /></td>
                                                <td><div id="tb_button_color_picker" class ="color_selector">
                                                    <div style="background-color:<?php echo $shrsb_tb_plugopts['tb_button_color']; ?>; "></div>
                                                </div>
                                                </td>
                                                <td><div id="tb_button_color_picker_holder" style="display:none; margin-top: 5px; position: absolute;" ></div></td>
                                                <td> <div id="tb_button_color_reset" style="margin-left: 5px;"><a href="javascript:void(0);"><?php _e('reset', 'shrsb'); ?></a></div></td>
                                    </tr>
                                    
                                    <tr>
                                        <td><span class="shrsb_option"><?php _e('Show Message?', 'shrsb'); ?> <span style="color:red;">*</span></span>
                                        </td>
                                        <td style="width:125px"><label><input <?php echo (($shrsb_tb_plugopts['addv'] == "1")? 'checked="checked"' : ""); ?> name="addv" id="addv-yes" type="radio" value="1" /> <?php _e('Yes', 'shrsb'); ?></label>
                                        </td><td><label><input <?php echo (($shrsb_tb_plugopts['addv'] == "0")? 'checked="checked"' : ""); ?> name="addv" id="addv-no" type="radio" value="0" /> <?php _e('No', 'shrsb'); ?></label>
                                        </td>
                                    </tr>
                                    
                                    </tbody></table>
                                    
                                <br />

<!--                                <span style="display:block;"><?php echo sprintf(__('Check out %sour blog%s for additional customization options.', 'shrsb'), '<a target="_blank" href="http://blog.shareaholic.com/?p=1917">', '</a>'); ?></span><br />-->
    							<span style="display:block;"><span style="color:red;">* <?php _e('switch on "new" mode below to enable these exclusive features', 'shrsb'); ?></span></span>

                        </div>
                    </div>
                </div>

            </li>

			
		</ul>
		<div style="clear:both;"></div>
		<input type="hidden" name="save_changes" value="1" />
        <div class="shrsbsubmit"><input type="submit" id="save_changes" value="<?php _e('Save Changes', 'shrsb'); ?>" /></div>
	</form>
	<form action="" method="post">
		<input type="hidden" name="reset_all_options" id="reset_all_options" value="0" />
		<div class="shrsbreset"><input type="submit" value="<?php _e('Reset Settings', 'shrsb'); ?>" /></div>
	</form>
</div>

<?php

//Right Side helpful links
echo shrsb_right_side_menu();
//Snap Engage
echo get_snapengage();

}//closing brace for function "shrsb_settings_page"

?>

