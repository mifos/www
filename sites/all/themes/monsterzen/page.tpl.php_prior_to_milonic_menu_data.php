<?php
// $Id: page-front.tpl.php,v 1.14.2.10 2009/11/05 14:26:26 johnalbin Exp $

/**
 * @file page-front.tpl.php
 *
 * Theme implementation to display a single Drupal page.
 *
 * Available variables:
 *
 * General utility variables:
 * - $base_path: The base URL path of the Drupal installation. At the very
 *   least, this will always default to /.
 * - $css: An array of CSS files for the current page.
 * - $directory: The directory the theme is located in, e.g. themes/garland or
 *   themes/garland/minelli.
 * - $is_front: TRUE if the current page is the front page. Used to toggle the mission statement.
 * - $logged_in: TRUE if the user is registered and signed in.
 * - $is_admin: TRUE if the user has permission to access administration pages.
 *
 * Page metadata:
 * - $language: (object) The language the site is being displayed in.
 *   $language->language contains its textual representation.
 *   $language->dir contains the language direction. It will either be 'ltr' or 'rtl'.
 * - $head_title: A modified version of the page title, for use in the TITLE tag.
 * - $head: Markup for the HEAD section (including meta tags, keyword tags, and
 *   so on).
 * - $styles: Style tags necessary to import all CSS files for the page.
 * - $scripts: Script tags necessary to load the JavaScript files and settings
 *   for the page.
 * - $body_classes: A set of CSS classes for the BODY tag. This contains flags
 *   indicating the current layout (multiple columns, single column), the current
 *   path, whether the user is logged in, and so on.
 * - $body_classes_array: An array of the body classes. This is easier to
 *   manipulate then the string in $body_classes.
 * - $node: Full node object. Contains data that may not be safe. This is only
 *   available if the current page is on the node's primary url.
 *
 * Site identity:
 * - $front_page: The URL of the front page. Use this instead of $base_path,
 *   when linking to the front page. This includes the language domain or prefix.
 * - $logo: The path to the logo image, as defined in theme configuration.
 * - $site_name: The name of the site, empty when display has been disabled
 *   in theme settings.
 * - $site_slogan: The slogan of the site, empty when display has been disabled
 *   in theme settings.
 * - $mission: The text of the site mission, empty when display has been disabled
 *   in theme settings.
 *
 * Navigation:
 * - $search_box: HTML to display the search box, empty if search has been disabled.
 * - $primary_links (array): An array containing primary navigation links for the
 *   site, if they have been configured.
 * - $secondary_links (array): An array containing secondary navigation links for
 *   the site, if they have been configured.
 *
 * Page content (in order of occurrance in the default page-front.tpl.php):
 * - $left: The HTML for the left sidebar.
 *
 * - $breadcrumb: The breadcrumb trail for the current page.
 * - $title: The page title, for use in the actual HTML content.
 * - $help: Dynamic help text, mostly for admin pages.
 * - $messages: HTML for status and error messages. Should be displayed prominently.
 * - $tabs: Tabs linking to any sub-pages beneath the current page (e.g., the view
 *   and edit tabs when displaying a node).
 *
 * - $content: The main content of the current Drupal page.
 *
 * - $right: The HTML for the right sidebar.
 *
 * Footer/closing data:
 * - $feed_icons: A string of all feed icons for the current page.
 * - $footer_message: The footer message as defined in the admin settings.
 * - $footer : The footer region.
 * - $closure: Final closing markup from any modules that have altered the page.
 *   This variable should always be output last, after all other dynamic content.
 *
 * @see template_preprocess()
 * @see template_preprocess_page()
 */
?>
<?php 
require_once ($directory . "/include/commonfunctions.php"); 
$my_current_section = GetCurrentSection();

// fetch the primary links menu items and get a count of the top level items
$arrPrimaryLinks = GetMenuArray("primary-links","1");
$nTopLevelMenuCount=0;
foreach ($arrPrimaryLinks as $i => $row) {
    if ($row['depth']=="1") $nTopLevelMenuCount++;
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php print $language->language; ?>" lang="<?php print $language->language; ?>" dir="<?php print $language->dir; ?>">
<head>
<script src="http://www.google.com/jsapi"></script>
<script>
<!--
google.load("jquery", "1.4.1");
//-->
</script>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<SCRIPT type=text/javascript>
<!--
//<![CDATA[
$(document).ready(function()
{
	if (typeof(CustomPageInit) == 'function')
	{
		CustomPageInit();
	}
}); // $(document).ready(function()
//]]>
//-->
</SCRIPT>
<title><?php print $head_title; ?></title>
<?php print $head; ?>
<?php /* print $styles; */?>
<!--
<link type="text/css" rel="stylesheet" media="all" href="/modules/jquerymenu/jquerymenu.css?E" />
<link type="text/css" rel="stylesheet" media="all" href="/modules/node/node.css?E" />
<link type="text/css" rel="stylesheet" media="all" href="/modules/system/defaults.css?E" />
<link type="text/css" rel="stylesheet" media="all" href="/modules/system/system.css?E" />
<link type="text/css" rel="stylesheet" media="all" href="/modules/system/system-menus.css?E" />
<link type="text/css" rel="stylesheet" media="all" href="/modules/user/user.css?E" />
<link type="text/css" rel="stylesheet" media="all" href="/sites/all/themes/zen/zen/html-elements.css?E" />
<link type="text/css" rel="stylesheet" media="all" href="/sites/all/themes/zen/zen/tabs.css?E" />
<link type="text/css" rel="stylesheet" media="all" href="/sites/all/themes/zen/zen/messages.css?E" />
<link type="text/css" rel="stylesheet" media="all" href="/sites/all/themes/zen/zen/block-editing.css?E" />
<link type="text/css" rel="stylesheet" media="all" href="/sites/all/themes/zen/zen/wireframes.css?E" />
<link type="text/css" rel="stylesheet" media="all" href="/sites/all/themes/monsterzen/mjftheme.css?E" />
<link type="text/css" rel="stylesheet" media="print" href="/sites/all/themes/monsterzen/print.css?E" />

-->
<link type="text/css" rel="stylesheet" media="all" href="<?php print $base_path; ?>modules/jquerymenu/jquerymenu.css" />
<!--<link type="text/css" rel="stylesheet" media="all" href="<?php print $base_path; ?>modules/node/node.css" />
<link type="text/css" rel="stylesheet" media="all" href="<?php print $base_path; ?>modules/system/defaults.css" />
<link type="text/css" rel="stylesheet" media="all" href="<?php print $base_path; ?>modules/system/system.css" />
<link type="text/css" rel="stylesheet" media="all" href="<?php print $base_path; ?>modules/user/user.css" />
<link type="text/css" rel="stylesheet" media="all" href="<?php print $directory; ?>/html-elements.css" />
<link type="text/css" rel="stylesheet" media="all" href="<?php print $base_path; ?>sites/all/themes/zen/zen/tabs.css" />
<link type="text/css" rel="stylesheet" media="all" href="<?php print $base_path; ?>sites/all/themes/zen/zen/messages.css" />
<link type="text/css" rel="stylesheet" media="all" href="<?php print $base_path; ?>sites/all/themes/zen/zen/block-editing.css" />
<link type="text/css" rel="stylesheet" media="all" href="<?php print $base_path; ?>sites/all/themes/zen/zen/wireframes.css" />-->
<link type="text/css" rel="stylesheet" media="all" href="<?php print $base_path; ?>modules/system/system-menus.css" />
<link type="text/css" rel="stylesheet" media="all" href="<?php print $directory; ?>/mjftheme.css" />
<?php print $scripts; ?>
<script language="JavaScript" type="text/javascript" src="<?php print $directory; ?>/include/dreamweaver.js"></script>
<script language="JavaScript" type="text/javascript" src="<?php print $directory; ?>/include/commonfunctions.js"></script>
<!-- Begin Milonic menu includes -->
<script language=JavaScript src="<?php print $directory; ?>/milonic/milonic_src.js" type=text/javascript></script>
<script	language=JavaScript type=text/javascript>
if(ns4)_d.write("<scr"+"ipt language=JavaScript src=" + "<?php print $directory; ?>/" + "milonic/mmenuns4.js><\/scr"+"ipt>");		
  else _d.write("<scr"+"ipt language=JavaScript src=" + "<?php print $directory; ?>/" + "milonic/mmenudom.js><\/scr"+"ipt>"); 
</script>
<script language=JavaScript src="<?php print $directory; ?>/milonic/menu_data.js<?php ?>" type=text/javascript></script>
<!-- End Milonic menu includes -->
<!------------------------------------------ BEGIN MILONIC MENU DATA ------------------------------------>
<script language="JavaScript" type="text/javascript">
<!--



//-->
</script>
<!-------------------------------------------- END MILONIC MENU DATA ------------------------------------>
</head>
<body onload="MM_preloadImages('<?php print $directory; ?>/myimages/common/logo_over.gif','<?php print $directory; ?>/myimages/common/contact_over.gif','<?php print $directory; ?>/myimages/common/logosmall_over.gif','<?php print $directory; ?>/myimages/common/donate_over.gif','<?php print $directory; ?>/myimages/common/facebook_over.gif','<?php print $directory; ?>/myimages/common/twitter_over.gif','<?php print $directory; ?>/myimages/common/flickr_over.gif','<?php print $directory; ?>/myimages/common/youtube_over.gif','<?php print $directory; ?>/myimages/common/share_over.gif','<?php print $directory; ?>/myimages/common/search_over.gif')">
<script language="JavaScript" type="text/JavaScript">
<!--
drawMenus(); // draw the milonic menus
//-->
</script>
<table width="100%" border="0" cellspacing="0" cellpadding="0" height="100%">
  <tr height="1%">
    <td align="left" valign="top"><!-- BEGIN TOP NAV -->
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td align="center" valign="top" class="topbarbg"><table width="900" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td width="900" align="left" valign="top" class="topcenter"><div>
                    <table width="900" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td width="417" align="left" valign="top"><a href="/" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('homelogoroll','','<?php print $directory; ?>/myimages/common/logo_over.gif',1)"><img src="<?php print $directory; ?>/myimages/common/logo.gif" alt="Grameen Technology Center" name="homelogoroll" width="417" height="89" border="0" id="homelogoroll" /></a></td>
                        <td width="483" align="right" valign="top"><a href="#" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('contactroll','','<?php print $directory; ?>/myimages/common/contact_over.gif',1)"><img src="<?php print $directory; ?>/myimages/common/contact.gif" alt="contact" name="contactroll" width="80" height="18" border="0" id="contactroll" /></a></td>
                      </tr>
                    </table>
                  </div>
                  <div id="mjf_topnavbar">
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td width="73%" align="left" valign="middle"><!-- BEGIN TOP NAV MENU -->
                          <table border="0" cellspacing="0" cellpadding="0" class="primary_menu">
                            <tr><?php 
							$x=0;
							$sLastClass="";
							
							foreach ($arrPrimaryLinks as $i => $row) {
    							// top level menu item?
								if ($row['depth']=="1") { 
									$x++;
									// last top level menu item?
									$sLastClass = ($x==$nTopLevelMenuCount) ? " last " : "";
									?>
                              <td align="left" valign="middle" class="links <?php print $sLastClass; ?>"><?php print $row['link_title'];?></td>
								<?php 
									}	// if ($row['depth']=="1")
								}	// foreach (arrPrimaryLinks as $i => $row)
								?>							
                            </tr>
                          </table><!-- END TOP NAV MENU --></td>
                        <td width="27%" align="left" valign="middle"><!--<?php print $search_box;?>-->
                          <div id="mysearchform">
                            <form action="/"  accept-charset="UTF-8" method="post" id="search-theme-form" name="monstersearch" >
                              <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                <tr>
                                  <td width="63%" align="left" valign="middle"><input type="text" maxlength="128" name="search_theme_form"  />
                                  </td>
                                  <td width="37%" align="left" valign="middle"><a href="#" onclick="ValidateSearchContent(); return false;" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('searchroll','','<?php print $directory; ?>/myimages/common/search_over.gif',1)"><img src="<?php print $directory; ?>/myimages/common/search.gif" alt="search" name="searchroll" width="57" height="22" border="0" id="searchroll" /></a></td>
                                </tr>
                              </table>
                              <input type="hidden" name="form_build_id" id="form-935cfdc93942765176569711b81eac91" value="form-935cfdc93942765176569711b81eac91"  />
                              <input type="hidden" name="form_token" id="edit-search-theme-form-form-token" value="d9ca547968aca8ee9f4a4a9167e8f94d"  />
                              <input type="hidden" name="form_id" id="edit-search-theme-form" value="search_theme_form"  />
                            </form>
                          </div></td>
                      </tr>
                    </table>
                  </div></td>
              </tr>
            </table></td>
        </tr>
      </table>
      <!-- END TOP NAV --></td>
  </tr>
  <tr height="98%">
    <td align="left" valign="top"><div id="page">
        <!-- BEGIN main content table -->
        <div id="maincontent">
          <table width="900" border="0" cellpadding="0" cellspacing="0">
            <tr>
              <td width="653" align="left" valign="top"><div class="intbodycontent"><img src="<?php print $directory; ?>/myimages/headers/header_about.jpg" /></div></td>
              <td width="5" align="left" valign="top"><div class="intbodyseparator"></div></td>
              <td width="242" rowspan="2" align="left" valign="top" class="greenvertical"><!-- BEGIN RIGHTNAV MENU -->
                <div class="rightcolintmenu"><?php print BuildRightNavMenu($my_current_section); ?></div>
				<div class="rightnavgap"></div>
                <!-- END RIGHTNAV MENU -->
				<div class="rightcolintcontent">
                <!-- BEGIN NEWS -->
                <div class="rightcolintnews">
                  <table width="100%" border="0" cellspacing="0" cellpadding="1">
                    <tr>
                      <td align="left" valign="top" class="rightcolnews">NEWS</td>
                    </tr>
                    <tr>
                      <td align="left" valign="top" class="rsscontent"><div class="rsscontent"><?php print $right; ?></div></td>
                    </tr>
                  </table>
                </div>
                <!-- END NEWS -->
                <!-- BEGIN FACTS -->
                <div class="rightcolintfacts">
                  <table width="100%" border="0" cellspacing="0" cellpadding="1">
                    <tr>
                      <td align="left" valign="top" class="rightcolnews">FACTS</td>
                    </tr>
                    <tr>
                      <td align="left" valign="top" class="factcontent"><?php require_once ($directory . "/include/facts.htm"); ?></td>
                    </tr>
                  </table>
                </div>
                <!-- END FACTS --></div></td>
            </tr>
            <tr>
              <td align="left" valign="top"><div class="intbreadcrumb"><?php print $breadcrumb; print $title;?></div>
                <?php print $messages; ?>
                <?php if (($tabs) && ($is_admin)): ?>
                <div class="tabs"><?php print $tabs; ?></div>
                <?php endif; ?>
                <?php if ($is_admin) print $help; ?>
                <div class="intbodycontent">
                  <h2 class="title"><?php print $title; ?></h2>
                  <?php print $content; ?>
                  <?php if (($left) && ($is_admin)): ?>
                  <div id="sidebar-left">
                    <div id="sidebar-left-inner" class="region region-left"> <?php print $left; ?> </div>
                  </div>
                  <!-- /#sidebar-left-inner, /#sidebar-left -->
                  <?php endif; ?>
                </div></td>
              <td align="left" valign="top" class="greenborderright">&nbsp;</td>
            </tr>
            <tr>
              <td align="left" valign="top">&nbsp;</td>
              <td align="left" valign="top">&nbsp;</td>
              <td align="left" valign="top"><div class="intpagesociallinks">
                  <table width="201" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="29" align="left" valign="top"><a href="#" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('facebook','','<?php print $directory; ?>/myimages/common/facebook_over.gif',1)"><img src="<?php print $directory; ?>/myimages/common/facebook.gif" alt="facebook" name="facebook" width="25" height="25" border="0" id="facebook" class="socialicon"/></a></td>
                      <td width="28" align="left" valign="top"><a href="#" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('twitter','','<?php print $directory; ?>/myimages/common/twitter_over.gif',1)"><img src="<?php print $directory; ?>/myimages/common/twitter.gif" alt="twitter" name="twitter" width="24" height="25" border="0" id="twitter" class="socialicon"/></a></td>
                      <td width="28" align="left" valign="top"><a href="#" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('flickr','','<?php print $directory; ?>/myimages/common/flickr_over.gif',1)"><img src="<?php print $directory; ?>/myimages/common/flickr.gif" alt="flickr" name="flickr" width="24" height="25" border="0" id="flickr" class="socialicon"/></a></td>
                      <td width="29" align="left" valign="top"><a href="#" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('youtube','','<?php print $directory; ?>/myimages/common/youtube_over.gif',1)"><img src="<?php print $directory; ?>/myimages/common/youtube.gif" alt="youtube" name="youtube" width="25" height="25" border="0" id="youtube" class="socialicon"/></a></td>
                      <td width="87" align="left" valign="top"><a href="#" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('shareit','','<?php print $directory; ?>/myimages/common/share_over.gif',1)"><img src="<?php print $directory; ?>/myimages/common/share.gif" alt="share it" name="shareit" width="74" height="25" border="0" id="shareit" class="sharethisicon"/></a></td>
                    </tr>
                  </table>
                </div></td>
            </tr>
          </table>
        </div>
        <!-- END main content table -->
      </div></td>
  </tr>
  <tr height="1%">
    <td align="left" valign="bottom"><!-- BEGIN BOTTOM NAV -->
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td align="center" valign="top" class="bottombarbg"><table width="900" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td width="900" align="left" valign="top" class="bottomcenter"><div id="dottedline_900"></div>
                  <div id="bottomnavlinks" align="center">
                    <table border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td align="left" valign="middle" nowrap="nowrap" class="infolink"><a href="mailto:info@techformicrofinance.com">info@techformicrofinance.com</a></td>
                        <td align="left" valign="middle" nowrap="nowrap"><?php if ($secondary_links) print theme('links', $secondary_links); ?></td>
                      </tr>
                    </table>
                  </div>
                  <div id="bottomnavpostlinks" align="center">
                    <table border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td align="left" valign="top" class="littlelogo"><a href="#" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('littlelogo','','<?php print $directory; ?>/myimages/common/logosmall_over.gif',1)"><img src="<?php print $directory; ?>/myimages/common/logosmall.gif" alt="Grameen Foundation" name="littlelogo" width="115" height="38" border="0" id="littlelogo" /></a></td>
                        <td align="left" valign="top" class="menubarsborder"><table width="100%" border="0" cellpadding="0" cellspacing="0">
                            <tr>
                              <td width="25%" align="left" valign="middle" nowrap="nowrap" class="supplemental_links"><a href="#"><strong>Grameen Foundation</strong></a> </td>
                              <td width="2%" align="center" valign="middle" nowrap="nowrap" class="supplemental_links_separator">|</td>
                              <td width="8%" align="left" valign="middle" nowrap="nowrap" class="supplemental_links"><a href="#"><strong>AppLab</strong></a></td>
                              <td width="2%" align="center" valign="middle" nowrap="nowrap" class="supplemental_links_separator">|</td>
                              <td width="6%" align="left" valign="middle" nowrap="nowrap" class="supplemental_links"><a href="#"><strong>Mifos</strong></a></td>
                              <td width="2%" align="center" valign="middle" nowrap="nowrap" class="supplemental_links_separator">|</td>
                              <td width="29%" align="left" valign="middle" nowrap="nowrap" class="supplemental_links"><a href="#"><strong>Progress Out of Poverty</strong></a> </td>
                              <td width="2%" align="center" valign="middle" nowrap="nowrap" class="supplemental_links_separator">|</td>
                              <td width="24%" align="left" valign="middle" nowrap="nowrap" class="supplemental_links"><a href="#"><strong>Village iPhone</strong></a> </td>
                            </tr>
                            <tr>
                              <td colspan="10" align="left" valign="middle" class="supplemental_tiny">Copyright &copy; 2010 Grameen Foundation <a href="#">PRIVACY POLICY</a></td>
                            </tr>
                          </table></td>
                        <td align="left" valign="middle"><table width="70" border="0" cellspacing="0" cellpadding="0">
                            <tr>
                              <td align="left" valign="middle" class="donatenowtd"><a href="#" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('donatenowroll','','<?php print $directory; ?>/myimages/common/donate_over.gif',1)"><img src="<?php print $directory; ?>/myimages/common/donate.gif" alt="donate now" name="donatenowroll" width="92" height="21" border="0" id="donatenowroll" /></a></td>
                              <td align="left" valign="middle" nowrap="nowrap" class="donatenowtext">Help support innovations that<br />
                                help end the cycle of poverty </td>
                            </tr>
                          </table></td>
                      </tr>
                    </table>
                  </div></td>
              </tr>
            </table></td>
        </tr>
      </table>
      <!-- END BOTTOM NAV --></td>
  </tr>
</table>
<script type="text/javascript">
 
  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-2521299-4']);
  _gaq.push(['_trackPageview']);
 
  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();
 
</script>
</body>
</html>
