<?php
// $Id: node_widget.theme.inc,v 1.1 2010/02/09 12:27:12 antoniodemarco Exp $

/**
 * Implementation of hook_theme().
 */
function node_widget_theme() {
  return array(
    'node_widget_element' => array(
      'arguments' => array('element' => NULL),
    ),
    'node_widget_form' => array(
      'arguments' => array('form' => NULL),
    ),
  );
}

/**
 * Theme function for node_widget_element widget.
 */
function theme_node_widget_element(&$element) {
  return $element['#children'];
}

/**
 * Theme widget node form as a table row.
 */
function theme_node_widget_form($form) {
  return drupal_render($form);
}