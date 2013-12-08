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
<style>
#simplemodal-overlay {background-color:azure;opacity:.2;}
#simplemodal-container {height:320px; width:600px; color:#bbb; background-color:green; border:4px solid #444; padding:12px;}
#simplemodal-container code {background:#141414; border-left:3px solid #65B43D; color:#bbb; display:block; margin-bottom:12px; padding:4px 6px 6px;}
#simplemodal-container a {color:#ddd;}
#simplemodal-container a.modalCloseImg {background:url(required_files/images/x.png) no-repeat; width:25px; height:29px; display:inline; z-index:3200; position:absolute; top:-15px; right:-16px; cursor:pointer;}
#simplemodal-container #basic-modal-content {padding:8px;}
</style>
<script src="required_files/js/modernizr-2.5.3-min.js"></script>
<title>simpleMTest.</title>
</head>
<body>
<div style='display:none'>
<img src='required_files/images/x.png' alt='' />
</div>

http://creativecommons.org/licenses/by-sa/3.0/


<script src="http://code.jquery.com/jquery-1.8.1.min.js"></script>

<!-- simplemodal -->
<script type="text/javascript" src="required_files/js/jquery.easing.1.3.js"></script>
<script type="text/javascript" src="required_files/js/jquery.simplemodal.1.4.4.min.js"></script>

<script type="text/javascript">
$(document).ready(function(e){


// see css #simplemodal-container
/*
var src = "http://365.ericmmartin.com/";
$.modal('<iframe src="' + src + '" height="450" width="830" style="border:0">', {
	closeHTML:"",
	containerCss:{
		backgroundColor:"#fff",
		borderColor:"#fff",
		height:450,
		padding:0,
		width:830,
		overflow: 'hidden'
	},
	overlayClose:true
});
*/

	$.modal("<div><h1>SimpleModal</h1></div>",{
 	overlayClose:true,
    onOpen: function (dialog) {
	      dialog.overlay.fadeIn('slow', function () {
		      dialog.data.hide();
		        dialog.container.fadeIn('slow', function () {
			      dialog.data.slideDown('slow');
		        });
	      });
    },
    onClose: function (dialog) {
	      dialog.data.fadeOut('slow', function () {
		      dialog.container.slideUp('slow', function () {
			      dialog.overlay.fadeOut('slow', function () {
				      $.modal.close(); // must call this!
			      });
		      });
	      });
    }
  });


});

</script>

</body>
</html>
