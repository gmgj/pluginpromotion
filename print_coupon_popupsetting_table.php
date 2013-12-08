<?php

/**
*
*
* @category Dump the popupsetting table
* @package  Coupon Package
* @author   Gary Johnson <gary_johnson_53@hotmail.com>
* @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
* @link     http://garyjohnsoninfo.info
*/

require_once 'coupon_db_config_inc.php';
require_once 'required_files/gj_utility.inc.php';
require_once 'required_files/header.html';


echo "<br><pre>\n";
$mysqli = mysqli_connect($server, $username, $password, $database);
if (mysqli_connect_errno($mysqli))
{
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
    exit(1);
}

//echo "server: " .$server. " username: " . $username. "\n<br>";

$q = "SELECT * FROM popupsetting";
$r = mysqli_query($mysqli, $q);


if (!$r) {
   echo "<em>Nothing to show </em><br>\n";
} else {
    echo "<H1>Showing popupsetting</H1>\n";
//    echo "<b>";
//    printf ("%4s %39s %40s <br>\n", 'id' , 'Value', 'Key or Type');
//    echo "</b>";

    if(function_exists('mysqli_fetch_all')) {
        $rowarray = mysqli_fetch_all($r);
    } else {
        $rowarray = array();
        while ($row = mysqli_fetch_row($r)) {
            $rowarray[] = $row;
        }
    }

    echo '<table id="zip">';

    foreach($rowarray as $row) {
        //printf ("%4d %39s %40s <br>\n", $row[0], $row[1],$row[2]);
        echo "<tr><td>$row[0]</td><td>$row[1]</td><td>$row[2]</td></tr>";
    }

    // Close the table:
    echo '</table>';


}

//the core required 9 variables
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
    if($i > 8) {break;}
    //printf (" %40s %40s <br>\n", $row[2], $values[$i++]);
    if ($row[2] !== $values[$i]) {
     echo "bad key (type) in popupsetting, please reload and reset the table<br>";
     echo 'expecting '. $row[2] .' got '. $values[$i].'<br>';
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


echo "<br></pre>\n";
echo "Host Info: ".$mysqli->host_info . "\n<br>";

$mysqli->close();
exit(0);
?>