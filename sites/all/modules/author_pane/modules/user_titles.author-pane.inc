<?php
// $Id: user_titles.author-pane.inc,v 1.1.2.3 2009/02/10 05:00:44 michellec Exp $

/**
 * @file
 *   Provides a preprocess function on behalf of the user titles module.
 */

/**
 * Implementation of hook_preprocess_author_pane().
 */
function user_titles_preprocess_author_pane(&$variables) {
  $account = $variables['account'];

  if ($account->uid != 0) {
    $variables['user_title'] = user_titles_get_user_title($account);
    $variables['user_title_image'] = user_titles_get_user_image($account);
  }
}
