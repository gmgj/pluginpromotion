<?php

/**
* printgjEmail.php
*
*
* @category Dump the database
* @package  Coupon Package
* @author   Gary Johnson <gary_johnson_53@hotmail.com>
* @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
* @link     http://garyjohnsoninfo.info
*/

/*

*/

require_once 'coupon_db_config_inc.php';
require_once 'required_files/gj_utility.inc.php';

echo "<br><pre>\n";

$mysqli = mysqli_connect($server, $username, $password, $database);
if (mysqli_connect_errno($mysqli))
{
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
    exit(1);
}

echo "Host Info: ".$mysqli->host_info . "\n<br>";
//echo "server: " .$server. " username: " . $username. "\n<br>";

   $q = "SELECT *FROM gjEmail";
    $r = mysqli_query($mysqli, $q);

    if (!$r) {
       echo "<em>Nothing to show </em><br>\n";
    } else {
        echo "<em>Showing gjEmail</em><br>\n";
        while ($row = mysqli_fetch_row($r)) {
            printf ("%5d %20s %22s %30s %21s %s <br>", $row[0], $row[1],$row[2],$row[3],$row[4],$row[5]);
        }
        mysqli_free_result($r);
    }

echo "<br></pre>\n";

$mysqli->close();
exit(0);
?>