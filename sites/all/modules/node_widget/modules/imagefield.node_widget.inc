<?php
// $Id: imagefield.node_widget.inc,v 1.1 2010/03/05 13:47:21 antoniodemarco Exp $

/**
 * Implementation of hook_node_widget_widgets_info()
 */
function imagefield_node_widget_widgets_info() {
  return array(
    'imagefield_widget',
  );
}

/**
 * Element #process callback for the imagefield_widget field type
 * when used into a node_widget form.
 */
function imagefield_widget_node_widget_process($element, $edit, &$form_state, $form) {
  return _filefield_node_widget_process($element);
}