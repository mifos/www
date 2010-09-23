<?php
// $Id: node_widget.form.inc,v 1.17 2010/03/31 19:06:22 antoniodemarco Exp $

/**
 * Implementation of hook_form_alter()
 */
function node_widget_form_alter(&$form, &$form_state, $form_id) {

  // Populate main #field_info array with node widget fields
  foreach (node_widget_get_fields($form) as $field) {
    $node_widget = new node_widget($field, $form, $form_state);
    $settings = $node_widget->get_widget_settings();
    if ($type = $node_widget->get_referenced_type()) {
      $info = content_types($type);
      foreach ($info['fields'] as $field_name => $field_info) {
        if (isset($settings[$field_name]) && $settings[$field_name]) {
          $form['#field_info'][$field_name] = $field_info;
        }
      }
    }
  }
}

/**
 * Implementation of hook_form_content_field_edit_form_alter()
 */
function node_widget_form_content_field_edit_form_alter(&$form, &$form_state) {
  if ($form['widget_module']['#value'] == 'node_widget') {
    unset($form['field']['advanced']);
  }
}

/**
 * Implementation of #after_build callback.
 * Used to turn off validation to node widget form elements.
 *
 * @see: node_widget_widget()
 */
function node_widget_node_form_after_build(&$form, &$form_state) {

  foreach (node_widget_get_fields($form) as $field) {
    $node_widget = new node_widget($field, $form, $form_state);
    foreach ($node_widget->get_children() as $delta) {
      $node_widget->build($delta, $form);
    }
  }
  $form['#cache'] = TRUE;
  return $form;
}

/**
 * Implementation of node form #submit callback.
 */
function node_widget_node_form_submit(&$form, &$form_state) {

  if (in_array('node_form_submit', $form_state['clicked_button']['#submit'])) {
    foreach (node_widget_get_fields($form) as $field_name => $field) {
      $node_widget = new node_widget($field, $form, $form_state);
      foreach ($node_widget->get_children() as $delta) {
        if ($nid = $node_widget->submit($delta)) {
          $form_state['values'][$field_name][$delta]['nid'] = $nid;
        }
      }
    }
  }
}

/**
 * Implementation of node form #validate callback.
 */
function node_widget_node_form_validate(&$form, &$form_state) {

  foreach (node_widget_get_fields($form) as $field) {
    $node_widget = new node_widget($field, $form, $form_state);
    foreach ($node_widget->get_children() as $delta) {
      $node_widget->validate($delta);
    }
  }
}

/**
 * Implementation of hook_forms()
 */
function node_widget_forms() {

  $forms = array();
  if ($types = node_get_types()) {
    foreach (array_keys($types) as $type) {
      $forms[$type .'_node_widget_form']['callback'] = 'node_widget_form';
    }
  }
  return $forms;
}

/**
 * Generate the node add/edit form array.
 */
function node_widget_form($form_state, $node, $element = NULL) {

  global $user;
  $form_id = $node->type .'_node_widget_form';

  // Handle node object
  if (isset($form_state['node'])) {
    $node = $form_state['node'] + (array)$node;
  }
  if (!$node->nid) {
    module_load_include('inc', 'node', 'node.pages');
    node_object_prepare($node);
  }
  $node->language = language_default('language');

  // Add necessary information to $form array.
  $form['form_id'] = array('#type' => 'hidden', '#value' => $form_id, '#id' => form_clean_id("edit-$form_id"),);
  $form['#type'] = 'markup';
  $form['#node'] = $node;
  $form['#theme'][] = $form_id;
  $form['#theme'][] = 'node_widget_form';

  // Add basic node information.
  foreach (array('nid', 'vid', 'uid', 'created', 'type', 'language', 'changed') as $key) {
    $form[$key] = array('#type' => 'hidden', '#value' => isset($node->$key) ? $node->$key : NULL,);
  }

  // TODO: Add theme functions for these fields
  if ($node->nid) {
    $form['node_widget_link'] = array(
      '#type' => 'markup',
      '#value' => l(t('View'), 'node/'. $node->nid, array('attributes' => array('target' => '_blank'))),
      '#prefix' => '<div class="node-widget-link">',
      '#suffix' => '</div>',
      '#weight' => -100,
    );
  }
  $remove_label = ($node->nid) ? t('Delete') : t('Skip');
  $form['remove'] = array(
    '#type' => 'checkbox',
    '#title' => $remove_label,
    '#prefix' => '<div class="node-widget-remove">',
    '#suffix' => '</div>',
    '#default_value' => FALSE,
    '#weight' => -99,
  );
  $form['#cache'] = TRUE;

  // Run hook_node_widget_form_alter allowing modules
  // to add their own fields (i.e. CCK, Taxonomy, etc...)
  $data = &$form;
  $data['__drupal_alter_by_ref'] = array(&$form_state);
  drupal_alter('node_widget_form', $data, $form_id);
  return $form;
}

/**
 * Return array of fields using Node Widget
 *
 * @param $form
 *    Form array
 * @return
 *    Array of fields
 */
function node_widget_get_fields(&$form) {
  $fields = array();
  if (isset($form['type'])) {
    $content_type = content_types($form['type']['#value']);
    foreach ($content_type['fields'] as $field_name => $field) {
      if ($field['type'] == 'nodereference' && $field['widget']['type'] == 'node_widget_node_form') {
        $fields[$field_name] = $field;
      }
    }
  }
  return $fields;
}