<?php

/**
 * Implementation of hook_content_default_fields().
 */
function contributors_content_default_fields() {
  module_load_include('inc', 'contributors', 'contributors.defaults');
  $args = func_get_args();
  return call_user_func_array('_contributors_content_default_fields', $args);
}

/**
 * Implementation of hook_fieldgroup_default_groups().
 */
function contributors_fieldgroup_default_groups() {
  module_load_include('inc', 'contributors', 'contributors.defaults');
  $args = func_get_args();
  return call_user_func_array('_contributors_fieldgroup_default_groups', $args);
}

/**
 * Implementation of hook_node_info().
 */
function contributors_node_info() {
  module_load_include('inc', 'contributors', 'contributors.features.node');
  $args = func_get_args();
  return call_user_func_array('_contributors_node_info', $args);
}

/**
 * Implementation of hook_views_default_views().
 */
function contributors_views_default_views() {
  module_load_include('inc', 'contributors', 'contributors.features.views');
  $args = func_get_args();
  return call_user_func_array('_contributors_views_default_views', $args);
}
