
<?php
/*
use double quotes "  for most entries
if you need to use a single quote, use \'
for
$                \$
linefeed         \n
backslash        \\
double quote     \"

*/


$email_block = '
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Confirm Coupon Promotion</title>
<style type="text/css">
table {border-collapse:separate;}
a, a:link, a:visited {text-decoration: none; color: #00788a}
a:hover {text-decoration: underline;}
h2,h2 a,h2 a:visited,h3,h3 a,h3 a:visited,h4,h5,h6,.t_cht {color:#000 !important}
p {margin-bottom: 0}
.ExternalClass p, .ExternalClass span, .ExternalClass font, .ExternalClass td {line-height: 100%}
.ExternalClass {width: 100%;}
</style>
</head>
<body>
<table border="0" style="font-size:100% !important;margin:0 auto;" cellpadding="10">
<!-- see the single quote prcedd by the slash -->
<tr><td><p style="color:blue;font-family:\'Lucida Calligraphy\',Vivaldi,cursive;font-weight:bold;font-size:32px;text-align:center;text-shadow:1px 1px 1px black;">
<!-- st heading -->
{|popupHeading|}
<br>
{|first_name|}
<!-- end heading -->
</p></td></tr>
<tr style="background: #eee;"><td><strong>
<!-- st intro -->
Here is your free coupon<br>
</strong></td></tr>
<!-- end intro  -->
<tr style=""><td style="vertical-align:center;"><p><span style="background: #000;color:#fff; display:block;margin:6px 0;width:10em;text-align:center;">
<!-- st coupon -->
{|couponcode|}
<!-- end coupon -->
</span></p>
</td></tr>
<tr style="background: #eee;"><td>
<!-- start instructions -->
<strong>Enter the coupon code at the checkout<br>Thank you for shopping with us<br></strong>
<!--  end instructins-->
</td></tr>
<tr style="background: #eee;"><td>
<!-- st optin msg -->
If you would like to be added to our mailing list, please click on the following link (or if it does not show as a link, cut and paste the line in your browser)
<!-- end optin msg -->
</td></tr>
<tr><td>
<!--  st optin link -->
<a href="{|optIn|}" target="_blank">{|optIn|}</a>
</td></tr>
<!-- end optin link -->


<!-- st optional --><tr style="background: #eee;"><td>{|optionalMessage|}</td></tr><!-- end optional -->


</table>
</body>
</html>';

