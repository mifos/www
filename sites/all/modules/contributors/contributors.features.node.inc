<?php

/**
 * Helper to implementation of hook_node_info().
 */
function _contributors_node_info() {
  $items = array(
    'bug' => array(
      'name' => t('Project Bug'),
      'module' => 'features',
      'description' => '',
      'has_title' => '1',
      'title_label' => t('Title'),
      'has_body' => '1',
      'body_label' => t('Bug Description'),
      'min_word_count' => '0',
      'help' => '',
    ),
    'project' => array(
      'name' => t('Volunteer Project'),
      'module' => 'features',
      'description' => '',
      'has_title' => '1',
      'title_label' => t('Project Name'),
      'has_body' => '1',
      'body_label' => t('Problem/Background'),
      'min_word_count' => '0',
      'help' => '',
    ),
  );
  return $items;
}
