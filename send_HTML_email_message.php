<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>send html email</title>
<style>
input { -webkit-border-radius: 5px; -moz-border-radius: 5px; border-radius: 5px; }
select { -webkit-border-radius: 5px; -moz-border-radius: 5px; border-radius: 5px; }

textarea.buttonNgrey, select.buttonNgrey, input.buttonNgrey {
font-weight:bold;
font-size:16px;
font-family: "Segoe UI","Helvetica Neue", Verdana ,Helvetica , sans-serif;
color: #000;
border: 2px solid #000;
background-color: #D5D5D4;}

textarea.buttonNgrey:hover, select.buttonNgrey:hover, input.buttonNgrey:hover {
background-color: #B0C4DE;}
</style>
</head>
<body>
<p style='text-align:center; color:blue;'><span style='background-color:gainsboro;padding:0 10px;'>Send an HTML Email with your template</span></p>

<form style="margin-left:7px;" name="sfm" id="sfm" action="" method="post">

<label class="buttonNgrey" for="email">To Email</label><br>
<input class="buttonNgrey" type="email" required name="email" id="email" maxlength="50" style='width:50em'><br><br>

<input type="hidden" name="gjwhichAction" value="gmail">
<input class="buttonNgrey" type="Submit" id="submit1" value="Submit" style='width:5em'>
</form>

<?php
/**
* sendhtmlmail.php send an email whith a subjext and address from
*
*
* @category utility
* @package  send email
* @author   Gary Johnson <gary_johnson_53@hotmail.com>
* @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
* @link     http://garyjohnsoninfo.info
*/


if(!isset($_SESSION)){
 session_start();
}

require_once 'coupon_db_config_inc.php';
require_once 'coupon_popupsetting_inc.php';
//require_once 'required_files/gj_csrf.inc.php';
require_once 'required_files/gj_utility.inc.php';


/*   controller */
global $gjDebug, $gjLocal;

$ip=$_SERVER['REMOTE_ADDR'];

if (!(isset($_POST) && array_key_exists("email",$_POST))) {
    gjerror_log( "First Pass");
    //do nothing
} else {

$gjErr = false;
$msg1 = "";


if (empty($_POST['email'])) {
$gjTo='';
} else if (strlen($_POST['email']) > 50) {
    $gjTo = htmlentities($_POST['email']);
    $gjErr = true;
    $msg1 .= "Please enter a valid value for email<br>";
} else {
    $gjTo = htmlentities($_POST['email']);
    if (!checkemail($gjTo)) {
        $gjErr = true;
        $msg1 .= $gjTo." Is not a valid value for email<br>";
    }
}

if ($gjErr || $msg1 != "") {
    gjerror_log('Error in sendhtmlemail : '.$msg1.' : '.$gjTo);
	exit(1);
}


// start build  the optin return email address

$tmp = str_replace('GMsignup.php','GMconfirm.php',$gjwhere);  //CMconfirm is the routine that is called when the link to optin is executed


$gjname = urlencode("TestCode");
$gjemail = urlencode($gjTo);

$data = array('f'=>$gjname,
              'b'=>$gjemail);

$gjhref = $tmp.'?'.http_build_query($data);

// end build  the optin return email address

// assign the popupsetting and other variables for the adress

$to       = $gjTo;
$from     = $emailFrom;
$reply    = $emailReply;

// subject and optional msg
$subject  = $emailSubject;
$msg      = $emailMsg;

// including the email email_template that you have selected
// include('email_template.php');
include('GaryStyledEmailTemplate.php');

// changing variables for the email
$first = 'First Name';
/*
$delayBeforeExit;
*/

$email_block = str_replace('{|popupHeading|}'   , $popupHeading , $email_block);
$email_block = str_replace('{|first_name|}'     , $first , $email_block);
$email_block = str_replace('{|couponcode|}'     , $couponCode , $email_block);
$email_block = str_replace('{|optIn|}'          , $gjhref , $email_block);

if($msg =='') {
$email_block = str_replace('<!-- st optional --><tr style="background: #eee;"><td>{|optionalMessage|}</td></tr><!-- end optional -->','' , $email_block);
} else {
$email_block = str_replace('{|optionalMessage|}', $msg, $email_block);
}

if (!strlen($gjTo)) {
gjerror_log('no gjTo ',0);
} else {
    gjerror_log('mailMeHTML in sendhtmlemail ',0);

    if(mailMeHTML($gjLocal,$from, $reply, $to, $subject, $msg1)) {
	    echo "Mail Sent to  " .$gjTo;
    } else {
        echo "Mail Failed  " .$gjTo. " if debugging, check the log for errors ";
    }
}

}  // end first pass

?>

</body>
</html>