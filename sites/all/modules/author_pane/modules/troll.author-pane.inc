<?php
// $Id: troll.author-pane.inc,v 1.1.2.1 2009/03/04 23:19:31 michellec Exp $

/**
 * @file
 *   Provides a preprocess function on behalf of the troll module.
 */

/**
 * Implementation of hook_preprocess_author_pane().
 */
function troll_preprocess_author_pane(&$variables) {
  global $user;
  $account_id = $variables['account']->uid;
  
  if ($account_id != 0 && $account_id != $user->uid && user_access('administer troll')) {
    $variables['troll_ban_author'] = l(t('Ban IP'), 'admin/settings/troll/ip_ban/user/'. $account_id);
  }
}