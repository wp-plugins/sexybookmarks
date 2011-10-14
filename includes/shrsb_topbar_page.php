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
        'advert' => '1'
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
                'topbar', 'useSbSettings' , 'tb_bg_color' ,'tb_button_color', 'advert'
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
                    <h2 class="fugue f-status"><?php _e('Shareaholic Social Engagement Analytics', 'shrsb'); ?></h2>
                </div>
				<div class="box-mid-body">
                        <div style="padding:8px;background:#FDF6E5;"><img src="<?php echo SHRSB_PLUGPATH; ?>images/line-chart.png" align="right" alt="New!" />
                                <?php
                                    $parse = parse_url(get_bloginfo('url'));
                                    $share_url = "http://www.shareaholic.com/api/data/".$parse['host']."/sharecount/30";
                                    $top_users_url =  "http://www.shareaholic.com/api/data/".$parse['host']."/topusers/16/";

                                    echo sprintf(__('<b style="font-size:14px;line-height:22px;">Did you know that content from this website has been shared <span style="color:#CC1100;"><span id="bonusShareCount"></span> time(s)</span> in the past <span id="bonusShareTimeFrame"></span> day(s)?</b>', 'shrsb'));
                                ?>

                                <script type ="text/javascript">
                                    (function($){
                                        $(document).ready( function () {
                                            var url = <?php echo "'".$share_url."'";?>;
                                            var top_users_url  = <?php echo "'".$top_users_url."'";?>;
                                            $.getJSON(url+'?callback=?', function (obj) {
                                                $('#bonusShareCount').text(obj.sharecount);
                                                $('#bonusShareTimeFrame').text(obj.timeframe);
                                            });

                                            $.getJSON(top_users_url+'?callback=?', function (obj) {
                                                add_faces(obj);
                                            });
                                        });

                                        var add_faces = function(obj) {
                                            if(obj && obj.length) {
                                                var shuffle = function(v){
                                                    //+ Jonas Raoni Soares Silva
                                                    //@ http://jsfromhell.com/array/shuffle [rev. #1]
                                                    for(var j, x, i = v.length; i; j = parseInt(Math.random() * i), x = v[--i], v[i] = v[j], v[j] = x);
                                                    return v;
                                                };
                                                obj = shuffle(obj);

                                                $('#bonusShareTopUser').show();
                                                var face_ul = $('<ul id="bonusShareFacesUL"/>');
                                                for(var i=0; i<obj.length; ++i) {
                                                    var shr_profile_url = "http://www.shareaholic.com/" + obj[i].username;
                                                    face_ul.append(
                                                        $("<li class='bonusShareLi'>").append("<a target='_blank' href="+shr_profile_url+"><img class='bonusShareFaces' title=" + obj[i].username + " src=" + obj[i].picture_url + "></img></a>")
                                                    );
                                                }

                                                $('#bonusShareTopUser').append(face_ul);

                                            }
                                        };
                                    })(jQuery);
                                </script>
                                <br/><br/>
                                <div id="bonusShareTopUser" style="display:none"><b><?php _e('Meet the people who spread your content the most:', 'shrsb'); ?></b></div>

                                <br />
                                <div style="background: url(http://www.shareaholic.com/media/images/border_hr.png) repeat-x scroll left top; height: 2px;"></div>
                                <br />
                                  <?php  echo sprintf(__('What are you waiting for? <b>Access detailed %ssocial engagement analytics%s about your website for FREE right now!</b><br><br>You have been selected to preview the upcoming premium analytics add-on for SexyBookmarks for FREE for a limited time - so hurry before it is too late! These analytics are designed to help you grow your traffic and referrals.', 'shrsb'), '<a href="http://www.shareaholic.com/siteinfo/'.$parse['host'].'">', '</a>');
                                ?>

                        </div>
                </div>
            </li>
            
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
                                        <td style="width:125px"><label><input <?php echo (($shrsb_tb_plugopts['advert'] == "1")? 'checked="checked"' : ""); ?> name="advert" id="advert-yes" type="radio" value="1" /> <?php _e('Yes', 'shrsb'); ?></label>
                                        </td><td><label><input <?php echo (($shrsb_tb_plugopts['advert'] == "0")? 'checked="checked"' : ""); ?> name="advert" id="advert-no" type="radio" value="0" /> <?php _e('No', 'shrsb'); ?></label>
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
<div id="shrsb-col-right">

    <h2 class="sh-logo"></h2>

	<div class="box-right">
		<div class="box-right-head">
			<h3 class="fugue f-info-frame"><?php _e('Helpful Plugin Links', 'shrsb'); ?></h3>
		</div>
		<div class="box-right-body">
			<div class="padding">
				<ul class="infolinks">
					<li><a href="http://www.shareaholic.com/tools/wordpress/usage-installation" target="_blank"><?php _e('Installation &amp; Usage Guide', 'shrsb'); ?></a></li>
					<li><a href="http://www.shareaholic.com/tools/wordpress/faq" target="_blank"><?php _e('Frequently Asked Questions', 'shrsb'); ?></a></li>
					<li><a href="http://sexybookmarks.shareaholic.com/contact-forms/bug-form" target="_blank"><?php _e('Bug Submission Form', 'shrsb'); ?></a></li>
					<li><a href="http://sexybookmarks.shareaholic.com/contact-forms/feature-request" target="_blank"><?php _e('Feature Request Form', 'shrsb'); ?></a></li>
					<li><a href="http://www.shareaholic.com/tools/wordpress/translations" target="_blank"><?php _e('Submit a Translation', 'shrsb'); ?></a></li>
					<li><a href="http://www.shareaholic.com/tools/browser/" target="_blank"><?php _e('Shareaholic Browsers Add-ons', 'shrsb'); ?></a></li>
					<li><a href="http://www.shareaholic.com/tools/wordpress/credits" target="_blank"><?php _e('Thanks &amp; Credits', 'shrsb'); ?></a></li>
				</ul>
			</div>
		</div>
	</div>

	<div style="padding:15px;"><iframe src="http://www.facebook.com/plugins/like.php?href=http%3A%2F%2Fwww.facebook.com%2FShareaholic&amp;layout=standard&amp;show_faces=true&amp;width=240&amp;action=like&amp;font=lucida+grande&amp;colorscheme=light&amp;height=80" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:240px; height:80px;" allowTransparency="true"></iframe>
	</div>

</div>
<?php

echo get_snapengage();

}//closing brace for function "shrsb_settings_page"

?>

