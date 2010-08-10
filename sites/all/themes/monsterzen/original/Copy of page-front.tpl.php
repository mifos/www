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
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php print $language->language; ?>" lang="<?php print $language->language; ?>" dir="<?php print $language->dir; ?>">
<head>
<script src="http://www.google.com/jsapi"></script>
<script>
<!--
google.load("jquery", "1.4.1");
//-->
</script>
<title><?php print $head_title; ?></title>
<?php print $head; ?><?php print $styles; ?><?php print $scripts; ?>
</head>
<body class="<?php print $body_classes; ?>" onload="MM_preloadImages('<?php print $directory; ?>/myimages/common/logo_over.gif','myimages/common/contact_over.gif')">
<div id="page">
<div id="page-inner">
  <?php if ($logo): ?>
  <div id="logo">
    <table width="900" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="417" align="left" valign="top"><a title="<?php print t('Home'); ?>" href="<?php print $front_page; ?>" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('homelogoroll','','<?php print $directory; ?>/myimages/common/logo_over.gif',1)"><img src="<?php print $directory; ?>/myimages/common/logo.gif" alt="<?php print t('Home'); ?>" width="417" height="89" border="0" id="homelogoroll" /></a></td>
        <td width="483" align="right" valign="top"><a href="#" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('contactroll','','<?php print $directory; ?>/myimages/common/contact_over.gif',1)"><img src="<?php print $directory; ?>/myimages/common/contact.gif" alt="contact us" width="80" height="18" border="0" id="contactroll" /></a></td>
      </tr>
    </table>
  </div>
  <?php endif; ?>
  <?php if ($primary_links): ?>
  <div id="mjf_topnavbar" > <?php print theme('links', $primary_links); ?> </div>
  <!-- /#primary -->
  <?php endif; ?>
  <div id="content-area"> <?php print $content; ?> </div>
</div>
</body>
</html>
