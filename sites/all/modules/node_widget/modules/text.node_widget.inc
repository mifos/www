<?php
// $Id: text.node_widget.inc,v 1.1 2010/02/09 12:27:12 antoniodemarco Exp $

/**
 * Implementation of hook_node_widget_widgets_info()
 */
function text_node_widget_widgets_info() {
  return array(
    'text_textfield',
    'text_textarea',
  );
}

/**
 * Implementation of hook_node_widget_content_is_empty()
 */
function text_node_widget_content_is_empty($item, $field) {

  if ($field['widget']['type'] == 'optionwidgets_onoff') {
    $options = optionwidgets_options($field);
    $keys = array_keys($options);
    $on_value = (!empty($keys) && isset($keys[1])) ? $keys[1] : NULL;
    return $item['value'] != $on_value;
  }

  if ($field['widget']['type'] == 'optionwidgets_select' || $field['widget']['type'] == 'optionwidgets_button') {
    return empty($item);
  }

  return text_content_is_empty($item, $field);
}