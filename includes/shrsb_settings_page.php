<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */


/*
 * @desc Like button Set Settings
 */
function shrsb_likeButtonSetHTML($pos = 'Bottom') {   // $pos = Bottom/Top
    global $shrsb_plugopts;
    ?>

    <table><tbody style ="display:none" class="likeButtonsAvailable<?php echo $pos;?>">
            <tr class="tabForTr">
                <td><span class="shrsb_option"><?php _e('Include Facebook Like Button', 'shrsb'); ?> <span style="color:red;">*</span></span>
                </td>
                <td style="width:125px"><label><input <?php echo (($shrsb_plugopts["fbLikeButton$pos"] == "1")? 'checked="checked"' : ""); ?> name="fbLikeButton<?php echo $pos;?>" id="fbLikeButton<?php echo $pos;?>-yes" type="radio" value="1" /> <?php _e('Yes', 'shrsb'); ?></label>
                </td><td><label><input <?php echo (($shrsb_plugopts["fbLikeButton$pos"] == "0")? 'checked="checked"' : ""); ?> name="fbLikeButton<?php echo $pos;?>" id="fbLikeButton<?php echo $pos;?>-no" type="radio" value="0" /> <?php _e('No', 'shrsb'); ?></label>
                </td>
            </tr>
            <tr class="tabForTr">
                <td><span class="shrsb_option"><?php _e('Include Facebook Send Button', 'shrsb'); ?> <span style="color:red;">*</span></span>
                </td>
                <td style="width:125px"><label><input <?php echo (($shrsb_plugopts["fbSendButton$pos"] == "1")? 'checked="checked"' : ""); ?> name="fbSendButton<?php echo $pos;?>" id="fbSendButton<?php echo $pos;?>-yes" type="radio" value="1" /> <?php _e('Yes', 'shrsb'); ?></label>
                </td><td><label><input <?php echo (($shrsb_plugopts["fbSendButton$pos"] == "0")? 'checked="checked"' : ""); ?> name="fbSendButton<?php echo $pos;?>" id="fbSendButton<?php echo $pos;?>-no" type="radio" value="0" /> <?php _e('No', 'shrsb'); ?></label>
                </td>
            </tr>
            <tr class="tabForTr">
                <td><span class="shrsb_option"><?php _e('Include Google +1 Button', 'shrsb'); ?> <span style="color:red;">*</span></span>
                </td>
                <td style="width:125px"><label><input <?php echo (($shrsb_plugopts["googlePlusOneButton$pos"] == "1")? 'checked="checked"' : ""); ?> name="googlePlusOneButton<?php echo $pos;?>" id="googlePlusOneButton<?php echo $pos;?>-yes" type="radio" value="1" /> <?php _e('Yes', 'shrsb'); ?></label>
                </td><td><label><input <?php echo (($shrsb_plugopts["googlePlusOneButton$pos"] == "0")? 'checked="checked"' : ""); ?> name="googlePlusOneButton<?php echo $pos;?>" id="googlePlusOneButton<?php echo $pos;?>-no" type="radio" value="0" /> <?php _e('No', 'shrsb'); ?></label>
                </td>
            </tr>
            <tr class="tabForTr">
                <td><span class="shrsb_option"><?php _e('Include Tweet Button', 'shrsb'); ?> <span style="color:red;">*</span></span>
                </td>
                <td style="width:125px"><label><input <?php echo (($shrsb_plugopts["tweetButton$pos"] == "1")? 'checked="checked"' : ""); ?> name="tweetButton<?php echo $pos;?>" id="tweetButton<?php echo $pos;?>-yes" type="radio" value="1" /> <?php _e('Yes', 'shrsb'); ?></label>
                </td><td><label><input <?php echo (($shrsb_plugopts["tweetButton$pos"] == "0")? 'checked="checked"' : ""); ?> name="tweetButton<?php echo $pos;?>" id="tweetButton<?php echo $pos;?>-no" type="radio" value="0" /> <?php _e('No', 'shrsb'); ?></label>
                </td>
            </tr>

            <tr class="tabForTr likeButtonSetOptions<?php echo $pos;?>" id="likeButtonSetAlignment<?php echo $pos;?>" style="display:none">
                <td>
                    <span class="tab shrsb_option" style="display:block"><?php _e('Button Alignment (w.r.t post)', 'shrsb'); ?></span>
                </td>
                <td colspan="2">
                    <select name="likeButtonSetAlignment<?php echo $pos;?>">
                        <?php
                            print shrsb_select_option_group(
                                'likeButtonSetAlignment'.$pos, array(
                                    '0'=>__('Left Aligned', 'shrsb'),
                                    '1'=>__('Right Aligned', 'shrsb')
                                )
                            );
                        ?>
                    </select>
                </td>
            </tr>
            <tr class ="tabForTr likeButtonSetOptions<?php echo $pos;?>" style="display:none">
                <td>
                    <span class="tab shrsb_option" style="display:block"><?php _e('Button Style', 'shrsb'); ?></span>
                </td>
                <td style="width:125px">
                    <select name="likeButtonSetSize<?php echo $pos;?>">
                        <?php
                            print shrsb_select_option_group(
                                "likeButtonSetSize$pos", array(
                                    '0'=>__('Standard', 'shrsb'),
                                    '1'=>__('Buttons', 'shrsb'),
                                    '2'=>__('Box', 'shrsb'),
                                )
                            );
                        ?>
                    </select>
                </td>

            </tr>

            <tr class ="tabForTr likeButtonSetOptions<?php echo $pos;?>" style="display:none">
                <td>
                    <span class="tab shrsb_option" style="display:block"><?php _e('Show counter for +1 Button:', 'shrsb'); ?></span>
                </td>
                <td style="width:125px">
                    <select name="likeButtonSetCount<?php echo $pos;?>">
                        <?php
                            print shrsb_select_option_group(
                                "likeButtonSetCount$pos", array(
                                    'true'=>__('Yes', 'shrsb'),
                                    'false'=>__('No', 'shrsb'),
                                )
                            );
                        ?>
                    </select>
                </td>

            </tr>

            <tr class ="tabForTr likeButtonSetOptions<?php echo $pos;?>" style="display:none">
                <td rowspan="4" colspan="3" >
                    <small><?php _e('Drag to reorder.', 'shrsb'); ?></small>

                    <div style="clear: both; min-height: 1px; height: 5px; width: 100%;"></div>
                    <div id="buttonPreviews<?php echo $pos;?>" style="clear: both; max-height: 100px !important; max-width: 600px !important;"><ul>
                        <?php
                            $fbLikeHTML = '<li ><div style="display:none; cursor:move;" class="likebuttonpreview'.$pos.'">
                                        <input name="likeButtonOrder'.$pos.'[]" type="hidden" value="shr-fb-like"/>
                                    </div></li>';
                            $plusOneHTML = '<li><div style=" display:none; cursor:move;" class="plusonepreview'.$pos.'">
                                            <input name="likeButtonOrder'.$pos.'[]" type="hidden" value="shr-plus-one"/>
                                    </div></li>';

                            $fbSendHTML = '<li><div style = "display:none; cursor:move;" class="sendbuttonpreview'.$pos.' shr-fb-send">
                                        <input name="likeButtonOrder'.$pos.'[]" type="hidden" value="shr-fb-send"/>
                                    </div></li>';
                            $tweetButtonHTML = '<li><div style = "display:none; cursor:move;" class="tweetbuttonpreview'.$pos.' shr-tw-button">
                                        <input name="likeButtonOrder'.$pos.'[]" type="hidden" value="shr-tw-button"/>
                                    </div></li>';

                            foreach($shrsb_plugopts['likeButtonOrder'.$pos] as $likeOption) {
                                switch($likeOption) {
                                    case "shr-fb-like":
                                        echo $fbLikeHTML;
                                        break;
                                    case "shr-plus-one":
                                        echo $plusOneHTML;
                                        break;
                                    case "shr-fb-send":
                                        echo $fbSendHTML;
                                        break;
                                    case "shr-tw-button":
                                        echo $tweetButtonHTML;
                                        break;
                                }
                            }
                        ?>
                    </ul></div>
                </td>
            </tr>
            <tr height="60px">
                <script>
                (function ($) {
                    var renderPlusOnes = function () {
                            var size = $('select[name$="likeButtonSetSize<?php echo $pos;?>"]').val();
                            switch(size) {
                                case '1':
                                    size = "button";
                                    break;
                                case '2':
                                    size = "box";
                                    break;
                                default:
                                    size = "standard";
                                    break;
                            }
                            var count = $('select[name$="likeButtonSetCount<?php echo $pos;?>"]').val();
                            switch(count) {
                                case 'false':
                                    count = '';
                                    break;
                                default:
                                    count = '-count';
                                    break;
                            }
                            var classN = 'shr-plus-one-' + size + count;
                            classN = "plusonepreview<?php echo $pos;?> "  + classN;
                            $('.plusonepreview<?php echo $pos;?>').removeClass().addClass(classN);

                    };
                    $('select[name$="likeButtonSetCount<?php echo $pos;?>"],select[name$="likeButtonSetSize<?php echo $pos;?>"]').change(function () {
                        renderPlusOnes();
                    });

                    renderPlusOnes();
                    
                    var renderTweetButton = function () {
                        var layout = $('select[name$="likeButtonSetSize<?php echo $pos;?>"]').val();
                        switch(layout) {
                            case '1':
                                layout = "button";
                                break;
                            case '2':
                                layout = "box";
                                break;
                            default:
                                layout = "standard";
                                break;
                        }
                        var classN = 'shr-tw-button-' + layout;
                        classN = "likebuttonpreview<?php echo $pos;?> "  + classN;
                        $('.likebuttonpreview<?php echo $pos;?>').removeClass().addClass(classN);
                    };

                    $('select[name$="likeButtonSetCount<?php echo $pos;?>"],select[name$="likeButtonSetSize<?php echo $pos;?>"]').change(function () {
                        renderTweetButton();
                    });
                    renderTweetButton();


                    var renderLikeButtonPreview = function () {
                        var layout = $('select[name$="likeButtonSetSize<?php echo $pos;?>"]').val();
                        switch(layout) {
                            case '1':
                                layout = "button";
                                break;
                            case '2':
                                layout = "box";
                                break;
                            default:
                                layout = "standard";
                                break;
                        }
                        var classN = 'shr-fb-like-' + layout;
                        classN = "likebuttonpreview<?php echo $pos;?> "  + classN;
                        $('.likebuttonpreview<?php echo $pos;?>').removeClass().addClass(classN);
                    };

                    $('select[name$="likeButtonSetSize<?php echo $pos;?>"]').change(function () {
                        renderLikeButtonPreview();
                    });
                    renderLikeButtonPreview();
                })(jQuery);
            </script>
            </tr>
            <tr></tr>
            <tr></tr>


<?php
}



?>
