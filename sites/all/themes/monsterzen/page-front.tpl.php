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
require_once ($directory . "/include/milonicfunctions.php"); 

mytrace("page-front.tpl.php: version 1.01");

mytrace("base_path = [$base_path], directory = [$directory]");

// fetch the primary links menu items and get a count of the top level items
//mfindlay 7/1/10 $arrPrimaryLinks = GetMenuArray("primary-links","1");
$arrPrimaryLinks = GetMenuArray("primary-links");
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
<!--<link type="text/css" rel="stylesheet" media="all" href="<?php print $base_path; ?>modules/jquerymenu/jquerymenu.css" />-->
<link type="text/css" rel="stylesheet" media="all" href="<?php print $base_path; ?>modules/system/system-menus.css" />
<link type="text/css" rel="stylesheet" media="all" href="<?php print $base_path; ?>sites/all/modules/lightbox2/css/lightbox.css" />
<link type="text/css" rel="stylesheet" media="all" href="<?php echo $base_path, $directory; ?>/mjftheme.css?<?php echo GenerateQSAppend(); ?>" />
<?php if (IsIE7()) { ?>
<link type="text/css" rel="stylesheet" media="all" href="<?php echo $base_path, $directory; ?>/mjftheme_IE7.css?<?php echo GenerateQSAppend(); ?>" />
<?php } ?>
<?php print $scripts; ?>
<script language="JavaScript" type="text/javascript" src="<?php echo $base_path, $directory; ?>/include/dreamweaver.js"></script>
<script language="JavaScript" type="text/javascript" src="<?php echo $base_path, $directory; ?>/include/commonfunctions.js"></script>
<!-- Begin Milonic menu includes -->
<script language=JavaScript src="<?php echo $base_path, $directory; ?>/milonic/milonic_src.js" type=text/javascript></script>
<script	language=JavaScript type=text/javascript>
if(ns4)_d.write("<scr"+"ipt language=JavaScript src=" + "<?php echo $base_path, $directory; ?>/" + "milonic/mmenuns4.js><\/scr"+"ipt>");		
  else _d.write("<scr"+"ipt language=JavaScript src=" + "<?php echo $base_path, $directory; ?>/" + "milonic/mmenudom.js><\/scr"+"ipt>"); 
</script>
<script language=JavaScript src="<?php echo $base_path, $directory; ?>/milonic/menu_data.js<?php ?>" type=text/javascript></script>
<!-- End Milonic menu includes -->
<!-- BEGIN MILONIC MENU DATA -->
<script language="JavaScript" type="text/javascript">
<!--
<?php print BuildMilonicMenuData($arrPrimaryLinks); ?>

function MM_findObj(n, d) { //v4.01
  var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
    d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
  if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
  for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
  if(!x && d.getElementById) x=d.getElementById(n); return x;
}

function MM_preloadImages() { //v3.0
  var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();
    var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i<a.length; i++)
    if (a[i].indexOf("#")!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}
}

function MM_swapImgRestore() { //v3.0
  var i,x,a=document.MM_sr; for(i=0;a&&i<a.length&&(x=a[i])&&x.oSrc;i++) x.src=x.oSrc;
}

function MM_swapImage() { //v3.0
  var i,j=0,x,a=MM_swapImage.arguments; document.MM_sr=new Array; for(i=0;i<(a.length-2);i+=3)
   if ((x=MM_findObj(a[i]))!=null){document.MM_sr[j++]=x; if(!x.oSrc) x.oSrc=x.src; x.src=a[i+2];}
}
//-->
</script>
<!-- END MILONIC MENU DATA -->
</head>
<body onload="MM_preloadImages('<?php echo $base_path, $directory; ?>/myimages/common/logo_over.gif','<?php echo $base_path, $directory; ?>/myimages/common/contact_over.gif','<?php echo $base_path, $directory; ?>/myimages/common/logosmall_over.gif','<?php echo $base_path, $directory; ?>/myimages/common/donate_over.gif','<?php echo $base_path, $directory; ?>/myimages/common/facebook_over.gif','<?php echo $base_path, $directory; ?>/myimages/common/twitter_over.gif','<?php echo $base_path, $directory; ?>/myimages/common/flickr_over.gif','<?php echo $base_path, $directory; ?>/myimages/common/youtube_over.gif','<?php echo $base_path, $directory; ?>/myimages/common/share_over.gif','<?php echo $base_path, $directory; ?>/myimages/common/search_over.gif','<?php echo $base_path, $directory; ?>/myimages/common/grameenlogo_over.gif','<?php echo $base_path, $directory; ?>/myimages/home/img_gettherefaster.jpg','<?php echo $base_path, $directory; ?>/myimages/home/img_oneview.jpg','<?php echo $base_path, $directory; ?>/myimages/home/img_socialperformance.jpg','<?php echo $base_path, $directory; ?>/myimages/home/img_cloudplatform.jpg','<?php echo $base_path, $directory; ?>/myimages/home/img_successstories.jpg')">
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
                        <td width="417" align="left" valign="top"><a onfocus="this.blur()" href="/" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('homelogoroll','','<?php echo $base_path, $directory; ?>/myimages/common/logo_over.gif',1)"><img src="<?php echo $base_path, $directory; ?>/myimages/common/logo.gif" alt="Mifos. A Grameen Foundation Initiative" name="homelogoroll" width="417" height="113" border="0" id="homelogoroll" /></a></td>
                        <td width="483" align="right" valign="bottom"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                            <tr>
                              <td align="right" valign="top"><a href="/?q=about/contact-us" onfocus="this.blur()" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('contactroll','','<?php echo $base_path, $directory; ?>/myimages/common/contact_over.gif',1)"><img src="<?php echo $base_path, $directory; ?>/myimages/common/contact.gif" alt="contact" name="contactroll" width="85" height="18" border="0" id="contactroll" /></a></td>
                            </tr>
                            <tr>
                              <td align="right" valign="top"><img src="<?php echo $base_path, $directory; ?>/myimages/common/tech_that_accel.gif" alt="Technology that Accelerates Microfinance" width="483" height="28" /></td>
                            </tr>
                          </table></td>
                      </tr>
                    </table>
                  </div>
                  <div id="mjf_topnavbar">
                    <table width="870" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td width="643" align="left" valign="middle"><!-- BEGIN TOP NAV MENU -->
                          <table border="0" cellspacing="0" cellpadding="0" class="primary_menu">
                            <tr>
                              <?php 
							$x=0;
							$sLastClass="";
							$sFirstClass="";
							
							foreach ($arrPrimaryLinks as $i => $row) {
    							// top level menu item?
								if ($row['depth']=="1") { 
									$x++;
									// first top level menu item?
									$sFirstClass = ($x==1) ? " first " : "";
									// last top level menu item?
									$sLastClass = ($x==$nTopLevelMenuCount) ? " last " : "";
									
									// is this row within the current section?
									$sSelected = (strcmp(strtolower($my_current_section),strtolower($row['link_title']))==0) ? " toplinkselected " : "";
									?>
                              <td align="left" valign="middle" nowrap="nowrap" class="links <?php print $sSelected . $sFirstClass . $sLastClass; ?>"><?php print BuildTopNavRow($row,$sSelected); ?> </td>
                              <?php 
									}	// if ($row['depth']=="1")
								}	// foreach (arrPrimaryLinks as $i => $row)
								?>
                              <!-- special link for mifos.org -->
                              <td align="left" valign="middle" nowrap="nowrap" class="mifoslink"><a href="http://www.mifos.org/" target="_blank">mifos.org</a></td>
                            </tr>
                          </table>
                          <!-- END TOP NAV MENU --></td>
                        <td width="228" align="left" valign="middle"><!--<?php print $search_box;?>-->
                          <div id="mysearchform">
                            <form action="/?q=search/node/"  accept-charset="UTF-8" method="post" id="search-theme-form" name="monstersearch" >
                              <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                <tr>
                                  <td width="63%" align="left" valign="top"><input type="text" maxlength="128" name="search_theme_form"  />
                                  </td>
                                  <td width="37%" align="right" valign="top"><a href="#" onKeyDown="if(event.keyCode==13) ValidateSearchContent(); return false;" onclick="ValidateSearchContent(); return false;" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('searchroll','','<?php echo $base_path, $directory; ?>/myimages/common/search_over.gif',1)"><img src="<?php echo $base_path, $directory; ?>/myimages/common/search.gif" alt="search" name="searchroll" width="57" height="20" border="0" id="searchroll" /></a></td>
                                </tr>
                              </table>
                              <!--<input type="hidden" name="form_build_id" id="form-ef5f2a246b09bf202e7c653b6b1d3d90" value="form-ef5f2a246b09bf202e7c653b6b1d3d90"  />
							  <input type="hidden" name="form_token" id="edit-search-theme-form-form-token" value="e0344bb5364147cc2492b55206086791"  />-->
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
        <!-- BEGIN hero table -->
        <div id="hero">
          <table width="900" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td align="left" valign="top"><img src="<?php echo $base_path, $directory; ?>/myimages/home/img_default.jpg" width="900" height="350" border="0" id="roll_default" usemap="#Map" /></td>
            </tr>
          </table>
        </div>
        <!-- END hero table -->
        <div id="dottedline_900"></div>
        <!-- BEGIN main content table -->
        <div id="maincontent">
          <table width="900" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td width="635" align="left" valign="top"><div class="mainbodycontent">
                  <?php if (($tabs) && ($is_admin)): ?>
                  <div class="tabs"><?php print $tabs; ?></div>
                  <?php endif; ?>
                  <?php print $content; ?>
                  <?php if (($left) && ($is_admin)): ?>
                  <div id="sidebar-left">
                    <div id="sidebar-left-inner" class="region region-left"> <?php print $left; ?> </div>
                  </div>
                  <!-- /#sidebar-left-inner, /#sidebar-left -->
                  <?php endif; ?>
                </div></td>
              <td width="22" align="left" valign="top"><div class="mainbodyseparator"></div></td>
              <td width="243" align="left" valign="top" class="rightcolbackground"><div class="rightcolsocialcontent">
                  <table width="201" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="29" align="left" valign="top"><a href="http://www.facebook.com/group.php?gid=46186150417" target="_blank" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('facebook','','<?php echo $base_path, $directory; ?>/myimages/common/facebook_over.gif',1)"><img src="<?php echo $base_path, $directory; ?>/myimages/common/facebook.gif" alt="facebook" name="facebook" width="25" height="25" border="0" id="facebook" class="socialicon"/></a></td>
                      <td width="28" align="left" valign="top"><a href="<?php print TWITTER_LINK; ?>" target="_blank" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('twitter','','<?php echo $base_path, $directory; ?>/myimages/common/twitter_over.gif',1)"><img src="<?php echo $base_path, $directory; ?>/myimages/common/twitter.gif" alt="twitter" name="twitter" width="24" height="25" border="0" id="twitter" class="socialicon"/></a></td>
                      <td width="28" align="left" valign="top"><a href="<?php print FLICKR_LINK; ?>" target="_blank" onmouseover="MM_swapImage('flickr','','<?php echo $base_path, $directory; ?>/myimages/common/flickr_over.gif',1)" onmouseout="MM_swapImgRestore()"><img src="<?php echo $base_path, $directory; ?>/myimages/common/flickr.gif" alt="flickr" name="flickr" width="24" height="25" border="0" id="flickr" class="socialicon"/></a></td>
                      <td width="29" align="left" valign="top"><a href="<?php print YOUTUBE_LINK; ?>" target="_blank" onmouseover="MM_swapImage('youtube','','<?php echo $base_path, $directory; ?>/myimages/common/youtube_over.gif',1)" onmouseout="MM_swapImgRestore()"><img src="<?php echo $base_path, $directory; ?>/myimages/common/youtube.gif" alt="youtube" name="youtube" width="25" height="25" border="0" id="youtube" class="socialicon"/></a></td>
                      <script type="text/javascript">var addthis_config = {"data_track_clickback":true};</script>
                      <td width="87" align="left" valign="top"><a target="_blank" href="http://www.addthis.com/bookmark.php?v=250&amp;username=mifos" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('shareit','','<?php echo $base_path, $directory; ?>/myimages/common/share_over.gif',1); return addthis_open(this, '', '[URL]', '[TITLE]')"><img src="<?php echo $base_path, $directory; ?>/myimages/common/share.gif" alt="share it" name="shareit" width="74" height="25" border="0" id="shareit" class="sharethisicon"/></a></td>
                      <script type="text/javascript" src="http://s7.addthis.com/js/250/addthis_widget.js#username=mifos"></script>
                    </tr>
                  </table>
                </div>
                <div class="rightcolcontent"> <?php print $right; ?> </div></td>
            </tr>
            <tr>
              <td align="left" valign="top">&nbsp;</td>
              <td align="left" valign="top">&nbsp;</td>
              <td align="left" valign="top" class="rightcolhomebackground">&nbsp;</td>
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
                  <div id="bottomnavlinks" align="left">
                    <table width="900" border="0" cellpadding="0" cellspacing="0">
                      <tr>
                        <td align="center" valign="middle" class="infolink"><a href="mailto:<?php print EMAIL_LINK;?>"><strong><?php print EMAIL_LINK;?></strong></a>&nbsp;&nbsp;&nbsp;<?php if ($secondary_links) print theme('links', $secondary_links); ?></td>
                      </tr>
                    </table>
                  </div>
                  <div id="bottomnavpostlinks" align="center">
                    <table border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td align="left" valign="top" class="littlelogo"><a href="http://www.grameenfoundation.org/" target="_blank" onmouseover="MM_swapImage('littlelogo','','<?php echo $base_path, $directory; ?>/myimages/common/logosmall_over.gif',1)" onmouseout="MM_swapImgRestore()"><img src="<?php echo $base_path, $directory; ?>/myimages/common/logosmall.gif" alt="Grameen Foundation" name="littlelogo" width="115" height="38" border="0" id="littlelogo" /></a></td>
                        <td align="left" valign="middle" class="menubarsborder"><table width="100%" border="0" cellpadding="0" cellspacing="0">
                            <tr>
                              <td width="8%" align="left" valign="middle" nowrap="nowrap" class="supplemental_links"><a href="http://www.applab.org" target="_blank"><strong>AppLab</strong></a></td>
                              <td width="2%" align="center" valign="middle" nowrap="nowrap" class="supplemental_links_separator">|</td>
                              <td width="6%" align="left" valign="middle" nowrap="nowrap" class="supplemental_links"><a href="http://www.mifos.com" target="_blank"><strong>Mifos</strong></a></td>
                              <td width="2%" align="center" valign="middle" nowrap="nowrap" class="supplemental_links_separator">|</td>
                              <td width="28%" align="left" valign="middle" nowrap="nowrap" class="supplemental_links"><a href="http://www.progressoutofpoverty.org" target="_blank"><strong>Progress Out of Poverty</strong></a> </td>
                              <td width="2%" align="center" valign="middle" nowrap="nowrap" class="supplemental_links_separator">|</td>
                              <td width="16%" align="left" valign="middle" nowrap="nowrap" class="supplemental_links"><a href="http://www.villagephonedirect.org" target="_blank"><strong>Village Phone</strong></a> </td>
                              <td width="2%" align="left" valign="middle" nowrap="nowrap" class="supplemental_links_separator">|</td>
                              <td width="34%" align="left" valign="middle" nowrap="nowrap" class="supplemental_links"><a href="http://www.bankerswithoutborders.com" target="_blank"><strong>Bankers Without Borders</strong></a></td>
                            </tr>
                            <tr>
                              <td colspan="10" align="left" valign="middle" class="supplemental_tiny">Copyright &copy; 2010 Grameen Foundation <a href="http://www.grameenfoundation.org/privacy-policy/" target="_blank">PRIVACY POLICY</a></td>
                            </tr>
                          </table></td>
                        <td align="left" valign="middle"><table width="70" border="0" cellspacing="0" cellpadding="0">
                            <tr>
                              <td align="left" valign="middle" class="donatenowtd"><a href="<?php print DONATE_NOW_LINK; ?>" target="_blank" onmouseover="MM_swapImage('donatenowroll','','<?php echo $base_path, $directory; ?>/myimages/common/donate_over.gif',1)" onmouseout="MM_swapImgRestore()"><img src="<?php echo $base_path, $directory; ?>/myimages/common/donate.gif" alt="donate now" name="donatenowroll" width="92" height="21" border="0" id="donatenowroll" /></a></td>
                              <td align="left" valign="middle" nowrap="nowrap" class="donatenowtext">Help support innovations that<br />
                                help end the cycle of poverty </td>
                            </tr>
                          </table></td>
                      </tr>
                    </table>
                    <div class="bottomaddress">
                      <table border="0" cellspacing="0" cellpadding="1">
                        <tr>
                          <td align="center" valign="top" nowrap="nowrap">Grameen Technology Center &bull; 2101 4th Ave, Suite 1030 &bull; Seattle, WA 98121 &bull; Phone: +1 206-325-6690</td>
                        </tr>
                      </table>
                    </div>
                  </div></td>
              </tr>
            </table></td>
        </tr>
      </table>
      <!-- END BOTTOM NAV --></td>
  </tr>
</table>
<map name="Map" id="Map">
  <area shape="rect" coords="651,8,893,77" href="<?php if (IsTestSite()) print "/?q=";?>products/business-approach/how-mifos-accelerates-your-mfi" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('roll_default','','<?php echo $base_path, $directory; ?>/myimages/home/img_gettherefaster.jpg',1)" />
  <area shape="rect" coords="651,76,895,143" href="<?php if (IsTestSite()) print "/?q=";?>products/business-approach/insight-across-your-business" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('roll_default','','<?php echo $base_path, $directory; ?>/myimages/home/img_oneview.jpg',1)" />
  <area shape="rect" coords="652,141,893,212" href="<?php if (IsTestSite()) print "/?q=";?>products/business-approach/measurable-social-performance" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('roll_default','','<?php echo $base_path, $directory; ?>/myimages/home/img_socialperformance.jpg',1)" />
  <area shape="rect" coords="651,212,892,277" href="<?php if (IsTestSite()) print "/?q=";?>products/business-approach/cloud-computing-advantage" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('roll_default','','<?php echo $base_path, $directory; ?>/myimages/home/img_cloudplatform.jpg',1)" />
  <area shape="rect" coords="652,277,892,344" href="<?php if (IsTestSite()) print "/?q=";?>customers/success-stories" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('roll_default','','<?php echo $base_path, $directory; ?>/myimages/home/img_successstories.jpg',1)" />
</map>
<script type="text/javascript">
 
  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-2521299-4']);
  _gaq.push(['_trackPageview']);
 
  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();
 
</script></body>
</html>
