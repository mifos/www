<?php
// $Id: content_taxonomy.node_widget.inc,v 1.1 2010/02/10 11:20:53 antoniodemarco Exp $

/**
 * Implementation of hook_node_widget_widgets_info()
 */
function content_taxonomy_node_widget_widgets_info() {
  return array(
    'content_taxonomy_options',
    'content_taxonomy_select',
  );
}
