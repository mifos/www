<?php
// $Id: author_pane.inc,v 1.1.2.2 2009/05/11 15:21:59 michellec Exp $

/**
 * @file
 *   This file provides a CTools content type containing the author pane.
 */

/**
 * Callback function to supply a list of content types.
 */
function author_pane_author_pane_ctools_content_types() {
  return array(
    'single' => TRUE,
    'title' => t('Author Pane'),
    'icon' => 'icon_user.png',
    'description' => t('Author related variables gathered from helper modules.'),
    'required context' => new ctools_context_required(t('User'), 'user'),
    'category' => t('Advanced Profile Kit'),
    'defaults' => array('image_path' => '', 'template_file' => 'author-pane'),
  );
}

/**
 * Output function for the 'author pane' content type.
 */
function author_pane_author_pane_content_type_render($subtype, $conf, $panel_args, $context) {
  $account = isset($context->data) ? drupal_clone($context->data) : NULL;
  $block = new stdClass();

  if ($account) {
    $block->title = check_plain($account->name);
    $block->content = theme('author_pane', $account, $conf['image_path'], $conf['template_file']);
  }
  else {
    $block->content = "User information not available";
  }

  return $block;
}

/**
 * Returns an edit form for the custom type.
 */
function author_pane_author_pane_content_type_edit_form(&$form, &$form_state) {
  $conf = $form_state['conf'];

  $form['image_path'] = array(
    '#type' => 'textfield',
    '#title' => t('Image directory'),
    '#size' => 50,
    '#description' => t('Full path to image directory, not including leading or trailing slashes. Use [theme_path] to substitute the active theme\'s path. If left blank the images in the module directory will be used.'),
    '#default_value' => $conf['image_path'],
    '#prefix' => '<div class="clear-block no-float">',
    '#suffix' => '</div>',
  );

  $form['template_file'] = array(
    '#type' => 'textfield',
    '#title' => t('Template file'),
    '#size' => 50,
    '#description' => t('Template file to use for the author pane.'),
    '#default_value' => $conf['template_file'],
    '#prefix' => '<div class="clear-block no-float">',
    '#suffix' => '</div>',
  );
}

function author_pane_author_pane_content_type_edit_form_submit(&$form, &$form_state) {
  // Copy everything from our defaults.
  foreach (array_keys($form_state['plugin']['defaults']) as $key) {
    $form_state['conf'][$key] = $form_state['values'][$key];
  }
}

function author_pane_author_pane_content_type_admin_title($subtype, $conf, $context) {
  return t('"@s" author pane', array('@s' => $context->identifier));
}


