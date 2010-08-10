<?php
// $Id: linkit.admin.inc,v 1.3 2010/06/25 10:29:08 anon Exp $

/**
 * @file
 * Admin page callbacks for the Linkit module.
 */

/**
 * Form configure the Linikt.
 */
function linkit_admin_settings() {
  
  $settings = variable_get('linkit_node', array());

  $form['node'] = array(
    '#type' => 'fieldset',
    '#title' => t('Node settings'),
    '#collapsible' => TRUE,
    '#collapsed' => FALSE,
    '#description' => t('Linkit node settings'),
  );

  $form['node']['linkit_node'] = array(
    '#title' => t('Information to display in the autocomplete field'),
    '#type' => 'checkboxes',
    '#options' => array(
      'nid' => t('Display node id (nid)'),
      'content_type' => t('Display node content type'),
      'status' => t('Display node published status'),
      'language' => t('Display node language'),
      'created' => t('Display node created time'),
      'changed' => t('Display node changed time'),
      'show_unpublished' => t('Show unpublished nodes in the result'),
    ),
    '#default_value' => $settings,
  );

  $form['submit'] = array('#type' => 'submit', '#value' => t('Save'));

  return $form;
}


function linkit_admin_settings_submit($form, &$form_state) {
  foreach($form_state['values'] AS $key => $value) {
    if(strpos($key, 'linkit_') !== FALSE) {
      variable_set($key, $value);
    }
  }
  drupal_set_message(t('Settings has been saved.'));
}