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

require_once 'coupon_db_config_inc.php';
require_once 'coupon_popupsetting_inc.php';
require_once 'required_files/gj_csrf.inc.php';
require_once 'required_files/gj_utility.inc.php';


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


// start build  the optin return email address

$tmp = str_replace('GMsignup.php','GMconfirm.php',$gjwhere);  //CMconfirm is the routine that is called when the link to optin is executed

$gjname = urlencode($phpgjCSRFName);
$gjemail = urlencode($email);

$data = array('f'=>$gjname,
              'b'=>$gjemail);

$gjhref = $tmp.'?'.http_build_query($data);

// end build  the optin return email address

// assign the popupsetting and other variables for the adress

$to       = $email;  //gjTo;?
$from     = $emailFrom;
$reply    = $emailReply;

// subject and optional msg
$subject  = $emailSubject;
$msg      = $emailMsg;


// including the email email_template that you have selected
// include('email_template.php');
include('GaryStyledEmailTemplate.php');

// changing variables for the email

$email_block = str_replace('{|popupHeading|}'   , $popupHeading , $email_block);
$email_block = str_replace('{|first_name|}'     , $first , $email_block);
$email_block = str_replace('{|couponcode|}'     , $couponCode , $email_block);
$email_block = str_replace('{|optIn|}'          , $gjhref , $email_block);

if($msg =='') {
$email_block = str_replace('<!-- st optional --><tr style="background: #eee;"><td>{|optionalMessage|}</td></tr><!-- end optional -->','' , $email_block);
} else {
$email_block = str_replace('{|optionalMessage|}', $msg, $email_block);
}


error_log( $email_block);


mailMeHTML($gjLocal,$from, $reply, $to, $subject, $msg1);
}
?>


