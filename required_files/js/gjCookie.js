function getCookieVal (offset)
{
  var endstr = document.cookie.indexOf (";", offset);
  if (endstr == -1)
  endstr = document.cookie.length;
  return unescape(document.cookie.substring(offset, endstr));
}


function getCookie(name)
{
  try
  {
    var dc = document.cookie;
    var prefix = name + "=";
    var begin = dc.indexOf("; " + prefix);

    if (begin == -1)
    {
      begin = dc.indexOf(prefix);
      if (begin !== 0)
      return 0;
    }
    else
    begin += 2;

    var end = document.cookie.indexOf(";", begin);
    if (end == -1)
    end = dc.length;
  }
  catch (error)
  {
    gjonerror( error, "getCookie ");
    return 0;
  }

  return unescape(dc.substring(begin + prefix.length, end));
}

//always set the expires, the expires code below is bogus
function setCookie(name, value, expires, path, domain, secure)
{
  var curCookie = name + "=" + escape(value) +
  ((expires) ? "; expires=" + expires.toGMTString() : "") +
  ((path) ? "; path=" + path : "") +
  ((domain) ? "; domain=" + domain : "") +
  ((secure) ? "; secure" : "");
  document.cookie = curCookie;
}

function deleteCookie(name, path, domain)
{
  try
  {
    if (getCookie(name))
    {
      document.cookie = name + "=" +
      ((path) ? "; path=" + path : "") +
      ((domain) ? "; domain=" + domain : "") +
      "; expires=Thu, 01-Jan-70 00:00:01 GMT";
    }
    else
    {
      alert('Error in deleteCookie trying to delete non existent cookie ' + name);
    }
  }
  catch (error)
  {
    gjonerror( error, "deleteCookie");
  }
}

function getCookieItem(ckName, ckItem)
{
  var ckValue = unescape(getCookie(ckName));
  var ckOffset = ckValue.indexOf(ckItem);
  //changeInnerHTML("theop", returnInnerHTML("theop") + "<br> ckOffset " + ckOffset);

  if( ckOffset == -1)
  {
    return null;
  }
  else
  {
    var endStr = ckValue.indexOf("&", ckOffset);

    //changeInnerHTML("theop", returnInnerHTML("theop") + "<br> endStr " + endStr);

    if(endStr == -1)
    {
        var theItemOffset = ckValue.indexOf("=",ckOffset) + 1;
        //changeInnerHTML("theop", returnInnerHTML("theop") + "<br> theItemOffset " + theItemOffset + " " + ckValue);

        if(theItemOffset == -1)
        {
          return null;
        }
        else
        {
          return ckValue.substring(theItemOffset, ckValue.length);
        }
    }
    else
    {
        var thePair = ckValue.substring(ckOffset, endStr);
        var theItemOffset = thePair.indexOf("=") + 1;
        return (thePair.substring(theItemOffset, endStr));
    }
  }
return null;
}

function displayCookie(theCookie)
{
var txt = getCookie(theCookie);

if (txt)
  alert('we have cookie ' + theCookie);
else
  alert('no cookie');

}

function gjonerror(ex, msg)
{
  try
  {
      var wintxt = "\n" + " - - -  " +  "\n" + "\n" + " " + " - - -  "  + msg + " - - -  " + "\n" + " " + " - - -  "  + ex.name + " - - -  " + " " +  ex.message + " - - -  " + "\n" + "\n" + " - - -  " + " UA " + navigator.userAgent + " - - -  " + "\n" + "\n" + " - - -  ";
      alert(wintxt);

  }
  catch(error)
  {
    alert("Error in Error" + msg + "1: " + ex.name + "1: " + ex.message  + "2: " + error.name +  "2: " + error.name);
  }

  return false;
}
