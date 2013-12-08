<?php
/**
* a tester to display email templates
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





// send email request to confirm
$gjname = urlencode('phpgjCSRFName');
$gjemail = urlencode('email');

$data = array('f'=>$gjname,
              'b'=>$gjemail);

$to       = 'to';
$from     = 'emailFrom';
$reply    = 'emailReply';
$subject  = 'emailSubjec';
$msg      = 'emailMsg';

$popupHeading='Gary Sent you a coupon for 1,000 hours of free programming ';
$delayBeforeExit=3;
$couponCode='free as in beer';

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

echo $msg1;

gjerror_log($msg1);
?>


