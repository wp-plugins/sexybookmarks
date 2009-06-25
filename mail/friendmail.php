<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<meta http-equiv="content-type" content="text/html; charset=windows-1250">
<title>Contact</title> 
<link href="stylesheet.css" rel="stylesheet" type="text/css" />
</head>
  

<body>

	<div id="contact">
	
<?php

		
		$error    = '';
        $name     = ''; 
        $from_email    = ''; 
        $to_email    = ''; 
        $subject  = ''; 
        $comments = ''; 
        $verify   = '';
		
        if(isset($_POST['contactus'])) {
        
		$name     = $_POST['name'];
        $from_email    = $_POST['femail'];
		$to_email    = $_POST['temail'];
        $subject  = $_POST['subject'];
        $comments = $_POST['comments'];
        $verify   = $_POST['verify'];
		

        if(trim($name) == '') {
        	$error = '<div class="error_message">Attention! You must enter your name.</div>';
        } else if(trim($from_email) == '') {
        	$error = '<div class="error_message">Attention! Please enter your email address.</div>';
        }  else if(trim($to_email) == '') {
        	$error = '<div class="error_message">Attention! Please enter a recipient email address.</div>';
        } else if(!isEmail($from_email)) {
        	$error = '<div class="error_message">Attention! Your email address seems to be invalid, please try again.</div>';
        } else if(!isEmail2($to_email)) {
        	$error = '<div class="error_message">Attention! The recipient email address you\'ve entered seems to be invalid, please try again.</div>';
        }
		
        if(trim($subject) == '') {
        	$error = '<div class="error_message">Attention! Please enter a subject.</div>';
        } else if(trim($comments) == '') {
        	$error = '<div class="error_message">Attention! Please enter your message.</div>';
        } else if(trim($verify) == '') {
	    	$error = '<div class="error_message">Attention! Please enter the verification number.</div>';
	    } else if(trim($verify) != '4') {
	    	$error = '<div class="error_message">Attention! The verification number you entered is incorrect.</div>';
	    }
		
        if($error == '') {
        
			if(get_magic_quotes_gpc()) {
            	$comments = stripslashes($comments);
            }


         // Configuration option.
		 // Enter the email address that you want to emails to be sent to.
		 // Example $address = "joe.doe@yourdomain.com";
		 
         // $address = "example@themeforest.com";


         // Configuration option.
         // i.e. The standard subject will appear as, "You've been contacted by John Doe."
		 
         // Example, $e_subject = '$name . ' has contacted you via Your Website.';

         $e_subject = $subject;


         // Configuration option.
		 // You can change this if you feel that you need to.
		 // Developers, you may wish to add more fields to the form, in which case you must be sure to add them here.
		$prevpage = $_SERVER['HTTP_REFERER' -2];
		 $e_body = "$name has emailed you in regards to \"$subject\", which can be found at: $prevpage \r\n\n";
		 $e_content = "\"$comments\"\r\n\n";
		 $e_reply = "You can contact $name via email: $from_email \r\n\n\r\n\nThis message was sent automatically via the SexyBookmarks WordPress Plugin's \"Email a Friend\" option.";
					
         $msg = $e_body . $e_content . $e_reply;

         mail($to_email, $e_subject, $msg, "From: $from_email\r\nReply-To: $from_email\r\nReturn-Path: $from_email\r\n");


		 // Email has sent successfully, echo a success page.
					
		 echo "<div id='succsess_page'>";
		 echo "<h1>Email Sent Successfully!</h1>";
		 echo "<p>Thank you <strong>$name</strong>, you have successfully emailed this article to your chosen recipient.</p>";
		 echo "</div>";
                      
		}
	}

         if(!isset($_POST['contactus']) || $error != '') // Do not edit.
         {
?>
            
            <?php echo $error; ?>
            
            <fieldset>
            
            <legend>Please fill out all required fields before sending</legend>

            <form  method="post" action="">

			<label for=name accesskey=U><span class="required">*</span> Your Name</label>
            <input name="name" type="text" id="name" size="30" value="<?php echo $name; ?>" />

			<br />
            <label for=femail accesskey=E><span class="required">*</span>Your Email</label>
            <input name="femail" type="text" id="femail" size="30" value="<?php echo $from_email; ?>" />

			<br />
            <label for=temail accesskey=T><span class="required">*</span>Recipient Email</label>
            <input name="temail" type="text" id="temail" size="30" value="<?php echo $to_email; ?>" />

			<br />
            <label for=subject accesskey=S><span class="required">*</span> Subject</label>
			<input name="subject" type="text" id="subject" size="30" value="<?php echo $title; ?>" />

			<br />
            <label for=comments accesskey=C><span class="required">*</span> Your comments</label>
            <textarea name="comments" cols="40" rows="3"  id="comments"><?php echo $sexy_teaser; ?></textarea>

            <hr />
            
            <p><span class="required">*</span> Are you human?</p>
            
            <label for=verify accesskey=V>&nbsp;&nbsp;&nbsp;3 + 1 =</label>
			<input name="verify" type="text" id="verify" size="4" value="<?php echo $verify; ?>" /><br /><br />

            <input name="contactus" type="submit" class="submit" id="contactus" value="Submit" />

            </form>
            
            </fieldset>

            
<?php		}
	
		function isEmail($from_email) { // Email address verification, do not edit.
		return(preg_match("/^[-_.[:alnum:]]+@((([[:alnum:]]|[[:alnum:]][[:alnum:]-]*[[:alnum:]])\.)+(ad|ae|aero|af|ag|ai|al|am|an|ao|aq|ar|arpa|as|at|au|aw|az|ba|bb|bd|be|bf|bg|bh|bi|biz|bj|bm|bn|bo|br|bs|bt|bv|bw|by|bz|ca|cc|cd|cf|cg|ch|ci|ck|cl|cm|cn|co|com|coop|cr|cs|cu|cv|cx|cy|cz|de|dj|dk|dm|do|dz|ec|edu|ee|eg|eh|er|es|et|eu|fi|fj|fk|fm|fo|fr|ga|gb|gd|ge|gf|gh|gi|gl|gm|gn|gov|gp|gq|gr|gs|gt|gu|gw|gy|hk|hm|hn|hr|ht|hu|id|ie|il|in|info|int|io|iq|ir|is|it|jm|jo|jp|ke|kg|kh|ki|km|kn|kp|kr|kw|ky|kz|la|lb|lc|li|lk|lr|ls|lt|lu|lv|ly|ma|mc|md|mg|mh|mil|mk|ml|mm|mn|mo|mp|mq|mr|ms|mt|mu|museum|mv|mw|mx|my|mz|na|name|nc|ne|net|nf|ng|ni|nl|no|np|nr|nt|nu|nz|om|org|pa|pe|pf|pg|ph|pk|pl|pm|pn|pr|pro|ps|pt|pw|py|qa|re|ro|ru|rw|sa|sb|sc|sd|se|sg|sh|si|sj|sk|sl|sm|sn|so|sr|st|su|sv|sy|sz|tc|td|tf|tg|th|tj|tk|tm|tn|to|tp|tr|tt|tv|tw|tz|ua|ug|uk|um|us|uy|uz|va|vc|ve|vg|vi|vn|vu|wf|ws|ye|yt|yu|za|zm|zw)$|(([0-9][0-9]?|[0-1][0-9][0-9]|[2][0-4][0-9]|[2][5][0-5])\.){3}([0-9][0-9]?|[0-1][0-9][0-9]|[2][0-4][0-9]|[2][5][0-5]))$/i",$from_email));
		}


		function isEmail2($to_email) { // Email address verification, do not edit.
		return(preg_match("/^[-_.[:alnum:]]+@((([[:alnum:]]|[[:alnum:]][[:alnum:]-]*[[:alnum:]])\.)+(ad|ae|aero|af|ag|ai|al|am|an|ao|aq|ar|arpa|as|at|au|aw|az|ba|bb|bd|be|bf|bg|bh|bi|biz|bj|bm|bn|bo|br|bs|bt|bv|bw|by|bz|ca|cc|cd|cf|cg|ch|ci|ck|cl|cm|cn|co|com|coop|cr|cs|cu|cv|cx|cy|cz|de|dj|dk|dm|do|dz|ec|edu|ee|eg|eh|er|es|et|eu|fi|fj|fk|fm|fo|fr|ga|gb|gd|ge|gf|gh|gi|gl|gm|gn|gov|gp|gq|gr|gs|gt|gu|gw|gy|hk|hm|hn|hr|ht|hu|id|ie|il|in|info|int|io|iq|ir|is|it|jm|jo|jp|ke|kg|kh|ki|km|kn|kp|kr|kw|ky|kz|la|lb|lc|li|lk|lr|ls|lt|lu|lv|ly|ma|mc|md|mg|mh|mil|mk|ml|mm|mn|mo|mp|mq|mr|ms|mt|mu|museum|mv|mw|mx|my|mz|na|name|nc|ne|net|nf|ng|ni|nl|no|np|nr|nt|nu|nz|om|org|pa|pe|pf|pg|ph|pk|pl|pm|pn|pr|pro|ps|pt|pw|py|qa|re|ro|ru|rw|sa|sb|sc|sd|se|sg|sh|si|sj|sk|sl|sm|sn|so|sr|st|su|sv|sy|sz|tc|td|tf|tg|th|tj|tk|tm|tn|to|tp|tr|tt|tv|tw|tz|ua|ug|uk|um|us|uy|uz|va|vc|ve|vg|vi|vn|vu|wf|ws|ye|yt|yu|za|zm|zw)$|(([0-9][0-9]?|[0-1][0-9][0-9]|[2][0-4][0-9]|[2][5][0-5])\.){3}([0-9][0-9]?|[0-1][0-9][0-9]|[2][0-4][0-9]|[2][5][0-5]))$/i",$to_email));
		}



?>
     
     </div>
     
</body>
</html>