<?php
// $Id: content.node_widget.inc,v 1.2 2010/03/31 20:56:53 antoniodemarco Exp $

/**
 * Implementation of hook_node_widget_form_alter()
 */
function content_node_widget_form_alter(&$form, &$form_state, $form_id) {
  if (isset($form['type']) && isset($form['#node']) && $form['type']['#value'] .'_node_widget_form' == $form_id) {
    module_load_include('inc', 'content', 'includes/content.node_form');
    foreach (content_node_widget_supported_fields($form['#node']->type) as $field) {
      if ($form_state['#node_widget_settings'][$field['field_name']]) {
        $form['#field_info'][$field['field_name']] = $field;
        $form += (array) content_field_form($form, $form_state, $field);
      }
    }
  }
}

/**
 * Implementation of hook_node_widget_is_empty()
 */
function content_node_widget_is_empty(&$form, &$form_state) {
  if (is_array($form['#field_info'])) {
    foreach ($form['#field_info'] as $name => $field) {
      foreach ($form_state['values'][$name] as $item) {
        // With modules like Date or widgets loke optionswidgets_onof
        // we do need more control then the standard hook_content_is_empty().
        $function = $field['module'] .'_content_is_empty';
        $node_widget_function = $field['module'] .'_node_widget_content_is_empty';
        if (function_exists($node_widget_function)) {
          $_result = $node_widget_function($item, $field);
        }
        elseif (function_exists($function)) {
          $_result = $function($item, $field);
        }
        $result = isset($result) ? $result && $_result : $_result;
      }
    }
  }
  return $result;
}

/**
 * Implementation of hook_node_widget_widget_settings()
 */
function content_node_widget_widget_settings($type) {

  $content_type = content_types($type->type);
  $fields = $content_type['fields'];

  $settings = array();
  $widget_info = module_invoke_all('widget_info');
  $widgets = module_invoke_all('node_widget_widgets_info');
  foreach ($fields as $field) {
    if ($field['type_name'] == $type->type) {
      $_field['name'] = $field['field_name'];
      $_field['label'] = $field['widget']['label'];
      $_field['supported'] = TRUE;
      if (!in_array($field['widget']['type'], $widgets)) {
        $_field['supported'] = FALSE;
        $_field['message'] = t('Widget <em>!widget</em> not supported.', array('!widget' => $widget_info[$field['widget']['type']]['label']));
      } elseif ($field['multiple']) {
        $_field['supported'] = FALSE;
        $_field['message'] = t('Multiple number of values not supported.', array('!widget' => $widget_info[$field['widget']['type']]['label']));
      }
      $settings[] = $_field;
      $_field['message'] = '';
    }
  }
  return $settings;

}

/**
 * Return array of supported fields
 *
 * @param $content_type
 *    Content type machine readable name
 */
function content_node_widget_supported_fields($content_type) {
  $supported = array();
  $type = content_types($content_type);
  $widgets = module_invoke_all('node_widget_widgets_info');
  foreach ($type['fields'] as $field) {
    if (in_array($field['widget']['type'], $widgets)) {
      $supported[] = $field;
    }
  }
  return $supported;
}
