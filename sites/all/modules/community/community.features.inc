<?php

/**
 * Implementation of hook_content_default_fields().
 */
function community_content_default_fields() {
  module_load_include('inc', 'community', 'community.defaults');
  $args = func_get_args();
  return call_user_func_array('_community_content_default_fields', $args);
}

/**
 * Implementation of hook_imagecache_default_presets().
 */
function community_imagecache_default_presets() {
  module_load_include('inc', 'community', 'community.defaults');
  $args = func_get_args();
  return call_user_func_array('_community_imagecache_default_presets', $args);
}

/**
 * Implementation of hook_node_info().
 */
function community_node_info() {
  module_load_include('inc', 'community', 'community.features.node');
  $args = func_get_args();
  return call_user_func_array('_community_node_info', $args);
}

/**
 * Implementation of hook_views_default_views().
 */
function community_views_default_views() {
  module_load_include('inc', 'community', 'community.features.views');
  $args = func_get_args();
  return call_user_func_array('_community_views_default_views', $args);
}
