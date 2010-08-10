/*
'****************************************************************************************
'**  Copyright Notice
'**  http://www.sagecomputerservices.com
'**
'**  Copyright 2007-2008 Sage Computer Services. All Rights Reserved.
'**
'**  This program is commercial proprietary software and may not be modified or distributed 
'**  either privately or commercially except under the terms of the License that accompanies 
'**  this software.
'**
'**  All copyright notices must remain intact in all scripts.
'**
'**  You may not redistribute, repackage, or sell the whole or any part of this program even
'**  if it is modified or reverse engineered in whole or in part without express
'**  permission from the author.
'**
'**  This program is distributed WITHOUT ANY WARRANTY; without even the implied warranty of
'**  MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE OR ANY OTHER WARRANTIES WHETHER EXPRESSED OR IMPLIED.
'**
'**  Sage Computer Services
'**  http://www.sagecomputerservices.com
'**  sage@sagecomputerservices.com
'**
'****************************************************************************************     
*/      
var sHttpPrefix="http://";
var bTestSite=false;

var sHttpLocation=window.location.toString().toLowerCase();

// establish test vs live site
if (sHttpLocation.indexOf("minisage.com") > -1) 
{
	bTestSite=true;
}
// establish http vs https
if (sHttpLocation.indexOf("https") > -1)
{
	sHttpPrefix = "https://";
}

// set the correct domain based on the domain name the user entered the site with
var sLiveDomainPrefix="techformicrofinance.com/";

// helper current page
var g_sCurrentPage = window.location.toString().toLowerCase();
var nPos = g_sCurrentPage.lastIndexOf("/");
if (nPos != -1)
{
	g_sCurrentPage = g_sCurrentPage.substr(nPos+1);
}

var nSubMenuAdditionalWidthMedium = 150;   	//mfindlay
var nSubMenuAdditionalWidthWide = 200;    	//mfindlay

var nMenuWidth=190;				// width of menus to appear. Set to zero to ignore
var sBaseSite="";
var sNonSSLBaseSite="";

// If test site, just use 1 base site
if (bTestSite) 
{
	sBaseSite = sHttpPrefix + "grameen.minisage.com/";
	sNonSSLBaseSite = "http://" + "grameen.minisage.com/";
}
else
{
	sNonSSLBaseSite = "http://" + sLiveDomainPrefix;
	
	// live site. If https mode, use safesecureweb address
	if (sHttpPrefix=="https://")
	{
		sBaseSite = sHttpPrefix + sLiveDomainPrefix;
	}
	else
	{
		// non ssl mode, use normal address
		sBaseSite = sHttpPrefix + sLiveDomainPrefix;
	}
} 
//********************************
// DisplayCopyrightYear
//********************************
function DisplayCopyrightYear()
{
	var mydate=new Date();
	var year=mydate.getFullYear();
	
	document.write(year);
}
//********************************
// DDtoDay
//********************************
function DDtoDay(inputDate)
{
  var dateString = new Array('','st','nd','rd','th','th','th','th','th','th','th','th','th','th','th','th','th','th','th','th','th','st','nd','rd','th','th','th','th','th','th','th','st');
  returnDate = '';
  tempDate = parseInt(inputDate);
  if (tempDate >= 1 && tempDate <= 31)
  {
	  returnDate = inputDate + dateString[tempDate];
	}
	return returnDate;
}
//********************************
// DisplayDate
//********************************
function DisplayDate()
{
	var mydate		= new Date();
	var year		= mydate.getFullYear();
	var month		= mydate.getMonth();
	var day			= mydate.getDate();
	var dayofweek	= mydate.getDay();
	
	var MonthArray = new Array('January','February','March','April','May','June','July','August','September','October','November','December');
	var DayOfWeekArray = new Array('Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday');
	
	document.write(DayOfWeekArray[dayofweek] + ', ' + MonthArray[month] + ' ' + day.toString() + ', ' + year.toString());
}
//****************************************************
// randomNumber
//****************************************************
function randomNumber(limit){
  return (Math.floor(Math.random()*limit).toString());
}
//****************************************************
// ToNumeric
// converts a string to a number as long as the string is > "-999999"
//****************************************************
function ToNumeric(sString)
{
	if (sString.length<1) return 0;
	return Math.max(-99999,sString);
}
//*******************************
// IsValidEmail
//*******************************
function IsValidEmail(sEmail)
{
	return (sEmail.search(/^\w+((-\w+)|(\.\w+))*\@[A-Za-z0-9]+((\.|-)[A-Za-z0-9]+)*\.[A-Za-z0-9]+$/) != -1);
}
//****************************************************
// IsMac
//****************************************************
function IsMac()
{
  if(navigator.appVersion.indexOf("Win") != -1)
  {
    return false;
  }
  else if(navigator.appVersion.indexOf("Mac") != -1)
  {
    return true;
  }
  else return false;
}
//****************************************************
// AreDatesInSequence
// determines if from date is < = to date
//****************************************************
function AreDatesInSequence(strFROM, strTO)
{
	var dtFrom = new Date(strFROM);
	var dtTo = new Date(strTO);
	
	if (dtFrom.getFullYear() < dtTo.getFullYear()) { return true; }
	
	if (dtFrom.getFullYear() == dtTo.getFullYear()) 
	{
		if (dtFrom.getMonth() < dtTo.getMonth()) { return true; }
	}
	
	if (dtFrom.getFullYear() == dtTo.getFullYear()) 
	{
		if (dtFrom.getMonth() == dtTo.getMonth()) 
		{
			if (dtFrom.getDate() <= dtTo.getDate()) { return true; } 
		}
	}
	
	return false;
}
//****************************************************
// ConvertHTML
// Converts the opening and closing HTML tags to parens
//****************************************************
function ConvertHTML(sInput)
{
	var sOutput = sInput;
    sOutput=sOutput.replace(/</g,"(");
    sOutput=sOutput.replace(/>/g,")");
	return sOutput;
}
//****************************************************
// CleanWordChars
//****************************************************
function CleanWordChars(inputString)
{
	//alert("entry to CleanWords");
	
	var returnString = inputString;
	
	var nLen = returnString.length;
	
	//alert("before: " + returnString);
	
	// clean special MSWord chars
	returnString = returnString.replace(/…/g,"...");  			// replace elipses with ascii ...
	returnString = returnString.replace(/’/g,"'");  			// replace apos with ascii apos
	returnString = returnString.replace(/”/g,"\"");  			// replace ending quotes with ascii ending quotes
	returnString = returnString.replace(/“/g,"\"");  			// replace beginning quotes with ascii ending quotes
	returnString = returnString.replace(/½/g,"1/2");  			// replace ½ with 1/2
	
	//alert("after: " + returnString);

	var c='';
	
	for (var x=0; x<nLen; x++)
	{
		c = returnString.charAt(x);
		
		// standard alpha chars
		if ((c >='a') && (c <='z')) continue;
		if ((c >='A') && (c <='Z')) continue;
		if ((c >='0') && (c <='9')) continue;
		
		// standard keyboard special chars
		switch(c)
		{
			// Allow the < and the > since the calling code takes care of editing it.
			case '>' : continue;	
			case '<' : continue;	
			
			case ' ' : continue;	
			case '.' : continue;	
			case ',' : continue;	
			case '?' : continue;	
			case '!' : continue;	
			case '"' : continue;	
			case '-' : continue;	
			case '@' : continue;	
			case '#' : continue;	
			case '$' : continue;	
			case '%' : continue;	
			case '^' : continue;	
			case '*' : continue;	
			case '&' : continue;	
			case '(' : continue;	
			case ')' : continue;	
			case '_' : continue;	
			case '+' : continue;	
			case '=' : continue;	
			case '[' : continue;	
			case ']' : continue;	
			case '{' : continue;	
			case '}' : continue;	
			case '&' : continue;	
			case '\'' : continue;	
			case ';' : continue;	
			case ':' : continue;	
			case '`' : continue;	
			case '~' : continue;	
			case '/' : continue;	
			case '|' : continue;	
			case '\\' : continue;	
			case '\t' : continue;	
			case '\r' : continue;	
			case '\n' : continue;	
			case '\r\n' : continue;	
		}
		
		//alert("Replacing char: [" + c + "] with space");
		
		// drop this unknown char
		//returnString[x]=' '; 
		returnString = returnString.replace(c," ");  
	}
	
	return returnString;
}

//***********************************************
// FormatCurrency
//***********************************************
function FormatCurrency(num) 
{
	num = num.toString().replace(/\$|\,/g,'');
	
	if (isNaN(num))
	{
		num = "0";
	}
	
	sign = (num == (num = Math.abs(num)));
	num = Math.floor(num*100+0.50000000001);
	cents = num%100;
	num = Math.floor(num/100).toString();
	
	if (cents<10)
	{
		cents = "0" + cents;
	}
	
	for (var i = 0; i < Math.floor((num.length-(1+i))/3); i++)
	{
		num = num.substring(0,num.length-(4*i+3))+','+ num.substring(num.length-(4*i+3));
	}
	
	//return (((sign)?'':'-') + '$' + num + '.' + cents);
	return (((sign)?'':'-') + num + '.' + cents);
}
//****************************************************
// StripStringOfVulnerableChars 
// Removes vulnerable chars from a string
//****************************************************
function StripStringOfVulnerableChars(sString,bStripSpaces)
{
	
	var s = sString.replace(/'/g,"");  	// remove tics from string
	s = s.replace(/;/g,"");  			// remove semicolons from string
	s = s.replace(/\(/g,"");  			// remove lefts paren from string
	s = s.replace(/\)/g,"");  			// remove right parens from string
	s = s.replace(/\*/g,"");  			// remove asterisk from string
	s = s.replace(/"/g,"");  			// remove double quotes from string
	s = s.replace(/--/g,"");  			// remove double dash from string
	s = s.replace(/=/g,"");  			// remove equal signs from string

	//s = s.replace(/#/g,"");  			// remove pound signs from string
	if (bStripSpaces)
	{
		s = s.replace(/ /g,"");  		// remove spaces from string
	}
	return s;
}
//****************************************************
// StripStringOfCommas 
// Removes commas from a string
//****************************************************
function StripStringOfCommas(sString)
{
	
	var s = sString.replace(/,/g,"");  	// remove commas from string

	return s;
}

//****************************************************
// JSTrim
// Removes LEADING and TRAILING spaces ONLY from a string
// optional 3rd and 4th parms: BOOL BOOL
// 3rd parm: BOOL  - strip vulnerable chars
// 4th parm: BOOL  - strip internal spaces as part of strip
//****************************************************
function JSTrim (inputString, removeChar) 
{
	// Clean MSWord chars et al.
	//var returnString = CleanWordChars(inputString);
	// no need to clean word chars in UTF-8 mode
	var returnString = inputString;	
	if (removeChar.length)
	{
	  while(''+returnString.charAt(0)==removeChar)
		{
		  returnString=returnString.substring(1,returnString.length);
		}
		while(''+returnString.charAt(returnString.length-1)==removeChar)
	  {
	    returnString=returnString.substring(0,returnString.length-1);
	  }
	}
	var s = ConvertHTML(returnString);
	
	// check to see if additional parms were passed to tell us to 
	// strip out dangerous security risk chars
	var bCheckForVulnerabilities = (JSTrim.arguments.length > 2) ? JSTrim.arguments[2] : false;
	var bStripSpacesFromString = (JSTrim.arguments.length > 3) ? JSTrim.arguments[3] : false;
	
	// if requested, strip also for vulnerabilities
	if (bCheckForVulnerabilities) 
	{
		s = StripStringOfVulnerableChars(s,bStripSpacesFromString);
	}
	else
	{
		// just clean of all spaces?
		if (bStripSpacesFromString)
		{
			s = s.replace(/ /g,"");  		// remove spaces from string
		}
	}
	
	return s;
}
//****************************************************
// JSTrimSpace
// Removes leading and trailing spaces from a string
// optional 2nd and 3rd parms: BOOL BOOL
// 2nd parm: BOOL  - strip vulnerable chars
// 3rd parm: BOOL  - strip internal spaces as part of strip
//****************************************************
function JSTrimSpace(inputString)
{
	// strip vulnerable chars?
	var bCheckForVulnerabilities = (JSTrimSpace.arguments.length > 1) ? JSTrimSpace.arguments[1] : false;
	var bStripSpacesFromString = (JSTrimSpace.arguments.length > 2) ? JSTrimSpace.arguments[2] : false;

	return JSTrim(inputString,' ',bCheckForVulnerabilities,bStripSpacesFromString);
}
//*******************************
// IsValidCCNumber
//*******************************
function IsValidCCNumber(s) {
	// remove non-numerics
	var v = "0123456789";
	var w = "";
	for (i=0; i < s.length; i++) {
	x = s.charAt(i);
	if (v.indexOf(x,0) != -1)
	w += x;
	}
	// validate number
	j = w.length / 2;
	if (j < 6.5 || j > 8 || j == 7) return false;
	k = Math.floor(j);
	m = Math.ceil(j) - k;
	c = 0;
	for (i=0; i<k; i++) {
	a = w.charAt(i*2+m) * 2;
	c += a > 9 ? Math.floor(a/10 + a%10) : a;
	}
	for (i=0; i<k+m; i++) c += w.charAt(i*2+1-m) * 1;
	return (c%10 == 0);
}
//*******************************
// CleanCCNumber
//*******************************
function CleanCCNumber(s)
{
	// remove non-numerics
	var v = "0123456789";
	var w = "";
	for (i=0; i < s.length; i++) 
	{
		x = s.charAt(i);
		if (v.indexOf(x,0) != -1)
		w += x;
	}
	
	return w;
}
//****************************************************
// CCTrim (credit card trim)
// Removes dashes from a string
// Removes spaces from anywhere within the string
//****************************************************
function CCTrim(sString)
{
	var s = sString.replace(/-/g,"");  // remove dashes from string
	s = s.replace(/ /g,"");  // remove spaces from string
	return s;
}

//****************************************************
// IsPositiveInt
// Returns true if a string >= zero.
//****************************************************
function IsPositiveInt(sString)
{
	if (sString.length < 1) return false;
	
	for (var x=0; x<sString.length; x++)
	{
		// Make sure the tax rates are numeric only, with the exception of the '.'
		if (sString.charAt(x) < "0" || 
			sString.charAt(x) > "9")
		{
			return false;
		}
	}
	return true;
}
//****************************************************
// ValidateNumericInput
//****************************************************
function ValidateNumericInput(nKeyCode)
{
	// allow 0 through 9 on regular keyboard
	if ((nKeyCode >= 48) && (nKeyCode <= 57)) return true;
	// allow 0 through 9 on keypad
	if ((nKeyCode >= 96) && (nKeyCode <= 105)) return true;
	
	// allow backspace
	if (nKeyCode == 8) return true;
	
	// allow delete key
	if (nKeyCode == 46) return true;
	
	// allow tab key
	if (nKeyCode == 9) return true;
	// allow shift key
	//if (nKeyCode == 16) return true;
	// allow decimal point (period)
	//if (nKeyCode == 190) return true;
	//alert(nKeyCode);
	return false;
}
var popUpLinkWin=0;
//****************************************************
// popUpLinkWindow
// optional arguments: width,height,left,top
//****************************************************
function popUpLinkWindow(url,target)
{
  	if(popUpLinkWin)
  	{
    	if(!popUpLinkWin.closed) popUpLinkWin.close();
  	}
	
	var nWidth=600;
	var nHeight=400;
	var nLeft=10;
	var nTop=10;
	
	if (popUpLinkWindow.arguments.length > 2)
	{
		nWidth = parseInt(popUpLinkWindow.arguments[2])
	}
	if (popUpLinkWindow.arguments.length > 3)
	{
		nHeight = parseInt(popUpLinkWindow.arguments[3])
	}
	if (popUpLinkWindow.arguments.length > 4)
	{
		nLeft = parseInt(popUpLinkWindow.arguments[4])
	}
	if (popUpLinkWindow.arguments.length > 5)
	{
		nTop = parseInt(popUpLinkWindow.arguments[5])
	}
	
	
	popUpLinkWin = open(url, target, 'height=' + nHeight + ',width=' + nWidth + ',left=' + nLeft + ',top=' + nTop + ',toolbar=yes,menubar=yes,scrollbars=yes,resizable=yes,location=yes,directories=yes,status=yes');
	popUpLinkWin.focus();
}
//****************************************************
// IsOpera
//****************************************************
function IsOpera()
{
	var sString = navigator.userAgent.toLowerCase();
	if(sString.indexOf("opera") != -1)
	{
		return true;
	}
	return false;
}

//**********************************************************
// Browser Detect  v2.1.6
// documentation: http://www.dithered.com/javascript/browser_detect/index.html
// license: http://creativecommons.org/licenses/by/1.0/
// code by Chris Nott (chris[at]dithered[dot]com)
//**********************************************************
function BrowserDetect() {
   var ua = navigator.userAgent.toLowerCase(); 

   // browser engine name
   this.isGecko       = (ua.indexOf('gecko') != -1 && ua.indexOf('safari') == -1);
   this.isAppleWebKit = (ua.indexOf('applewebkit') != -1);

   // browser name
   this.isFirefox     = (ua.indexOf('firefox') != -1);     //mjf
   this.isChrome     = (ua.indexOf('chrome') != -1);     //mjf
   this.isKonqueror   = (ua.indexOf('konqueror') != -1); 
   this.isSafari      = (ua.indexOf('safari') != - 1);
   this.isOmniweb     = (ua.indexOf('omniweb') != - 1);
   this.isOpera       = (ua.indexOf('opera') != -1); 
   this.isIcab        = (ua.indexOf('icab') != -1); 
   this.isAol         = (ua.indexOf('aol') != -1); 
   this.isIE          = (ua.indexOf('msie') != -1 && !this.isOpera && (ua.indexOf('webtv') == -1) ); 
   this.isMozilla     = (this.isGecko && ua.indexOf('gecko/') + 14 == ua.length);
   this.isFirebird    = (ua.indexOf('firebird/') != -1);
   this.isNS          = ( (this.isGecko) ? (ua.indexOf('netscape') != -1) : ( (ua.indexOf('mozilla') != -1) && !this.isOpera && !this.isSafari && (ua.indexOf('spoofer') == -1) && (ua.indexOf('compatible') == -1) && (ua.indexOf('webtv') == -1) && (ua.indexOf('hotjava') == -1) ) );
   
   // spoofing and compatible browsers
   this.isIECompatible = ( (ua.indexOf('msie') != -1) && !this.isIE);
   this.isNSCompatible = ( (ua.indexOf('mozilla') != -1) && !this.isNS && !this.isMozilla);
   
   // rendering engine versions
   this.geckoVersion = ( (this.isGecko) ? ua.substring( (ua.lastIndexOf('gecko/') + 6), (ua.lastIndexOf('gecko/') + 14) ) : -1 );
   this.equivalentMozilla = ( (this.isGecko) ? parseFloat( ua.substring( ua.indexOf('rv:') + 3 ) ) : -1 );
   this.appleWebKitVersion = ( (this.isAppleWebKit) ? parseFloat( ua.substring( ua.indexOf('applewebkit/') + 12) ) : -1 );
   
   // browser version
   this.versionMinor = parseFloat(navigator.appVersion); 
   
   // correct version number
   if (this.isGecko && !this.isMozilla) {
      this.versionMinor = parseFloat( ua.substring( ua.indexOf('/', ua.indexOf('gecko/') + 6) + 1 ) );
   }
   else if (this.isMozilla) {
      this.versionMinor = parseFloat( ua.substring( ua.indexOf('rv:') + 3 ) );
   }
   else if (this.isIE && this.versionMinor >= 4) {
      this.versionMinor = parseFloat( ua.substring( ua.indexOf('msie ') + 5 ) );
   }
   else if (this.isKonqueror) {
      this.versionMinor = parseFloat( ua.substring( ua.indexOf('konqueror/') + 10 ) );
   }
   else if (this.isSafari) {
      this.versionMinor = parseFloat( ua.substring( ua.lastIndexOf('safari/') + 7 ) );
   }
   else if (this.isOmniweb) {
      this.versionMinor = parseFloat( ua.substring( ua.lastIndexOf('omniweb/') + 8 ) );
   }
   else if (this.isOpera) {
      this.versionMinor = parseFloat( ua.substring( ua.indexOf('opera') + 6 ) );
   }
   else if (this.isIcab) {
      this.versionMinor = parseFloat( ua.substring( ua.indexOf('icab') + 5 ) );
   }
   
   this.versionMajor = parseInt(this.versionMinor); 
   
   // dom support
   this.isDOM1 = (document.getElementById);
   this.isDOM2Event = (document.addEventListener && document.removeEventListener);
   
   // css compatibility mode
   this.mode = document.compatMode ? document.compatMode : 'BackCompat';

   // platform
   this.isWin    = (ua.indexOf('win') != -1);
   this.isWin32  = (this.isWin && ( ua.indexOf('95') != -1 || ua.indexOf('98') != -1 || ua.indexOf('nt') != -1 || ua.indexOf('win32') != -1 || ua.indexOf('32bit') != -1 || ua.indexOf('xp') != -1) );
   this.isMac    = (ua.indexOf('mac') != -1);
   this.isUnix   = (ua.indexOf('unix') != -1 || ua.indexOf('sunos') != -1 || ua.indexOf('bsd') != -1 || ua.indexOf('x11') != -1)
   this.isLinux  = (ua.indexOf('linux') != -1);
   
   // specific browser shortcuts
   this.isNS4x = (this.isNS && this.versionMajor == 4);
   this.isNS40x = (this.isNS4x && this.versionMinor < 4.5);
   this.isNS47x = (this.isNS4x && this.versionMinor >= 4.7);
   this.isNS4up = (this.isNS && this.versionMinor >= 4);
   this.isNS6x = (this.isNS && this.versionMajor == 6);
   this.isNS6up = (this.isNS && this.versionMajor >= 6);
   this.isNS7x = (this.isNS && this.versionMajor == 7);
   this.isNS7up = (this.isNS && this.versionMajor >= 7);
   
   this.isIE4x = (this.isIE && this.versionMajor == 4);
   this.isIE4up = (this.isIE && this.versionMajor >= 4);
   this.isIE5x = (this.isIE && this.versionMajor == 5);
   this.isIE55 = (this.isIE && this.versionMinor == 5.5);
   this.isIE5up = (this.isIE && this.versionMajor >= 5);
   this.isIE6x = (this.isIE && this.versionMajor == 6);
   this.isIE6up = (this.isIE && this.versionMajor >= 6);
   
   this.isIE4xMac = (this.isIE4x && this.isMac);
}
var browser = new BrowserDetect();

//---------------------------------------
// GetCSSFilename
// Returns the css file to use based on the user's browser
//---------------------------------------
function GetCSSFilename()
{
	//dim sBrowser
	var sPlatform = (browser.isMac) ? "mac_" : "pc_";
	var sFile="";
	var sBrowser="";
	
	// Determine running IE
	if (browser.isIE)
	{
		sBrowser = "ie";
	}
	
	// Determine running Safari
	if (browser.isSafari)
	{
		sBrowser = "safari";
	}
	
	// Determine running Chrome
	if (browser.isChrome)
	{
		sBrowser = "chrome";
	}
	
	// Determine running Opera
	if (browser.isFirefox)
	{
		sBrowser = "firefox";
	}
	
	// Determine running Opera
	if (browser.isOpera)
	{
		sBrowser = "opera";
	}
	
	// determine if user is on a Netscape 4.xx 
	if (browser.isNS4x)
	{
		sBrowser = "ns4";
	}
	
	// determine if user is on a Netscape 6.xx 
	if (browser.isNS6x)
	{
		sBrowser = "ns6";
	}
	
	// determine if user is on a Netscape 7.xx 
	if (browser.isNS7up)
	{
		sBrowser = "ns7";
	}
	
	// if no browser yet determined, attempt a default
	if (sBrowser=="")
	{
		if (browser.isNS)
		{
			sBrowser="ns7";
		}
	}

	// set the filename
	sFile = sPlatform + sBrowser + ".css";
	
	// build appropriate stylesheet link
	//alert(sBaseSite + "css/" + sFile);
	//alert("<link href=\"" + sBaseSite + "css/" + sFile + "\" rel=\"stylesheet\" type=\"text/css\" />");
	document.writeln("<link href=\"" + sBaseSite + "css/" + sFile + "\" rel=\"stylesheet\" type=\"text/css\" />");
}
//**********************************************
// isNumberFloat
//**********************************************
function isNumberFloat(inputString)
{
  return (!isNaN(parseFloat(inputString))) ? true : false;
}
//**********************************************
// isNumberInt
//**********************************************
function isNumberInt(inputString)
{
  return (!isNaN(parseInt(inputString))) ? true : false;
}

//**********************************************
// GetUserLanguage
//**********************************************
function GetUserLanguage()
{
	var sUserLang = '?';
	
	if ( window.navigator.language )
	{
		sUserLang = window.navigator.language.toLowerCase();
	}
	else 
	{
		if ( window.navigator.userLanguage )
		{
			sUserLang = window.navigator.userLanguage.toLowerCase();
		}
	}
		
	// truncate to just the first 2 chars
	if (sUserLang.length > 2)
	{
		sUserLang = sUserLang.substr(0,2);
	}
	
}
//**********************************************
// InitLogo
//**********************************************
var objTopNavTable = null;
function InitLogo()
{
	//fixIE6flicker
	try {
	document.execCommand('BackgroundImageCache', false, true);
	} catch(e) {}

	// initialize the 'body'
	objTopNavTable = $('table.topnavtable'); 
	
    $("div.topnavlogo").mouseover(function(){
     	objTopNavTable.css("background-image","url(/graphics/common/topbg_over.jpg)");
    }).mouseout(function(){
      objTopNavTable.css("background-image","url(/graphics/common/topbg.jpg)");
    }).click(function(){
      window.location.href="/";
    });

}
//**********************************************
// InitNavTables
//**********************************************
function InitNavTables()
{
	var sHref="";
	var arrSplit = new Array();
	var nLen=0;
	var sClass="";
	var objParent=null;
	var sSection="";
	var sCurrentPath = window.location.toString().toLowerCase();
	
	// g_sCurrentPage contains the name of the current page. Compare it with the nav link and if equal, 
	// set the item class to the "selected" equivalent. 
	// besides searching the page name, if the parent has a section="" value, then if the href is within that section,
	// also change the parent class to its "selected" equivalent.
	$('.navtable a').each(
		  function(nIndex)
		  {
			  	objParent = $(this).parent();
				sHref = $(this).attr("href").toLowerCase();
				arrSplit = sHref.split("/");
				
				nLen = arrSplit.length;
				if (nLen)
				{
					sHref = arrSplit[nLen-1];
				}
	
				// current page?
				if (sHref == g_sCurrentPage)
				{
					objParent = $(this).parent();
					sClass = objParent.attr("class");
					objParent.removeClass(sClass);
					sClass += "selected";
					objParent.addClass(sClass);
				} // if (sHref == g_sCurrentPage)
				else
				{
					// see if the parent has a "section" attribute. If so, if we are in that section, 
					// set the parent to selected.
					sSection = objParent.attr("section");
					if (sSection)
					{
						if (sCurrentPath.indexOf(sSection) != -1)
						{
							sClass = objParent.attr("class");
							objParent.removeClass(sClass);
							sClass += "selected";
							objParent.addClass(sClass);
						}
					}
				}
		  } // function(nIndex)
    ); // $('#subnav_ul li a').each(	
}
//******************************
//
//******************************
function ValidateEmailSignup()
{
	var sString = JSTrim(document.emailsignup.email.value,' ');
	document.emailsignup.email.value = sString;
	
	if ((sString.length==0) || (!(IsValidEmail(sString))))
	{
		document.emailsignup.email.focus();
		alert("Please enter a valid email address");
		return false;
	}
	
	setTimeout('document.emailsignup.submit()',10);
	return true;
}
//*****************************************
// RunBannerSlideshow
//*****************************************
function RunBannerSlideshow()
{
    var $active = $('#banner_slideshow IMG.active');
    var $active_credit = $('#banner_slideshow_credits DIV.active');

    if ( $active.length == 0 ) $active = $('#banner_slideshow IMG:last');
    if ( $active_credit.length == 0 ) $active_credit = $('#banner_slideshow_credits DIV:last');

    var $next =  $active.next().length ? $active.next() : $('#banner_slideshow IMG:first');
    var $next_credit =  $active_credit.next().length ? $active_credit.next() : $('#banner_slideshow_credits DIV:first');

    $active.addClass('last-active');
    $active_credit.addClass('last-active');

    $next.css({opacity: 0.0})
        .addClass('active')
        .removeClass('noshow')
        .animate({opacity: 1.0}, 1000, function() {
            $active.removeClass('active last-active');
        });
		
    $next_credit.css({opacity: 0.0})
        .addClass('active')
        .removeClass('noshow')
        .animate({opacity: 1.0}, 1000, function() {
            $active_credit.removeClass('active last-active');
         });
		// special addition: for the text div, need to explicity animate it to fade it out, starting as soon as the new text div is being made visible
		$active_credit.animate({opacity: 0.0}, 1000, function() {});
}
//*****************************************
// LaunchBannerSlideshow
//*****************************************
function LaunchBannerSlideshow()
{
	var $active = $('#banner_slideshow IMG.active');
	if ( $active.length == 0 ) return;
	
	setInterval( "RunBannerSlideshow()", 7000 );
}
//*****************************************
// RunHomepageSlideshow
//*****************************************
function RunHomepageSlideshow()
{
    var $active = $('#homepage_slideshow DIV.active');

    if ( $active.length == 0 ) $active = $('#homepage_slideshow DIV:last');

    var $next =  $active.next().length ? $active.next()
        : $('#homepage_slideshow DIV:first');

    $active.addClass('last-active');

    $next.css({opacity: 0.0})
        .addClass('active')
        .removeClass('noshow')
        .animate({opacity: 1.0}, 1000, function() {
            $active.removeClass('active last-active');
        });

}
//*****************************************
// LaunchBannerSlideshow
//*****************************************
function LaunchHomepageSlideshow()
{
	var $active = $('#homepage_slideshow DIV.active');
	if ( $active.length == 0 ) return;
	
	setInterval( "RunHomepageSlideshow()", 7000 );
}

/*********************************************** GRAMEEN *************************************/

//*****************************
// ValidateSearchContent
//*****************************
function ValidateSearchContent()
{
	var sString = JSTrim(document.monstersearch.search_theme_form.value,' ');
	document.monstersearch.search_theme_form.value = sString;
	if (sString.length < 1)
	{
		document.monstersearch.search_theme_form.focus();
		alert("Please enter a search term");
		return false;
	}
	
	document.monstersearch.action += sString;
	
	setTimeout('document.monstersearch.submit()',10);
	return true;
}
//*****************************************
// ToggleSubmenu
// toggles the visibility of the TR table rows
// under the TR with the ID passed in the parameter. 
// The TR represented in the passed parameter is
// always visible, but the TR rows under it with a 
// class of hideme are initially invisible. This 
// function will find the TR with the ID in the passed
// parameter, then for each sibling TR that follows and that 
// has a class of 'hideme', will toggle the visibility
// of that TR.
//*****************************************
function ToggleSubmenu(sSubmenuID)
{
	// find the owning TR
	var objOwningTR = $('TR #' + sSubmenuID);
	if ( objOwningTR.length == 0 ) return; // not found
	
	// get the first sibling
	var objSibling=objOwningTR.next();
	
	
	// determine if the owning TR is currently expanded or not
	if (objSibling.length != 0) 
	{
		// fetch the child td. this will what we set the up/down arrow to
		var ChildTD = $('TR #' + sSubmenuID + ' :first');
		//if (ChildTD.length == 0) alert("unable to find");
		
		// currently hidden? then show.
		if (objSibling.hasClass("hideme"))
		{
			// currently the TR is hidden, so we will be showing the items, so set the down arrow with the dark background as the css style for this TR
			//objOwningTR.css("background-image","url(myimages/common/arrow_down_selected.gif)");
			ChildTD.addClass("downarrow");
			ChildTD.removeClass("uparrow");
		}
		else
		{
			// currently the TR is showing, so we will be hiding the items, so set the up arrow with the dark background as the css style for this TR
			//objOwningTR.css("background-image","url(myimages/common/arrow_up_selected.gif)");
			ChildTD.addClass("uparrow");
			ChildTD.removeClass("downarrow");
		}
	}
	
	// loop
	// for each sibling TR with a class of 'hideme', toggle its visibility
	while (objSibling.length != 0)
	{
		// is this a toggle-able TR? No? then exit
		if (!objSibling.hasClass("cantoggle")) return;
		
		// Toggle this TR's visibility
		//objSibling.toggle();
		if (objSibling.hasClass("hideme"))
		{
			objSibling.removeClass("hideme");	
		}
		else
		{
			objSibling.addClass("hideme");	
		}
		
		// get the next TR
		objSibling = objSibling.next();
	}
	
}
