<?php
// $Id: fivestar.node_widget.inc,v 1.1 2010/02/10 11:38:35 antoniodemarco Exp $

/**
 * Implementation of hook_node_widget_widgets_info()
 */
function fivestar_node_widget_widgets_info() {
  return array(
    'stars',
    'radios',
  );
}

/**
 * Implementation of hook_node_widget_content_is_empty()
 */
function fivestar_node_widget_content_is_empty($item, $field) {
  if (($item['rating'])) {
    return TRUE;
  }
  return FALSE;
}