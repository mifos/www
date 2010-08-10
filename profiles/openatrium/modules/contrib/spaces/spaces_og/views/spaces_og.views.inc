<?php
// $Id: spaces_og.views.inc,v 1.1.2.1 2010/01/12 12:33:32 yhahn Exp $

/**
 * Implementation of hook_views_plugins().
 */
function spaces_og_views_plugins() {
  return array(
    'argument validator' => array(
      'useringroups' => array(
        'title' => t("User in current user's groups"),
        'handler' => 'spaces_og_plugin_argument_validate_useringroups',
        'path' => drupal_get_path('module', 'spaces_og') . '/views',
      ),
    ),
  );
}
