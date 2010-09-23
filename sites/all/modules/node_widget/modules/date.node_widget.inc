<?php
// $Id: date.node_widget.inc,v 1.3 2010/02/23 14:57:19 antoniodemarco Exp $

/**
 * Implementation of hook_node_widget_widgets_info()
 */
function date_node_widget_widgets_info() {
  return array(
    'date_select',
    'date_text',
    'date_popup',
  );
}

/**
 * Implementation of hook_node_widget_content_is_empty()
 */
function date_node_widget_content_is_empty($item, $field) {
  $empty = 0;
  foreach (array('value', 'value2') as $key) {
    if ($item[$key] && is_array($item[$key])) {
      foreach ($item[$key] as $value) {
        $empty = $empty + $value;
      }
    }
  }
  return !$empty;
}