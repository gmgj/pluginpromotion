<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>send email message - Regular</title>
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

<form style="margin-left:7px;" name="sfm" id="sfm" action="" method="post">
<br>
<label class="buttonNgrey" for="from">From Email</label>
<br>
<input class="buttonNgrey" type="email" required name="from" id="from" maxlength="50" style='width:50em'>
<br>
<label class="buttonNgrey" for="email">To Email</label>
<br>
<input class="buttonNgrey" type="email" required name="email" id="email" maxlength="50" style='width:50em'>
<br>Subject<br>
<input class="buttonNgrey" type="text" name="gjSubj" id="gjSubj" value="" maxlength="50" style='width:50em'>
<br>Message<br>
<textarea class="buttonNgrey" name="msg3" id="msg3" cols="40" rows="5"  style="width:50em"></textarea>
<br>
<br>

<input type="hidden" name="gjwhichAction" value="gmail">
<input class="buttonNgrey" type="Submit" id="submit1" value="Submit" style='width:5em'>
</form>


<?php
/**
* sendmail.php send an email whith a subject and address from
*
*
* @category utility
* @package  send email
* @author   Gary Johnson <gary_johnson_53@hotmail.com>
* @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
* @link     http://garyjohnsoninfo.info

Warning: mail(): &quot;sendmail_from&quot; not set in php.ini or custom &quot;From:&quot; header missing in F:\bit5411\apps\mcadams\htdocs\send_email_message.php on line
*/




/*   controller */
global $gjDebug, $gjLocal;
require_once 'required_files/gj_utility.inc.php';



$ip=$_SERVER['REMOTE_ADDR'];


if (!(isset($_POST) && array_key_exists("email",$_POST))) {
    gjerror_log( "First Pass");
} else {

$gjErr = false;
$msg1 = "";

if(!empty($_POST['gjSubj'])) {
    if (strlen($_POST['gjSubj']) > 50) {
        $gjErr = true;
        $msg1 .= "Please enter a valid value for subject<br>";
    } else {
        $gjSubj = htmlentities($_POST['gjSubj']);
        if (!checktext( $gjSubj)) {
            $gjErr = true;
            $msg1 .= $gjSubj." Is not a valid value for subject<br>";
        }
    }
} else {
$gjSubj='';
}

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


if (empty($_POST['from'])) {
$gjFrom='';
} else if (strlen($_POST['from']) > 50) {
    $gjFrom = htmlentities($_POST['from']);
    $gjErr = true;
    $msg1 .= "Please enter a valid value for from email<br>";
} else {
    $gjFrom = htmlentities($_POST['from']);
    if (!checkemail($gjFrom)) {
        $gjErr = true;
        $msg1 .= $gjFrom." Is not a valid value for from email<br>";
    }
}


if(!empty($_POST['msg3'])) {
$msg3 = $_POST['msg3'];
} else {
$msg3='';
}

if ($gjErr || $msg1 != "") {
    gjerror_log('Error in sendemail : '.$msg1.' : '.$gjTo);
}


if (!strlen($gjTo)) {
gjerror_log('no gjTo ',0);
} else {
    gjerror_log('mailMe in send_email_message ',0);
    mailMe($gjFrom, $gjTo, $gjSubj, $msg3);
}

} // if post data
?>

</body>
</html>