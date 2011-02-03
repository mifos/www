<?php
// $Id: fasttoggle.author-pane.inc,v 1.1.2.2 2009/03/04 23:19:09 michellec Exp $

/**
 * @file
 *   Provides a preprocess function on behalf of the fasttoggle module.
 */

/**
 * Implementation of hook_preprocess_author_pane().
 */
function fasttoggle_preprocess_author_pane(&$variables) {
  // The full user object for the author
  global $user;
  $account_id = $variables['account']->uid;

  if ($account_id != 0 && $account_id != $user->uid) {
    $account = $variables['account'];
    $variables['fasttoggle_block_author'] = theme('links', fasttoggle_link('user', $account), array('class' => 'links inline'));
  }
}