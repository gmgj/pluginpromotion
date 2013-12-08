<?php
/**
* GMsignup.php
*
*
* @category
* @package  ajax
* @author   Gary Johnson <gary_johnson_53@hotmail.com>
* @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
* @link     http://garyjohnsoninfo.info
*/
if(!isset($_SESSION)){
 session_start();
}

require_once '../coupon_db_config_inc.php';
require_once '../coupon_popupsetting_inc.php';
require_once 'gj_csrf.inc.php';
require_once 'gj_utility.inc.php';


/*   controller */

$phpgjCSRFName = ((isset($_POST['CSRFName'])) ? htmlentities($_POST['CSRFName']) : "");
$phpgjCSRFToken = ((isset($_POST['CSRFToken'])) ? htmlentities($_POST['CSRFToken']) : "");

// csrfguard_validate_token calls unset_session for the key
if (!csrfguard_validate_token($phpgjCSRFName, $phpgjCSRFToken)) {
	trigger_error("Invalid CSRF token.",E_USER_ERROR);
	//trigger_error("Invalid CSRF token : ".$phpgjCSRFName." : " .$phpgjCSRFToken,E_USER_ERROR);
    exit("<b> -> GoodBye </b>\n");
}

$ip=$_SERVER['REMOTE_ADDR'];


if(isset($_SESSION['Sviews'])) {
    $_SESSION['Sviews'] = $_SESSION['Sviews']+ 1;
} else {
    $_SESSION['Sviews'] = 1;
    $_SESSION['Sip'   ] = $ip;
}

$gjErr = false;
$msg1 = "";

if (!(isset($_POST) && array_key_exists("email",$_POST))) {
    gjerror_log( "No Post data");
    $gjErr = true;
    $msg1 = "No Post Data<br>";
}

if(!empty($_POST['first'])) {
    if (strlen($_POST['first']) > 30) {
        $gjErr = true;
        $msg1 .= "Please enter a valid value for First Name<br>";
    } else {
        $first = htmlentities($_POST['first']);
        if (!checktext( $first)) {
            $gjErr = true;
            $msg1 .= $first." Is not a valid value for First<br>";
        }
    }
} else {
$first='';
}

if(!empty($_POST['phone'])) {
    if (strlen($_POST['phone']) > 30) {
        $gjErr = true;
        $msg1 .= "Please enter a valid value for Phone<br>";
    } else {
        $phone = htmlentities($_POST['phone']);
        if (!checktel( $phone)) {
            $gjErr = true;
            $msg1 .= $phone." Is not a valid value for Phone<br>";
        }
    }
} else {
$phone='';
}

if (empty($_POST['email'])) {
$email='';
} else if (strlen($_POST['email']) > 50) {
    $email = htmlentities($_POST['email']);
    $gjErr = true;
    $msg1 .= "Please enter a valid value for email<br>";
} else {
    $email = htmlentities($_POST['email']);
    if (!checkemail( $email)) {
        $gjErr = true;
        $msg1 .= $email." Is not a valid value for email<br>";
    }
}

if ($email == "YourEmail@Address.com") {
        $gjErr = true;
        $msg1 .= $email." Is not a valid email<br>";
}


//if (true) {
if ($gjErr || $msg1 != "") {
    gjerror_log("Errors: " .$msg1);
    $_SESSION['Sip'   ] = $ip;
    $_SESSION['Semail'] = $email;
    session_write_close();
    $result = array("status" => 0,"message" => $msg1);
    echo json_encode($result);
    exit(1);
} //else {
//  gjerror_log("No Errors trying SQL");
//}

$host = substr($_SERVER['SERVER_NAME'], 0, 5);
if (in_array($host, array('local', '127.0', '192.1'))) {
    $gjLocal = true;
} else {
    $gjLocal = false;
}

$result = array("status" => true,"message" => "yes");

//cause a php msql error by changing variable and forcing connect failure
//$mysqli = mysqli_connect($gjLocal, $username, $password, $database);

$mysqli = mysqli_connect($server, $username, $password, $database);
if (mysqli_connect_errno($mysqli)) {
    gjerror_log("Connect Error: " .$server. " username: " . $username." db: ".$database. " mysqli error: " .mysqli_connect_error());
        $result = array("status" => "false","message" => "DB dead!");
    echo json_encode($result);
    exit(1);
}

if (!$mysqli->query("CALL gjGMCEM('$first','$phone','$email','$phpgjCSRFName',CURDATE())")) {
    //echo "CALL failed: (" . $mysqli->errno . ") " . $mysqli->error."<br>";
    // duplicate keys ? connection reset etc log it and exit
    gjerror_log("Insert failed Error: (". $mysqli->errno . ") " . $mysqli->error);
    gjerror_log("fail->".$first.",".$phone.",".$email);
    if($mysqli->errno == 1062) {
        $result = array("status" => "false","message" => "Duplicate entry in Database");
    } else {
        $result = array("status" => "false","message" => "Sorry, there has been an error");
    }
} else {
    //we don't keep good attempts in the session log
    session_destroy();
    gjerror_log("added to gjEmail ->".$first.",".$phone.",".$email);
}

$mysqli->close();

header('Content-type: application/json');
echo json_encode($result);
//gjerror_log(json_encode($result),0);
session_write_close();

if($result['status'] == true) {
//mailMe($gjLocal,$to , "subject", "You got a reguest for a coupon from ".$email);

// send email request to confirm
$gjname = urlencode($phpgjCSRFName);
$gjemail = urlencode($email);

$data = array('f'=>$gjname,
              'b'=>$gjemail);


$to       = $email;
$from     = $emailFrom;
$reply    = $emailReply;
$subject  = $emailSubject;
$msg      = $emailMsg;

$first;
$popupHeading;
$delayBeforeExit;
$couponCode;

/*
		// including email template
		include('email_template.php');

		// changing variables for the email
		$email_message = str_replace('{|client_name|}', $data['first_name'], $email_message);
		$email_message = str_replace('{|couponcode|}', $email['voucher_code'], $email_message);


*/



$tmp = str_replace('GMsignup.php','GMconfirm.php',$gjwhere);

$gjhref = $tmp.'?'.http_build_query($data);

$msg1 = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">'."\r\n" ;
$msg1.= '<html xmlns="http://www.w3.org/1999/xhtml">'."\r\n";
$msg1.= '<head>'."\r\n";
$msg1.= '<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />'."\r\n";
$msg1.= '<title>Confirm Coupon Promotion</title>'."\r\n";
$msg1.= '<style type="text/css">'."\r\n";
$msg1.= 'table {border-collapse:separate;}'."\r\n";
$msg1.= 'a, a:link, a:visited {text-decoration: none; color: #00788a}' ."\r\n";
$msg1.= 'a:hover {text-decoration: underline;}'."\r\n";
$msg1.= 'h2,h2 a,h2 a:visited,h3,h3 a,h3 a:visited,h4,h5,h6,.t_cht {color:#000 !important}'."\r\n";
$msg1.= 'p {margin-bottom: 0}'."\r\n";
$msg1.= '.ExternalClass p, .ExternalClass span, .ExternalClass font, .ExternalClass td {line-height: 100%}'."\r\n";
$msg1.= '.ExternalClass {width: 100%;}'."\r\n";
$msg1.= '</style> '."\r\n";
$msg1.= '</head>'."\r\n";
$msg1.= '<body>'."\r\n";
$msg1.= '<table border="0" style="font-size:100% !important;margin:0 auto;" cellpadding="10">'."\r\n";
$msg1.= '<tr><td><p style="color:blue;font-family:'. "'Lucida Calligraphy'".',Vivaldi,cursive;font-weight:bold;font-size:32px;text-align:center;text-shadow:1px 1px 1px black;">'."\r\n";
// the heading
$msg1.=$popupHeading."\r\n";
$msg1.= '</p></td></tr>'."\r\n";

// start text block 1
$msg1.= '<tr style="background: #eee;"><td><strong>';
//change below
$msg1.='Here is your free coupon<br>';
//end change below
$msg1.= '</strong></td></tr>'."\r\n";
// end text block 1


// start text block 2
$msg1.= '<tr style=""><td style="vertical-align:center;">';
$msg1.= '<p><span style="background: #000;color:#fff; display:block;margin:6px 0;width:10em;text-align:center;">';
//change below
$msg1.= $couponCode;
//end change below
$msg1.= '</span></p>'."\r\n";
$msg1.= '</td></tr>'."\r\n";
// end text block 2

// start text block 3
$msg1.= '<tr style="background: #eee;"><td><strong>';
//change below
$msg1.='Enter the coupon code at the checkout<br>';
$msg1.='Thank you for shopping with us<br>';
//end change below
$msg1.= '</strong></td></tr>'."\r\n";
// end text block 3




//start optin
$msg1.= '<tr style="background: #eee;"><td>';

//start optin message
$msg1.= 'If you would like to be added to our mailing list, please ';
$msg1.= 'click on the following link (or if it does not show as a link, cut and paste the line in your browser)';
//end optin message

$msg1.= '</strong></td></tr>'."\r\n";
$msg1.= '<tr><td><a href="'.$gjhref.'" target="_blank">'.$gjhref.'</a></td></tr>'."\r\n";
//end optin


// $msg1.= '<tr><td><strong></strong> </td><td></td></tr>';
$msg1 .= '</table>'."\r\n";
//$msg1 .= '<img src="http://Garyjohnsoninfo.info/images/Handshake.png" alt="image of handshake" />';
$msg1 .= '</body>'."\r\n".'</html>';

//echo $msg1;


mailMeHTML($gjLocal,$from, $reply, $to, $subject, $msg1);
}
?>


 