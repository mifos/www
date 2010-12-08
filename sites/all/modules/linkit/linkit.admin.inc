<?php
// $Id: linkit.admin.inc,v 1.3.2.4 2010/10/24 12:58:40 anon Exp $

/**
 * @file
 * Admin page callbacks for the Linkit module.
 */

function linkit_admin_settings() {
  
  $settings = variable_get('linkit_node', array('display_settings' => array(), 'content_types' => array()));

  $node_display_settings = array(
    'nid' => t('Display node id (nid)'),
    'content_type' => t('Display node content type'),
    'status' => t('Display node published status'),
    'language' => t('Display node language'),
    'created' => t('Display node created time'),
    'changed' => t('Display node changed time'),
    'show_unpublished' => t('Show unpublished nodes in the result'),
  );

  if(module_exists('book')) {
    $node_display_settings += array('show_books' => t('Display the book a node belong to'));
  }
  
  $form['linkit_node'] = array(
    '#type' => 'fieldset',
    '#title' => t('Node settings'),
    '#collapsible' => TRUE,
    '#collapsed' => FALSE,
    '#description' => t('Linkit node settings'),
    '#tree' => TRUE,
  );

  $form['linkit_node']['display_settings']  = array(
    '#title' => t('Information to display in the autocomplete field'),
    '#type' => 'checkboxes',
    '#options' => $node_display_settings,
    '#default_value' => $settings['display_settings'],
  );

  $form['linkit_node']['content_types'] = array(
    '#title' => t('Include this content types in the search result'),
    '#type' => 'checkboxes',
    '#options' => node_get_types('names'),
    '#default_value' => $settings['content_types'], 
    '#description' => t('If none is checked, all content types will be present in the search result.'),
  );

  return system_settings_form($form);
}