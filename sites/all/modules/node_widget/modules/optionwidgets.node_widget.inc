<?php
// $Id: optionwidgets.node_widget.inc,v 1.1 2010/02/09 12:27:12 antoniodemarco Exp $

/**
 * Implementation of hook_node_widget_widgets_info()
 */
function optionwidgets_node_widget_widgets_info() {
  return array(
    'optionwidgets_select',
    'optionwidgets_buttons',
    'optionwidgets_onoff',
  );
}