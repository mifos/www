<?php
// $Id: select_or_other.node_widget.inc,v 1.1 2010/02/10 10:02:06 antoniodemarco Exp $

/**
 * Implementation of hook_node_widget_widgets_info()
 */
function select_or_other_node_widget_widgets_info() {
  return array(
    'select_or_other',
//    'select_or_other_sort',
//    'select_or_other_buttons',
  );
}

/**
 * Implementation of hook_node_widget_content_is_empty()
 * // @todo: implement this hook to supports select_or_other_sort and select_or_other_buttons
 */
//function select_or_other_node_widget_content_is_empty($item, $field) {
//
//}