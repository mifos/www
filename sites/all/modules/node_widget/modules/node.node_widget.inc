<?php
// $Id: node.node_widget.inc,v 1.3 2010/05/07 09:46:23 antoniodemarco Exp $

/**
 * Implementation of hook_node_widget_form_alter()
 */
function node_node_widget_form_alter(&$form, &$form_state, $form_id) {
  if (isset($form['type']) && isset($form['#node']) && $form['type']['#value'] .'_node_widget_form' == $form_id) {

    module_load_include('inc', 'node', 'node.pages');
    if ($extra = node_invoke($form['#node'], 'form', $form_state)) {
      foreach ($extra as $key => $value) {
        if (isset($form_state['#node_widget_settings'][$key]) && !$form_state['#node_widget_settings'][$key]) {
          unset($extra[$key]);
        }
      }
      if (isset($extra['body_field'])) {
        unset($extra['body_field']['teaser_js']);
        unset($extra['body_field']['teaser_include']);
        unset($extra['body_field']['format']);
        $extra['body_field']['body']['#rows'] = 5;
      }
      $form = array_merge_recursive($form, $extra);
    }
    if (!isset($form['title']['#weight'])) {
      $form['title']['#weight'] = -5;
    }
  }
}

/**
 * Implementation of hook_node_widget_widget_settings()
 */
function node_node_widget_widget_settings($type) {
  $settings = array();
  if ($type->has_title) {
    $settings[] = array(
      'name' => 'title',
      'label' => t($type->title_label),
      'supported' => TRUE,
      'message' => NULL,
    );
  }
  if ($type->has_body) {
    $settings[] = array(
      'name' => 'body_field',
      'label' => t($type->body_label),
      'supported' => TRUE,
    );
  }
  return $settings;
}

/**
 * Implementation of hook_node_widget_is_empty()
 */
function node_node_widget_is_empty(&$form, &$form_state) {
  $empty_title = !isset($form_state['values']['title']) || empty($form_state['values']['title']);
  $empty_body = !isset($form_state['values']['body_field']) || empty($form_state['values']['body_field']['body']);
  return $empty_title && $empty_body;
}
