<?php

require_once 'coupon_db_config_inc.php';

echo "<br><pre>\n";

$gjok = true;

function showTables($tmysqli, $dbNm, $tableNm) {
    $q = "SHOW COLUMNS FROM ".$tableNm;
    $r = mysqli_query($tmysqli, $q);

    if (!$r) {
       echo "<em>Nothing to show </em><br>\n";
    } else {
        echo "<em>Showing List of Fields for table: ".$tableNm."</em><br>\n";
        while ($row = mysqli_fetch_row($r)) {
            printf ("%20s (%s)\n", $row[0], $row[1]);
        }
        mysqli_free_result($r);
    }
}

function showStoredProcs($tmysqli) {
    $q = "show create procedure gjGMCEM";
    $r = mysqli_query($tmysqli, $q);

    if ($r && mysqli_num_rows($r) === 0) {
        echo "<em>Nothing to show </em>\n";
    } else {
        echo "<em>Syntax used to create stored proceudre</em><br>\n";
        $proc = mysqli_fetch_array($r, MYSQLI_BOTH);
        print_r($proc['Create Procedure']);
    }
}

$mysqli = mysqli_connect($server, $username, $password, $database);
if (mysqli_connect_errno($mysqli))
{
    echo "<br>Failed to connect to MySQL: " . mysqli_connect_error();
	$gjok = false;
    echo "<br><b style='color:red' >You have errors<b><br>";
    exit(1);
}


echo "Host Info: ".$mysqli->host_info . "\n<br>";
//echo "server: " .$server. " username: " . $username. "\n<br>";

//create the customer email table

if (!$mysqli->query("CREATE TABLE IF NOT EXISTS `gjEmail` (
user_id SMALLINT(5) UNSIGNED NOT NULL AUTO_INCREMENT,
`First` varchar(20) DEFAULT '',
`Phone` varchar(22) DEFAULT '',
`Email` varchar(30) NOT NULL DEFAULT '',
`OptIn` varchar(21) NOT NULL DEFAULT '',
`date_added` date NOT NULL DEFAULT '2001-01-01',
PRIMARY KEY (`Email`),
KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;"))
{
    echo "<br>Create table failed: (" . $mysqli->errno . ") " . $mysqli->error;
	$gjok = false;
} else {
    echo "<br>Table created<br>";
    showTables($mysqli,$database,'gjEmail');
}


if (!$mysqli->query("CREATE TABLE IF NOT EXISTS `popupsetting` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `value` text NOT NULL,
  `type` varchar(45) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5;"))
{
    echo "<br>Create table failed: (" . $mysqli->errno . ") " . $mysqli->error;
	$gjok = false;
} else {
    echo "<br>Table created<br>";
    showTables($mysqli,$database,'popupsetting');
}

/*
 add default values into table `popupsetting`

showPopup                  showpopup    ON
popupHeading               popup

delayBeforeExit            delay       2000   in milisecons

emailFrom                  email              the email address used by phpemail
emailReply
emailSubject
emailMsg
couponCode

daysToWaitBeforeNextPopup  expire        3

*/

if (!$mysqli->query("INSERT INTO `popupsetting` (`id`, `value`, `type`) VALUES
(1, 'ON', 'showPopup'),
(2, 'Your Message Here', 'popupHeading'),
(3, '2000', 'delayBeforeExit'),
(4, 'sendingEmail@email.com', 'emailFrom'),
(5, 'replyToEmail@email.com', 'emailReply'),
(6, 'email subject', 'emailSubject'),
(7, 'email optional msg', 'emailMsg'),
(8, '12345678', 'couponCode'),
(9, '3', 'daysToWaitBeforeNextPopup');"))
{
	if($mysqli->errno == 1062) { //okay
		echo "<br>default values already in table popupsetting<br>";
	} else {
	    //  $result = array("status" => "false","message" => "Sorry, there has been an error");
	    echo "<br>Insert data into table table popupsetting failed: (" . $mysqli->errno . ") " . $mysqli->error;
		$gjok = false;
	}
} else {
echo "<br>added default values into table popupsetting<br>";
}


//begin check , delete and create stored procedure

if (!$mysqli->query("DROP PROCEDURE IF EXISTS gjGMCEM"))
{
    echo "<br>drop procedure failed: (" . $mysqli->errno . ") " . $mysqli->error;
}

if (!$mysqli->query("CREATE PROCEDURE gjGMCEM(IN strFirst varchar(20),strPhone varchar(30),email varchar(30),OptIn varchar(21),theudate date)
BEGIN
INSERT INTO gjEmail
(First,Phone,Email,OptIn,date_added)
VALUES
(strFirst,strPhone,email,OptIn,theudate);
END;"))
{
    echo "<br>Stored procedure creation failed: (" . $mysqli->errno . ") " . $mysqli->error;
	$gjok = false;
} else {
    echo "<br>Stored procedure created<br>";
}

showStoredProcs($mysqli);

if($gjok) {
    echo "<br><br><br><b style='color:black;font-size:24px;'>OK You are ready to go<b><br>";
} else {
    echo "<br><br><br><b style='color:red;font-size:24px;'>NOT OK You have errors<b><br>";
}



echo "<br></pre>\n";

$mysqli->close();
exit(0);


/**
* coupon_db_setup.php
*
*
* @category create table and stored procedure
* @package  Coupon Package
* @author   Gary Johnson <gary_johnson_53@hotmail.com>
* @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
* @link     http://garyjohnsoninfo.info
*/

/*
Note: if we did this automatically for you (see below), it would be a security hole

CREATE USER 'garyjohn_mcadams'@'localhost' IDENTIFIED BY '***';
GRANT USAGE ON * . * TO 'garyjohn_mcadams'@'localhost' IDENTIFIED BY '***' WITH MAX_QUERIES_PER_HOUR 0 MAX_CONNECTIONS_PER_HOUR 0 MAX_UPDATES_PER_HOUR 0 MAX_USER_CONNECTIONS 0 ;
CREATE DATABASE IF NOT EXISTS `garyjohn_mcadams` ;
GRANT ALL PRIVILEGES ON `garyjohn\_mcadams` . * TO 'garyjohn_mcadams'@'localhost';
*/

?>