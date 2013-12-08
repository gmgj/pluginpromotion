<?php
//I need this here; however, it does give a warning in debug mode that can safely be ignored
if(!isset($_SESSION)){
session_start();
}

require_once 'coupon_db_config_inc.php';
require_once 'coupon_popupsetting_inc.php';
require_once 'required_files/gj_utility.inc.php';

if($showPopup!=='ON') {
	exit(0);
}

require_once 'required_files/gj_csrf.inc.php';

$name="CG_".mt_rand(0,mt_getrandmax());
$token=csrfguard_generate_token($name);

//echo $name.'<br>';
//echo $token;


?>
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


<style>
#donep, #donen, #doned { display:none;}

#simplemodal-container a.modalCloseImg {
background:url(required_files/images/x.png) no-repeat; /* adjust url as required */
width:25px;
height:29px;
display:inline;
z-index:3200;
position:absolute;
top:-15px;
right:-18px;
cursor:pointer;}

/*

width:400px;
  height:180px;
  margin:30px 50px;
  background-color:#ffffff;
  border:1px solid black;
  opacity:0.6;
  filter:alpha(opacity=60); /* For IE8 and earlier */
*/


#simplemodal-overlay {
/* background-color:azure; */
background-color:transparent;
  border:1px solid black;
  opacity:0.6;
  filter:alpha(opacity=60); /* For IE8 and earlier */
}



#simplemodal-container {
height:220px;
width:700px;
color:#bbb;
border:4px solid #444;
padding:12px;}
/*
#simplemodal-container code {background:#141414; border-left:3px solid #65B43D; color:#bbb; display:block; margin-bottom:12px; padding:4px 6px 6px;}
#simplemodal-container a {color:#ddd;}
#simplemodal-container #basic-modal-content {padding:8px;}
*/
.SHC {
background-color:rgb(252, 245, 235);
padding:2px 7px;
border-top:1px solid DarkCyan;
font-weight:bold;
margin:10px 0;}

input { padding:.4em;margin:.8em .8em;}

.exp {
margin:0 0 10px 7px;
text-align:center;
font-weight:bold;}

.exp2 { margin:10px 0 10px 7px;}

.noMobile { display:table-cell;}
.noMobileB { display:block;  }
.yesMobile {display:none;  }

button:hover, textarea:hover, select:hover, input:hover { background-color: whitesmoke;}

/*                                      */

@media only screen and (max-width: 600px) {
.noMobile { display:none; }
.yesMobile { display:block; }

.SHC {
background-color:black;
color:white;
padding:2px 7px;
border-top:1px solid DarkCyan;
font-weight:bold;
margin:10px 0;}

input { -webkit-border-radius: 0px; -moz-border-radius: 0px; border-radius: 0px; width:90% }
select { -webkit-border-radius: 0px; -moz-border-radius: 0px; border-radius: 0px; }

/*  REMOVE MARGINS AS ALL GO FULL WIDTH AT 480 PIXELS */

@media only screen and (max-width: 480px) {
.col {margin: 1% 0 1% 0%;}
}
</style>
<!--[if lt IE 7]>
<style type='text/css'>
	#simplemodal-container a.modalCloseImg {
		background:none;
		right:-14px;
		width:22px;
		height:26px;
		filter: progid:DXImageTransform.Microsoft.AlphaImageLoader(
			src='required_files/images/x.png', sizingMethod='scale'
		);
	}
</style>
<![endif]-->

<div id="outer-modal-content">
<div style='display:none'>
<img src='required_files/images/x.png' alt='' />
</div>
<div id='getFree'>

<div id='showForm'>

<form name="sfm" id="sfm" action="#" method="post" accept-charset="utf-8">

<p class="SHC"> <?php echo $popupHeading ?></p>

<input type="email" required placeholder="Email@address.com" name="email" id="email" maxlength="40" style='width:20em'>

<input type="text" required name="first" id="first" placeholder="First Name" pattern="['-.0-9A-Z`a-z\s]+"
 title="Alpha .,-,',` and numbers" maxlength="20" style='width:10em'>

<input type="text" required name="phone" id="phone" placeholder="Phone" pattern="\d{3}[-]\d{3}[-]\d{4}"
 title="617-242-0101" maxlength="30" style='width:10em'>

<input type="hidden" name="gjwhichAction" value="gtwo">
<input type="hidden" name="CSRFName" value="<?php echo $name; ?>">
<input type="hidden" name="CSRFToken" value="<?php echo $token; ?>">
<br>
<input type="Submit" id="submit1" value="Send Coupon" style='width:8em'>
</form>

<div id='processing'>
<img  style='display:none; margin:0 auto; width:128px; height:128px' src='required_files/images/ajax-loader.gif'>
</div>


</div> <!-- id='showForm'-->
</div> <!-- free -->
</div> <!-- outer-modal-modal -->

<script src="required_files/js/modernizr-2.5.3-min.js"></script>
<script src="http://code.jquery.com/jquery-1.8.1.min.js"></script>

<!-- simplemodal -->
<script type="text/javascript" src="required_files/js/jquery.easing.1.3.js"></script>
<script type="text/javascript" src="required_files/js/jquery.simplemodal.1.4.4.min.js"></script>

<script type="text/javascript">
// set the ajax url for gjform, global could skip the var?
<?php
echo "gjDebug = '".$gjDebug."';\n";
echo "gjwhere = '".$gjwhere."';\n";
echo "daysToWaitBeforeNextPopup = '".$daysToWaitBeforeNextPopup."';\n";
?>

function checkPhone(str)
{
//  if (!(preg_match('/^\d{3}[-]\d{3}[-]\d{4}(.*)?$/', $strin))) {

var phonexp = /^\d{3}[-]\d{3}[-]\d{4}(.*)?$/;
   if(phonexp.test(str)) {
      return 0; //not ok
   }  else {
      return 1;
   }
}

function checkEmail(str)
{
  var emailexp = /^[\w\-\.\+]+\@[a-zA-Z0-9\.\-]+\.[a-zA-z0-9]{2,4}$/;
  if(emailexp.test(str)) {
    return 0;
  } else {
   return 1;
  }
}
//I think this is id in

function checkText(instr)
{
try{
  var musthave = 0;
  if(instr.value.maxLength)
  {
    if (instr.value.length > instr.value.maxLength)
    return 2;
  }

  if(instr.hasAttribute("required"))
  {
    //alert(instr.id + " required attribute" );
    musthave = 1;
  }

  if((instr.value.length === 0) && musthave) return 1;
  if(instr.value.length === 0) return 0;

//unambigous utf-8
            //'    -  .     0-  9    A-  Z  `     a-   z sp
  var re = /[\x27\x2D\x2E\x30-\x39\x41-\x5a\x60\x61-\x7a\s\xC0-\xD6\xD8-\xF6\xF8-\xFF]+/;

  var gjret;

  gjret = instr.value.match(re);

  var ok = ((gjret) && gjret[0].length == instr.value.length) ? true : false;

    if(ok)
    {
      var singlequote = /\x27/g;
      var gjret2 = instr.value.match(singlequote);
      if((gjret2) && gjret2.length > 1)
      {
        return 3; //More than one single quote
      }
      else
      {
        return 0; // yippe
      }
    }
    else
    {
      return 3; //not my extended alpaha
    }
  }
   catch (theerror)
  {
    var wintxt = "\n" + "\n" + " - - -  "  + "Error in checktext " +  " - - - " + "\n" + theerror.name + " - - -  " + " " +  theerror.message + " - - - " + "\n";
    alert(wintxt);
    }

return 0;
}

function addEvents(id)
{
var field = document.getElementById(id);

  field.onfocus = function (){
  if ((this.value == "Email") ||
      (this.value == "First Name") ||
      (this.value == "Phone")) {
       this.value = "";
      }
  };
/*
  field.onblur = function (){
  if (this.value == "") {
      this.value = "";
     }
  };
*/
}

//addEvents("email");
addEvents("first");
addEvents("phone");


function validateOnSubmit(idin)
{
  var invalid = false; // Start by assuming everything is valid.
  var result=0;
  var msg1="";


  var first = document.getElementById('first');
  if (first.value == "First Name") {
      first.value = "";
  }

  var phone = document.getElementById('phone');
  if (phone.value == "Phone") {
      phone.value = "";
  }

  var email = document.getElementById('email');
  if (email.value == "YourEmail@Address.com") {
      email.value = "";
  }

  if((checkText(email) === 0) && (checkEmail(email.value)) !== 0) {
    alert ( 'bad email : '  + email.value);
    return 0;
  }

  if(checkText(first) !== 0) {
    alert ( 'bad first name : ' + first.value);
    return 0;
  }

  if((checkText(phone) !== 0) && (checkPhone(phone.value)) !== 0) {
    alert ( 'bad phone : ' + phone.value);
    return 0;
  }

return 1;
}

</script>

<script type="text/javascript" src="required_files/js/gjForm.js"></script>
<script type="text/javascript" src="required_files/js/gjCookie.js"></script>