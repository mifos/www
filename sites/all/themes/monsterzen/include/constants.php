<?php
/*
	Constants.php
	Various global variables 
	questions/comments: mfindlay@sagecomputerservices.com http://www.sagecomputerservices.com
*/

define("CRLF","\n");
//define("CRLF","<br>"); // for debugging - use "<br>" to display on screen.

// For ADMIN pages include files on live site
define("ADMIN_INCLUDE_LIVE",'/usr/local/lib/php/');
//define("ADMIN_INCLUDE_LIVE",'/usr/share/php/'); 
define("ADMIN_INCLUDE_TEST",ini_get('include_dir'));

define("TWITTER_LINK",'http://www.twitter.com/mifos');
define("FLICKR_LINK",'http://www.flickr.com/photos/40471339@N04/');
define("YOUTUBE_LINK",'http://www.youtube.com/grameen');
define("DONATE_NOW_LINK",'https://secure3.convio.net/gfusa/site/Donation2?idb=754735032&df_id=1500&1500.donation=form1');
define("EMAIL_LINK",'mifos@grameenfoundation.org');
define("CONTACT_LINK",'/?q=about/contact');

// change this value to ensure the latest copy of the included file gets brought in
define("INCLUDEFILE_TIMESTAMP","?112008172900");

// How long to keep cookies
define("GENERAL_COOKIE_DAYS",365);

// $_SESSION['registeredDownload']
$lvl="";
if (isset($_GET['phperrlvl'])) $lvl = $_GET['phperrlvl'];

// was PHP err level override set on querystring?
if (!empty($lvl))
{
	// yes: set session var
	$_SESSION['PHP_ERR_REPORTING_LEVEL'] = $lvl;
}
// does session var for php err level have a value?
if (empty($_SESSION['PHP_ERR_REPORTING_LEVEL']))
{
	// no, set default
	$_SESSION['PHP_ERR_REPORTING_LEVEL'] = 4;
}
// set the php err level variable
$php_error_reporting = $_SESSION['PHP_ERR_REPORTING_LEVEL'];

// Misc
define("TRACE_ENABLED",false);
define("PHP_ERR_REPORTING_LEVEL",4);
	# PHP error reporting. supported values are given below.
	# 0 - Turn off all error reporting
	# 1 - Running errors
	# 2 - Running errors + notices
	# 3 - All errors except notices and warnings
	# 4 - All errors except notices
	# 5 - All errors

// Security (SSL) during checkout and admin screens. Ok to set to false on test site
// if no SSL available, but should ALWAYS be set to true on LIVE site.
define("ENFORCE_SSL",false);

// email notifications
define("WEBSITE_NAME_LIVE", "");
define("ADMIN_EMAIL_LIVE", "info@????.com");

define("WEBSITE_NAME_TEST", "TEST Site");
define("ADMIN_EMAIL_TEST", "markandkitty@sagecomputerservices.com");

// Session values

// Querystring 
define("QS_DEBUG","debug");  				// set to 1 to turn on TRACE_ENABLED for a page

define("CRLF_STRING","\r\n");
define("NEWLINE_STRING","\n");
define("CSV_DELIMITER",",");
define("BR_STRING","<br />");
define("HARDENTER_STRING","\r");
define("SPACE_STRING"," ");
define("NBSP_STRING","&nbsp;");
define("AMP_STRING","&amp;");

// ********* SET LIVE SITE INFO HERE ********************************
//
$sHost="";
$sHost = $_SERVER['SERVER_NAME'];  			// HTTP_HOST
//echo $sHost;
$bLocal = FALSE;  							// Is this the live or test site?

//********************************************************
// IsTestSite
// Returns true if running on test site. To add your
// site to this list of test sites, include in the 
// $sHost list below
//********************************************************
function IsTestSite()
{
	global $sHost;
	
	//echo "host = $sHost";
	if (strpos($_SERVER['SERVER_NAME'],'minisage.com') !== false)
	{
		return true; 
	}
	
	return false;
}

//*************************************************************************
// IF TEST SITE, MODIFY RUNTIME VALUES TO REFLECT TEST SITE ENVIRONMENT
//*************************************************************************
if (IsTestSite())
{
	// TEST SITE SETTINGS
	mytrace("IS TEST SITE");
	
	// ensure display_errors is on
	ini_set('display_errors',1);
	
	# PHP error reporting. supported values are given below.
	# 0 - Turn off all error reporting
	# 1 - Running errors
	# 2 - Running errors + notices
	# 3 - All errors except notices and warnings
	# 4 - All errors except notices
	# 5 - All errors
	global $php_error_reporting;
	
	switch($php_error_reporting) 
	{
		case 0: error_reporting(0); break;
		case 1: error_reporting(E_ERROR | E_WARNING | E_PARSE); break;
		case 2: error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE); break;
		case 3: error_reporting(E_ALL ^ (E_NOTICE | E_WARNING)); break;
		case 4: error_reporting(E_ALL ^ E_NOTICE); break;
		case 5: error_reporting(E_ALL); break;
		default:
		   error_reporting(E_ALL);
	}
	
	$bLocal = TRUE;
	
	$frmMail ='mfindlay@speakeasy.org';

}
else // if (IsTestSite())
{
	mytrace("IS LIVE SITE");

	
	//ini_set('display_errors',1);
	//error_reporting(E_ALL);
} // if (IsTestSite())
	
?>