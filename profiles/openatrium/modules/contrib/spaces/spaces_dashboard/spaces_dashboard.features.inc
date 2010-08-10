<?php

/**
 * Implementation of hook_context_default_contexts().
 */
function spaces_dashboard_context_default_contexts() {
  module_load_include('inc', 'spaces_dashboard', 'spaces_dashboard.defaults');
  $args = func_get_args();
  return call_user_func_array('_spaces_dashboard_context_default_contexts', $args);
}

/**
 * Implementation of hook_ctools_plugin_api().
 */
function spaces_dashboard_ctools_plugin_api() {
  module_load_include('inc', 'spaces_dashboard', 'spaces_dashboard.defaults');
  $args = func_get_args();
  return call_user_func_array('_spaces_dashboard_ctools_plugin_api', $args);
}

/**
 * Implementation of hook_menu_default_items().
 */
function spaces_dashboard_menu_default_items() {
  module_load_include('inc', 'spaces_dashboard', 'spaces_dashboard.defaults');
  $args = func_get_args();
  return call_user_func_array('_spaces_dashboard_menu_default_items', $args);
}
