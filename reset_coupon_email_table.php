<?php
/**
* zorchemails.php
*
*
* @category utility
* @package  delete gjEmail tablee
* @author   Gary Johnson <gary_johnson_53@hotmail.com>
* @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
* @link     http://garyjohnsoninfo.info
*/

/*
frequently returns parse error if php error
utf-8

*/

require_once 'coupon_db_config_inc.php';
require_once 'required_files/gj_utility.inc.php';



/*   controller */


$mysqli = mysqli_connect($server, $username, $password, $database);
if (mysqli_connect_errno($mysqli)) {
    mailMe($gjLocal, $to ,"Connect Error " . $server. " username: " .$username." db: ".$database. " mysqli error: " . mysqli_connect_error());
    gjerror_log("Connect Error: " .$server. " username: " . $username." db: ".$database. " mysqli error: " .mysqli_connect_error());
    exit(1);
}

if (!$mysqli->query("TRUNCATE gjEmail")) {
    gjerror_log("truncate failed Error: (". $mysqli->errno . ") " . $mysqli->error);
    echo 'fail';
} else {
    echo ' success';
}

$mysqli->close();

?>
