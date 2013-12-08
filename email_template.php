<?php

$result = mysql_query("select * from popupsetting where type='email'");
$emailtemplate = "";
while ($row = mysql_fetch_assoc($result)) {
	$emailtemplate=$row['value'];
}

mysql_free_result($result);

?>

<?php

$email_block = '
<html>
   <head>
      <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
   </head>
   <body style="font: 14px/1.4285714 Arial, sans-serif; color: #333">
   <table style="width: 100%; border-collapse: collapse">
   <tbody>
      <tr><td style="font: 14px/1.4285714 Arial, sans-serif; padding: 10px 10px 0; background: #f5f5f5">
         <table style="width: 100%; border-collapse: collapse">
   <tbody>
      <tr><td id="main" style="font: 14px/1.4285714 Arial, sans-serif; padding: 0">
         <div style="background: #fff; border: 1px solid #ccc; border-radius: 5px; padding: 20px">
         <table style="width: 100%; border-collapse: collapse">
   <tbody>
      <tr><td style="font: 14px/1.4285714 Arial, sans-serif; padding: 0">
         <p style="margin-bottom: 0; margin-top: 0">

         '.$emailtemplate.'

         </p>
         </td>
      </tr>
      <tr>
         <td class="call-to-action" style="font: 14px/1.4285714 Arial, sans-serif; padding: 15px 0 0">
         <table style="width: auto; border-collapse: collapse">
            <tbody>
               <tr>
                  <td class="call-to-action-inner" style="font: 14px/1.4285714 Arial, sans-serif; padding: 0">
                  <div style="border: 1px solid #486582; border-radius: 3px; background: #3068a2">
                  <table style="width: auto; border-collapse: collapse">
                     <tr><td style="font: 14px/1.4285714 Arial, sans-serif; padding: 4px 10px">

                        <a style="color: white; text-decoration: none; font-weight: bold">{|couponcode|}</a>

                        </td>
                     </tr>
                  </table>
                  </div>
                  </td>
               </tr>
            </tbody>
         </table>
         </td>
      </tr>
   </tbody>
   </table></div>
   </td>
   </tr>
    </tbody></table></td>
   </tr></tbody></table></body>
</html>';

