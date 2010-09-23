<?php
// $Id: content_lock.admin.inc,v 1.2 2010/08/30 01:22:28 ohnobinki Exp $

# Copyright (c) 2010 Impressive.media
# Author: Eugen Mayer

/**
 * Providing an administration interface for content_lock.
 */
function content_lock_admin_settings() {
  $form['content_lock_unload_js'] = array(
      '#type' => 'checkbox',
      '#title' => t('Us javascript to detect leaving the node form'),
      '#description' => t('If you disable this, there will be no messages like "Do you really want to leave this node and lose all changes. Lock gets removed then"'),
      '#default_value' => variable_get('content_lock_unload_js', true),
  );
  
  $form['content_lock_admin_verbose'] = array(
      '#type' => 'checkbox',
      '#title' => t('Show lock / unlock messages'),
      '#description' => t('If you disable this option, no messages about unlock / lock of nodes are shown to the user anymore'),
      '#default_value' => variable_get('content_lock_admin_verbose', true),
  );

  $form['content_lock_admin_cancelbutton'] = array(
      '#type' => 'checkbox',
      '#title' => t('Add cancel button'),
      '#description' => t('Should a cancel button be added to the node / user / comment form. This way a user can properly cancel the transaction'),
      '#default_value' => variable_get('content_lock_admin_cancelbutton', true),
  );

  $form['content_lock_allowed_node_types'] = array(
    '#type' => 'checkboxes',
    '#title' => t('Lockable content types'),
    '#description' => t('Apply lock to the selected content types. Leave blank for all.'),
    '#options' => node_get_types('names'),
    '#default_value' => variable_get('content_lock_allowed_node_types', array()),
  );

  $formats = filter_formats();
  $format_options = array();
  foreach ($formats as $id => $format) {
    $format_options[$id] = $format->name;
  }

  $form['content_lock_allowed_formats'] = array(
    '#type' => 'checkboxes',
    '#title' => t('Lockable text formats'),
    '#description' => t('Apply lock to selected formats only. Leave blank for all.'),
    '#options' => $format_options,
    '#default_value' => variable_get('content_lock_allowed_formats', array()),
  );

  return system_settings_form($form);
}
