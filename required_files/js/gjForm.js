$(document).ready(function(e){

if(getCookie('gjnomodal')) {
   $('#outer-modal-content').hide();
  if(gjDebug) alert('we have a cookie which tells us to wait for more time before showing the popup again');
  return;
}



/*
        backgroundColor:"transparent",
        borderColor:"black",
        height:200,
        padding:0,
        width:950
*/

// see css #simplemodal-container

    $('#outer-modal-content').modal({
      overlayClose:true,
      escClose:true,
      position: ["220","40"],
    onOpen: function (dialog) {
        dialog.overlay.fadeIn('slow', function () {
          dialog.data.hide();
            dialog.container.fadeIn('slow', function () {
            dialog.data.slideDown('slow');
            $('#email').focus();
            });
        });
    },
    onClose: function (dialog) {
        dialog.data.fadeOut('slow', function () {
          dialog.container.slideUp('slow', function () {
            dialog.overlay.fadeOut('slow', function () {
              $.modal.close(); // must call this!
              $('#getFree').hide();
            });
          });
        });
    }
  });

// if gjwhere ie ajax url is off, one message is Not connected. Verify Network,
//  "request.fail: parsererror"

//  "request.fail: parsererror" is commonly a php error, trun on erro logs and check the php error log,
// tun on // $gjDebug = TRUE; in file coupon_db_config_inc.php


// gjwhere set by php in coupon_include
// err 2 check server and check ajax url ct: text/html rS: 4 s: 200 sT: OK
// can be caused by trigger_error('Invalid CSRF token.',  they get rejected as duplicate and try and enter another email address
function send(){
  var request;
  // abort any pending request
  if (request) {
       request.abort();
  }

  $("#processing").show();
  $("#processing").html("<p style='text-align:center'><em>sending...</em></p>");


  // fire off the request
  request = $.ajax({
      url : gjwhere,
      data :{
          'email':$('[name="email"]').val(),
          'first':$('[name="first"]').val(),
          'phone':$('[name="phone"]').val(),
          'CSRFName' :$('[name="CSRFName"]').val(),
          'CSRFToken':$('[name="CSRFToken"]').val()
      },
      type:"POST",
      dataType:"json"
  });

  // callback handler that will be called on success
  request.done(function (response, textStatus, jqXHR){
          if(response.status === true){
            $("#processing").html("<p style='text-align:center'><em>thank you</em></p>");
            $.modal.close();
          }else{
            var expr = /duplicate/gi;
            if(expr.test(response.message)) {
              $('#processing').html( "<p>We already have your email address on file </p>" );
            } else {
              $('#processing').html( "<p>err 1 rs: " + response.status + " ct: " + jqXHR.getResponseHeader("content-type")  + " rm: " +response.message + " rS: " + jqXHR.readyState + " rT: " + jqXHR.responseText + " s: " + jqXHR.status + " sT: " + jqXHR.statusText + "</p>" );
            }
          }
  });

  // callback handler that will be called on failure
  request.fail(function (jqXHR, textStatus, errorThrown){
      var msg1='';
      if (jqXHR.status === 0) {
         msg1+='Not connected. Verify Network. :';
      } else if (jqXHR.status == 404) {
         msg1+='Requested page not found. [404]';
      } else if (jqXHR.status == 500) {
         msg1+='Internal Server Error [500].';
      }
     $('#processing').html("<p>err 2 check server and check ajax url " + msg1 + " ct: " + jqXHR.getResponseHeader("content-type") + " rS: " + jqXHR.readyState + " s: " + jqXHR.status + " sT: " + jqXHR.statusText + "</p>" );

  });

  // callback handler that will be called regardless
  // if the request failed or succeeded
  request.always(function () {
      //console.log("request, always logged ");
  $("#processing").html("<p style='text-align:center'><em>good bye</em></p>");
  var gjdate = new Date();
  gjdate.setTime(gjdate.getTime()+(daysToWaitBeforeNextPopup*24*60*60*1000));
  setCookie('gjnomodal','1',gjdate);
  $.modal.close();
  });

}  //send

//thier is also a shortcut version of this
$('#sfm').on('submit',  function(e){
    e.preventDefault();
    if(validateOnSubmit('sfm')) {
      send();
    }
});

});  //ready

