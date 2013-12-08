<?php

/**
*
* @category assign the popupsetting table values to variables
* @package  Coupon Package
* @author   Gary Johnson <gary_johnson_53@hotmail.com>
* @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
* @link     http://garyjohnsoninfo.info
*/

require_once 'coupon_db_config_inc.php';
require_once 'required_files/gj_utility.inc.php';

$mysqli = mysqli_connect($server, $username, $password, $database);
if (mysqli_connect_errno($mysqli)) {
    gjerror_log("Failed to connect to MySQL: " . mysqli_connect_error());
    exit(1);
}


$q = "SELECT * FROM popupsetting";
$r = mysqli_query($mysqli, $q);

if(function_exists('mysqli_fetch_all')) {
    $rowarray = mysqli_fetch_all($r);
} else {
    $rowarray = array();
    while ($row = mysqli_fetch_row($r)) {
        $rowarray[] = $row;
    }
}

$values = array(
'showPopup',
'popupHeading',
'delayBeforeExit',
'emailFrom',
'emailReply',
'emailSubject',
'emailMsg',
'couponCode',
'daysToWaitBeforeNextPopup');

$i = 0;
foreach($rowarray as $row) {
    //printf (" %40s %40s <br>\n", $row[2], $values[$i++]);
    if($i > 8) {break;}  ////the core required 9 variables
    if ($row[2] !== $values[$i]) {
     gjerror_log( "bad key (type) in popupsetting, please reload and reset the table");
     gjerror_log('expecting '. $row[2] .' got '. $values[$i]);
     exit(1);
    }
 $i++;
}

$showPopup          = $rowarray[0][1];
$popupHeading       = $rowarray[1][1];
$delayBeforeExit    = $rowarray[2][1];
$emailFrom          = $rowarray[3][1];
$emailReply         = $rowarray[4][1];
$emailSubject       = $rowarray[5][1];
$emailMsg           = $rowarray[6][1];
$couponCode         = $rowarray[7][1];
$daysToWaitBeforeNextPopup = $rowarray[8][1];

//echo 'showPopup is : '. $showPopup;
//echo 'daysToWaitBeforeNextPopup is '. $daysToWaitBeforeNextPopup;

mysqli_free_result($r);
$mysqli->close();
