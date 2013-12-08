<?php
/**
* gj_utiltiy.inc.php
*
*
* @category Testing
* @package  utility
* @author   Gary Johnson <gary_johnson_53@hotmail.com>
* @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
* @link     http://garyjohnsoninfo.info
*/

function gjerror_log($strin)
{
global $gjDebug;

    if (isset($gjDebug) && $gjDebug) {
        error_log($strin);
    }
}

function js_redirect($url, $millseconds=5)
{
    echo "<script language=\"JavaScript\">\n";
    echo "function redirect() {\n";
    echo "window.location = \"" . $url . "\";\n";
    echo "}\n";
    echo "timer = setTimeout('redirect()', '" . ($millseconds) . "');\n";
    echo "</script>\n";
return true;
}

function display_file_as_text ($filein)
{
$file = fopen ($filein, "rb");
$lines = fread ($file, filesize ($filein));
fclose ($file);
echo '<pre>';
echo $lines;
echo '/<pre>';
}


function mailMe($from, $to, $subject, $msg)
{

	//to for multiple addresses is gj@mail.com,gj2@mail.com
	//see http://php.net/manual/en/function.mail.php

    $headers  = 'From: '.$from. "\r\n" ;
    $headers  .='Reply-To: noreply@noreply.info' . "\r\n" ;
    $headers  .='X-Mailer: PHP/' . phpversion();

    $msg = wordwrap($msg, 70, "\r\n");

    if (mail($to, $subject, $msg, $headers)) {
        echo "Mail Sent to  " .$to. " Message " .$msg ;
        gjerror_log ( "Mail Sent  " .$to );
    } else {
        echo "Mail Failed  " .$to. " Message " .$msg ;
        gjerror_log ( "Mail Failed  " .$to. " message " .$msg );
    }
}




function mailMeHTML($ok, $from, $replyto, $to, $subject, $msg)
{
    if($ok) {
        gjerror_log ( "No Mail on local  message " .$msg );
    return;
    }

    //$subject  = 'Message from garyjohnsonininfo';
    $headers  = 'From: '.$from . "\r\n";
    $headers .= 'Reply-To: '.$replyto  . "\r\n" ;
    $headers .= 'X-Mailer: PHP/' . phpversion(). "\r\n";
    $headers .= 'MIME-Version: 1.0'."\r\n";
    $headers .= 'Content-Type: text/html; charset=utf-8'. "\r\n";
    if (mail($to, $subject, $msg, $headers)) {
        gjerror_log ( "HTML Mail Sent  " .$to  );
		return true;
    } else {
        gjerror_log ( "HTML Mail Failed  " .$to. " message " .$msg );
		return false;
    }
}



function checktext($strin)
{
    //'      -          .       0-  9        A-  Z      `        a-   z   sp     ?  ?       ?  ?      ?
    // [\x27\x2D\x2E\x30-\x39\x41-\x5a\x60\x61-\x7a\s\xC0-\xD6\xD8-\xF6\xF8-\xFF]+;

    $gjret =preg_match('/[\x27\x2D\x2E\x30-\x39\x41-\x5a\x60\x61-\x7a\s\xC0-\xD6\xD8-\xF6\xF8-\xFF]+/', $strin,$strmatched);
    if (count($strmatched)) {
        $gjtmp = strlen($strmatched[0]);
        $ok = ($gjtmp === strlen($strin) ? true : false);
    } else {
        $ok = false;
    }

    if ($ok) {
        $gjret2 =preg_match_all('/\x27/', $strin,$strmatched);
        if ($gjret2 && isset($strmatched[0][1])) {
            //echo "More than one single quote  ".$strin. "<br />";
            return false; // More than one single quote
        } else {
            //echo "we are good  ".$strin. "<br />";
            return true; // yippe
        }
    } else {
        //echo "not matched  ".$strin. "<br />";
        return false; //not my extended alpaha
    }
}


function checkemail($strin)
{
    if (!(preg_match('/^[\w\-\.\+]+\@[a-zA-Z0-9\.\-]+\.[a-zA-z0-9]{2,4}$/', $strin))) {
        return false;
    }
    return true;
}


function checktel($strin) {
  if(!checktext($strin)) {
    return false;
  }

  if (!(preg_match('/^\d{3}[-]\d{3}[-]\d{4}(.*)?$/', $strin))) {
    //echo $tel." Is not a valid value for phone<br>";
    return false;
  }  else {
    //echo "good tel  ".$tel. "<br />";
    return true;
  }
}

function curPageURL() {
 $pageURL = 'http';
 if(isset($_SERVER["HTTPS"])) {
 	if($_SERVER["HTTPS"] == "on") {$pageURL .= "s";}
 }
 $pageURL .= "://";
 if ($_SERVER["SERVER_PORT"] != "80") {
  $pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
 } else {
  $pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
 }
 return $pageURL;
}

function curPageName() {
 return substr($_SERVER["SCRIPT_NAME"],strrpos($_SERVER["SCRIPT_NAME"],"/")+1);
}
