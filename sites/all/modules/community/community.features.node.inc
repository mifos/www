<?php

/**
 * Helper to implementation of hook_node_info().
 */
function _community_node_info() {
  $items = array(
    'deployment' => array(
      'name' => t('Deployment'),
      'module' => 'features',
      'description' => '',
      'has_title' => '1',
      'title_label' => t('Name'),
      'has_body' => '1',
      'body_label' => t('Description'),
      'min_word_count' => '0',
      'help' => '',
    ),
    'event' => array(
      'name' => t('Event'),
      'module' => 'features',
      'description' => '',
      'has_title' => '1',
      'title_label' => t('Title'),
      'has_body' => '1',
      'body_label' => t('Body'),
      'min_word_count' => '0',
      'help' => '',
    ),
    'groups' => array(
      'name' => t('Groups'),
      'module' => 'features',
      'description' => '',
      'has_title' => '1',
      'title_label' => t('Group Name'),
      'has_body' => '1',
      'body_label' => t('Group Description'),
      'min_word_count' => '0',
      'help' => '',
    ),
  );
  return $items;
}
