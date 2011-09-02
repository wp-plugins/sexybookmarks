<?php

/*
 * Creating the widget for the Wordpress Dashboard
 */

class ShareaholicWidget extends WP_Widget{
    
    function ShareaholicWidget(){
        //Actula Widget Code goes here
        parent::WP_Widget(false,$name = "Shareaholic Analytics");
    }
    
    function top_sharers(){
        echo '<script type="text/javascript" src="//shareaholic.com/media/js/topsharers.js?domain=google.com"></script>';
    }
    
    function widget($args,$instance){
        //Output the Widget Contet
        extract($args);
        echo '<script type="text/javascript" src="//shareaholic.com/media/js/topsharers.js?domain=google.com"></script>';
        //top_sharers();
    }
    
    function update($new_instance, $old_instance){
        //process and save the widget options
        return $new_instance;
    }
    
    function form($instance){
        //Output the Options for admin
    }
    


}



function shrsb_register_widget() {
    register_widget('ShareaholicWidget');
}

add_action( 'widgets_init', 'shrsb_register_widget' );
?>


