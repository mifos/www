<?php

/**
 * Implementation of hook_imagecache_default_presets().
 */
function front_page_banner_imagecache_default_presets() {
  $items = array(
    'banner_image' => array(
      'presetname' => 'banner_image',
      'actions' => array(
        '0' => array(
          'weight' => '0',
          'module' => 'imagecache',
          'action' => 'imagecache_scale_and_crop',
          'data' => array(
            'width' => '578',
            'height' => '240',
          ),
        ),
      ),
    ),
  );
  return $items;
}

/**
 * Implementation of hook_node_info().
 */
function front_page_banner_node_info() {
  $items = array(
    'banner_entry' => array(
      'name' => t('Banner Entry'),
      'module' => 'features',
      'description' => t('An image and headline that can be displayed in a rotating banner'),
      'has_title' => '1',
      'title_label' => t('Title'),
      'has_body' => '0',
      'body_label' => '',
      'min_word_count' => '0',
      'help' => '',
    ),
  );
  return $items;
}

/**
 * Implementation of hook_views_api().
 */
function front_page_banner_views_api() {
  return array(
    'api' => '2',
  );
}
