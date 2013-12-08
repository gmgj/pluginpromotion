<!DOCTYPE html>
<!-- HTML5 Mobile Boilerplate -->
<!--[if IEMobile 7]><html class="no-js iem7"><![endif]-->
<!--[if (gt IEMobile 7)|!(IEMobile)]><!--><html class="no-js" lang="en"><!--<![endif]-->
<!-- HTML5 Boilerplate -->
<!--[if lt IE 7]><html class="no-js lt-ie9 lt-ie8 lt-ie7" lang="en"> <![endif]-->
<!--[if (IE 7)&!(IEMobile)]><html class="no-js lt-ie9 lt-ie8" lang="en"><![endif]-->
<!--[if (IE 8)&!(IEMobile)]><html class="no-js lt-ie9" lang="en"><![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="en"><!--<![endif]-->
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

<meta http-equiv="cleartype" content="on">

<!-- Responsive and mobile friendly stuff -->
<meta name="HandheldFriendly" content="True">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<style type="text/css">
html { min-height: 100%; }

a, a:link{
font-weight: bold;
/* line-height:1.8em; */
font-size: 1em;
color: navy;
text-decoration: none;
width:50em;
background-color:whitesmoke; }

a:hover {  color: blue;}

a:visited { color: teal;}

a:visited:hover {
font-weight: normal;
color: blue;
text-decoration: none;}

b {font-size:larger;color:black;background-color:gainsboro;padding:0 5px; margin:0 5px;}

ul.none {list-style-type: none;}
ul, li {
margin: 0;
padding: 5px 5px;
display:block;}

</style>
<title>PopUp Coupon Admin</title>
</head>
<body style='margin:10px 0 0 25px;'>
<?php require_once 'required_files/Simpleheader.html'; ?>

<ul class="none">
<li>Click Here to run the <a href="PHPandServerInfo.php" target="_blank"> Software Versions Check </a><br>
If you see the line "OK You are running a version of PHP" , you can continue
<br>If you see a line with "Not OK" , stop and please contact us</li>
</ul>



<ul class="none">
<li>Please open <b>File: coupon_db_config_inc.php</b> in an <b>EDITOR</b> to make changes.<br>
<strong>Their are detailed instructions on what to do in the file.</strong><br>
Click here <a href="display_dbc_file.php" target="_blank">To read <b>the coupon_db_config_inc.php file </b> </a> in a browser window.</li>
</ul>


<ul class="none">
<li>After you have completed making the necessary changes to the coupon_db_config_inc.php file,<br>
Click here <a href="coupon_db_setup.php" target="_blank">to run the Database setup </a>File: coupon_db_setup.php <br>
If you see the line towards the bottom of the page <span style='color:red'>NOT OK You have errors</span>, Stop and contact us.<br>
If you see the line &quot;OK You are ready to go &quot;, you are all set.</li>
<li><a href="print_coupon_popupsetting_table.php" target="_blank">View the popupsetting table </a></li>
<li><a href="display_ept_file.php" target="_blank">Read the instructions </a> on what changes to make to the popupsetting table in a browser window.  File: Edit_Popusetting_table.txt</li>
<li><a href="required_files/jTable/edit_coupon_popupsetting_table.php" target="_blank">Edit the popupsetting table </a></li>
<li><a href="test_popup.php" target="_blank">Run a Test Popup ! </a></li>
<li><a href="delete_coupon_cookie.php" target="_blank">View and Delete the Coupon Cookie </a> this is useful to run repeated tests of a Test Popup</li>
<li><a href="print_coupon_email_table.php" target="_blank">View the Email Table </a> check the email entries, did it work?</li>
<li><a href="reset_coupon_email_table.php" target="_blank">Reset Emails Table </a> delete test entries, to make testing easier</li>
<li><a href="send_email_message.php" target="_blank">Send a Regular text Email </a> to check if this mail system is working and check emailFrom</li>
<li><a href="send_HTML_email_message.php" target="_blank">Send an HTML Email to check your email template</a></li>
<li><a href="destroy_coupon_tables.php" target="_blank">Delete our tables in the Database </a> Delete the install directories to completely uinistall</li>
</ul>


<p>
Our software will work on all the major hosting platforms, Godaddy, Rackspace, Hostgator etc. We follow industry best practices for email optin in marketing,
<br>Please contact us if you have any problems <a target="_blank" href="mailto:gj@garyjohnsoninfo.info">email us</a>
We offer the ability to run a confirmed Opt-In mailing system <a target="_blank" href='http://www.sorbs.net/faq/spamdb.shtml'> More details </a>
</p>

</body>
</html>