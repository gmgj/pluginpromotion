<!DOCTYPE HTML>
<html>
<head>
<title>PHP and Server Info</title>
<meta charset="utf-8">
</head>
<body>
<?php
/**
* PHPandServerInfo.php
*
*
* @category Testing
* @package  Test
* @author   Gary Johnson <gary_johnson_53@hotmail.com>
* @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
* @link     http://garyjohnsoninfo.info
*/

//Override debugging level for this report
global $gjDebug;
require_once 'required_files/gj_utility.inc.php';


error_reporting(E_ALL);
ini_set('display_errors',1);

ini_set('error_log', 'errors.log');

echo "<HR>";
$msg1=" test write to error_log: ".ini_get('error_log');
echo $msg1." <BR>";
if (error_log($msg1,0)) {
    echo "wrote to error_log <br>";
} else {
    echo "could not write to error_log<br>";
}

echo "<HR>";
echo "<pre>";
print(date("l F d, Y"));

// Get the client's IP address:
echo " PHP and Server Info <br>";


$CurrentVer = phpversion();
echo "You need to be at a minimum of PHP 5.2.6 to run our software<BR>";

switch (version_compare($CurrentVer, '5.2.6')) {
    case -1:
            print "Not OK You are running an older version of PHP: $CurrentVer<BR>";
    break;
    case 0:
            print "OK You are running PHP 5.2.6<BR>";
    break;
    case 1:
            print "OK You are running a version of PHP after 5.2.6: $CurrentVer<BR>";
}


$ip=$_SERVER['REMOTE_ADDR'];
echo "<br>".$ip." Your IP address<br>";
echo "you interent provider ip is ".gethostbyaddr($ip)."<br>";

/*
no header with ..  doctype html head ...
header('Content-Type: text/html; charset=UTF-8');
Warning: Cannot modify header information - headers already sent by (output started at /home/garyjohn/public_html/servertest.php:9) in /home/garyjohn/public_html/servertest.php on line 10
*/
echo "<br>Server Environment <br>";

echo "mb_internal_encoding() ". mb_internal_encoding()."<br><br>";


//http://www.hostip.info/
//Host name: http://garyjohnsoninfo.info
/*
http://stackoverflow.com/questions/6474783/which-server-variables-are-safe
*/

echo "    DOCUMENT_ROOT                            ". $_SERVER["DOCUMENT_ROOT"]."<br>";
echo "    SERVER_ADDR                              ". $_SERVER['SERVER_ADDR']."<br>";
echo "    SERVER_NAME                              ". $_SERVER['SERVER_NAME']."<br>";
echo "    Server_Software                          ". $_SERVER['SERVER_SOFTWARE']."<br>";
echo "    HTTP_HOST                                ". $_SERVER['HTTP_HOST']."<br>";
echo "    time this reguest started                ". date("Y-m-d H:i:s",$_SERVER['REQUEST_TIME'])."<br>";
echo "    OS this server is running                ". php_uname()."<br>";
echo "    phpversion()                             ". phpversion ( )."<br>";
echo '    get_cfg_var(\'cfg_file_path\')             '. get_cfg_var('cfg_file_path')."<br>";
echo '    get_include_path                         '. get_include_path()."<br>";
echo '    Accept: header                           '.$_SERVER['HTTP_ACCEPT']."<br>";
echo '    php error_log path                       '.ini_get('error_log').'<br>';
echo '    directory where this file is             '.dirname(__FILE__).'<br>';
echo '    absolute gjwhere path                    '.dirname(__FILE__).'/GMsignup.php<br>';
echo '    url of page                              '.curPageURL().'<br>';

$tmp = str_replace('PHPandServerInfo.php','',curPageURL());
//$tmp.= 'GMsignup.php<br>';
$tmp.= 'GMsignup.php';

echo '<b>    url of gjwhere                           </b>'.$tmp;
echo "</pre>";

//print_r(ini_get_all());
//Debug::dump((ini_get_all()), 'ini_get_all My ISP has disabled phpinfo() for security reasons');
echo "<pre>";


echo "</pre>";

echo "<HR>";
echo "<pre>";


echo "mcrypt_list_algorithms <br>";

$algorithms= mcrypt_list_algorithms();

// Items to display per row:
$items = 5;
$numalgo = count($algorithms); //sizeof — Alias of count()
if ($numalgo > 0) {
    echo '<table class="ft">';
     $i = 0;

    for ($j=0; $j<$numalgo; $j++) {
        if ($i == 0) {
            echo '<tr>';
        }
        echo "<td>$algorithms[$j]</td>";
        $i++;
        if ($i == $items) {
            echo '</tr>';
            $i = 0; // Reset counter.
        }
    } // End of for loop.

    if ($j > 0) { // Last row was incomplete.

        // Print the necessary number of cells:
        for (; $j < $items; $j++) {
            echo "<td>&nbsp;</td>\n";
        }
        // Complete the row.
        echo '</tr>';

    } // End of ($i > 0) IF.

    // Close the table:
    echo '</table>';
}
echo "</pre>";


echo "<HR>";

$modes = mcrypt_list_modes();

function print_r_xml($mixed)
{
    // capture the output of print_r
    $out = print_r($mixed, true);

    // Replace the root item with a struct
    // MATCH : '<start>element<newline> ('
    $root_pattern = '/[ \t]*([a-z0-9 \t_]+)\n[ \t]*\(/i';
    $root_replace_pattern = '<struct name="root" type="\\1">';
    $out = preg_replace($root_pattern, $root_replace_pattern, $out, 1);

    // Replace array and object items structs
    // MATCH : '[element] => <newline> ('
    $struct_pattern = '/[ \t]*\[([^\]]+)\][ \t]*\=\>[ \t]*([a-z0-9 \t_]+)\n[ \t]*\(/miU';
    $struct_replace_pattern = '<struct name="\\1" type="\\2">';
    $out = preg_replace($struct_pattern, $struct_replace_pattern, $out);
    // replace ')' on its own on a new line (surrounded by whitespace is ok) with '</var>
    $out = preg_replace('/^\s*\)\s*$/m', '</struct>', $out);

    // Replace simple key=>values with vars
    // MATCH : '[element] => value<newline>'
    $var_pattern = '/[ \t]*\[([^\]]+)\][ \t]*\=\>[ \t]*([a-z0-9 \t_\S]+)/i';
    $var_replace_pattern = '<var name="\\1">\\2</var>';
    $out = preg_replace($var_pattern, $var_replace_pattern, $out);

    $out =  trim($out);
    $out='<?xml version="1.0"?><data>'.$out.'</data>';

    return $out;
}

echo "mcrypt_list_modes <br>";
echo print_r_xml($modes);
echo '<pre>';


if (ini_get('date.timezone')) {
    echo 'date.timezone is set: ' . ini_get('date.timezone')."<br>";
}


if (! ini_set('display_errors', '1')) {
    echo "could not set display_errors to 1<br>";
}


$tmperr3 = ini_get('display_startup_errors');
echo 'display_startup_errors is : '.$tmperr3. '<br>';

echo "</pre>";

?>

</body>
</html>

