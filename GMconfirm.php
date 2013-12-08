<?php
/**
* GMconfirm.php
*
*
* @category Coupon Promotion
* @package  confirm
* @author   Gary Johnson <gary_johnson_53@hotmail.com>
* @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
* @link     http://garyjohnsoninfo.info
*/

/*
frequently returns parse error if php error
utf-8

*/


require_once 'coupon_db_config_inc.php';
require_once 'coupon_popupsetting_inc.php';
require_once 'required_files/gj_csrf.inc.php';
require_once 'required_files/gj_utility.inc.php';


/*   controller */

$opt = urldecode($_GET['f']);
$email = urldecode($_GET['b']);
$ip=$_SERVER['REMOTE_ADDR'];
$to       = 'XXXXX';
$subject  = 'Message from garyjohnsonininfo';


//gjerror_log("opt in for ->".$opt.",".$email.",".$ip);

$mysqli = mysqli_connect($server, $username, $password, $database);
if (mysqli_connect_errno($mysqli)) {
    gjerror_log("Connect Error: " .$server. " username: " . $username." db: ".$database. " mysqli error: " .mysqli_connect_error());
    exit(1);
}

//if (!$mysqli->query("CALL gjGMCEM('$first','$last','$email','$phpgjCSRFName',CURDATE())")) {
if (!$mysqli->query("UPDATE gjEmail SET OptIn='1' WHERE (email='$email' AND OptIn='$opt') ")) {
    //echo "CALL failed: (" . $mysqli->errno . ") " . $mysqli->error."<br>";
    // duplicate keys ? connection reset etc log it and exit
    gjerror_log("Update failed Error: (". $mysqli->errno . ") " . $mysqli->error);
    gjerror_log("opt in fail->".$opt.",".$email.",".$ip);
    echo ' you are not confirmed for Coupon Promotion.com, please email XXXXX to be get your report';
} else {
    //log the record updated here
    gjerror_log("opt in ->".$opt.",".$email);
    echo $email.' is confirmed for Coupon Promotion.com';
}

$mysqli->close();

?>
