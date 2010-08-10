<?php
// $Id: spaces.admin.inc,v 1.1.2.11 2010/02/09 21:05:32 jmiccolis Exp $

/**
 * Spaces features form.
 */
function spaces_features_form($form_state) {
  $spaces_features = variable_get('spaces_features', array());

  $form = array();
  $form['spaces_features'] = array('#tree' => TRUE);
  $form['labels'] = array('#tree' => FALSE);
  $form['settings'] = array('#tree' => FALSE);

  $space = spaces_get_space();
  $parent = menu_get_item();
  $features = spaces_features($space ? $space->type : 'site');
  ksort($features);
  // Preserve initial state of features for validation.
  $form['previous_features'] = array(
    '#type' => 'value',
    '#value' => $spaces_features,
  );

  foreach ($features as $feature => $info) {
    $label = "<strong>". t($info->info['name']) ."</strong>";
    $label .= "<div class='description'>". t($info->info['description']) ."</div>";
    $form['labels'][$feature] = array(
      '#value' => $label,
      '#type' => 'markup',
    );
    $form['spaces_features'][$feature] = array(
      '#type' => 'select',
      '#options' => $space ? $space->feature_options() : array(0 => t('Disabled'), 1 => t('Enabled')),
      '#default_value' => isset($spaces_features[$feature]) ? $spaces_features[$feature] : 0,
    );

    // By convention, features can provide settings pages at features/[feature].
    // This will detect the items that have been grafted from features/* onto the
    // portion fo the menu tree that relates to this pace.
    $item = menu_get_item("{$parent['href']}/{$feature}");
    if ($item && $item['href'] != $parent['href'] && $item['access']) {
      $settings = l($item['title'], $item['href'], array('query' => 'destination='. $_GET['q']));
    }
    else {
      $settings = '';
    }
    $form['settings'][$feature] = array(
      '#type' => 'markup',
      '#value' => $settings,
    );
  }

  $options = $space ? array('spaces-frontpage' => '<' . t('Default page') . '>') : array();
  $links = menu_navigation_links('features');
  if (!empty($links)) {
    foreach ($links as $link) {
      $options[$link['href']] = $link['title'];
    }
  }
  if (!empty($options)) {
    $form['site_frontpage'] = array(
      '#type' => 'select',
      '#options' => $options,
      '#title' => t('Default front page'),
      '#default_value' => variable_get('site_frontpage', 'node'),
      '#description' => t('The home page displays content from this menu item.'),
      '#element_validate' => array('spaces_site_frontpage_validate'),
    );
  }

  $form = system_settings_form($form);
  $form['#theme'] = 'spaces_features_form';
  $form['buttons']['#weight'] = 100;
  return $form;
}

/**
 * Validation for site_frontpage setting in spaces forms.
 */
function spaces_site_frontpage_validate($element, &$form_state) {
  $items = spaces_features_map('menu');
  $feature = isset($items[$element['#value']]) ? $items[$element['#value']] : FALSE;
  if ($element['#value'] !== 'spaces-frontpage' 
    && empty($form_state['values']['spaces_features'][$feature])
    && count(array_filter($form_state['values']['spaces_features'])) != 0
    && count(array_filter($form_state['values']['previous_features'])) != 0
  ) {
    form_error($element, t('Invalid front page selected'));
  }
}

/**
 * Generate a form snippet for choosing a spaces preset.
 */
function spaces_preset_form($presets, $type, $actions = 'actions') {
  $types = spaces_types();
  $form = array(
    '#tree' => FALSE,
    '#title' => isset($types[$type]['title']) ? $types[$type]['title'] : '',
    '#theme' => 'spaces_preset_form',
    '#space_type' => $type,
  );
  $form["spaces_preset_{$type}"] = array(
    '#type' => 'radios',
    '#options' => array(),
    '#default_value' => variable_get("spaces_preset_{$type}", NULL),
  );
  foreach ($presets as $preset) {
    if (empty($preset->disabled) || $actions === 'actions') {
      // Default preset radio
      if (empty($preset->disabled)) {
        $form["spaces_preset_{$preset->space_type}"]['#options'][$preset->name] = '';
      }

      // Label
      $label = "<strong>". t(check_plain($preset->title)) ."</strong>";
      $label .= "<div class='description'>". t(check_plain($preset->description)) ."</div>";
      $form['labels'][$preset->name] = array('#type' => 'markup', '#value' => $label);

      // Actions
      if (user_access('administer spaces')) {
        switch ($actions) {
          case 'actions':
            if (module_exists('spaces_ui')) {
              $form['storage'][$preset->name] = array('#type' => 'markup', '#value' => check_plain($preset->type));
              $links = array(
                'edit'    => l(t('Edit'), "admin/build/spaces/{$preset->name}"),
                'delete'  => l(t('Delete'), "admin/build/spaces/{$preset->name}/delete"),
                'revert'  => l(t('Revert'), "admin/build/spaces/{$preset->name}/revert"),
                'export'  => l(t('Export'), "admin/build/spaces/{$preset->name}/export"),
                'disable' => l(t('Disable'), "admin/build/spaces/{$preset->name}/disable"),
                'enable'  => l(t('Enable'), "admin/build/spaces/{$preset->name}/enable"),
              );
              foreach (array_keys($links) as $key) {
                if (!spaces_ui_preset_task_access($preset, $key)) {
                  unset($links[$key]);
                }
              }
              $form['actions'][$preset->name] = array('#type' => 'markup', '#value' => implode(' | ', $links));
            }
            break;
        }
      }
    }
  }
  return $form;
}

/**
 * Form for managing space override values.
 */
function spaces_overrides_form($form_state) {
  $space = spaces_get_space();
  $stack = array('space', 'preset');
  $form = array();
  if ($space) {
    foreach (array_keys(spaces_controllers()) as $controller) {
      foreach ($stack as $env) {
        foreach ($space->controllers->{$controller}->get(NULL, $env) as $key => $value) {
          if (!isset($form[$controller][$key])) {
            $form[$controller][$key] = array(
              '#type' => 'checkbox',
              '#title' => $key,
              '#disabled' => $env !== 'space',
              '#description' => $space->controllers->{$controller}->summary($key, $value),
              '#default_value' => NULL,
            );
          }
        }
      }
    }
    if (element_children($form)) {
      $form['#tree'] = TRUE;
      $form['#theme'] = 'spaces_overrides_form';
      $form['space'] = array('#type' => 'value', '#value' => $space);
      if ($presets = spaces_preset_load(NULL, $space->type)) {
        $preset_name = t($presets[variable_get('spaces_preset_'. $space->type, NULL)]->title);
        $form['preset'] = array(
          '#tree' => FALSE,
          '#type' => 'item',
          '#title' => t('Save'),
          '#description' => t('Save selected overrides from this space to the current preset <strong>@preset</strong>.', array('@preset' => $preset_name)),
        );
        $form['preset']['preset_save'] = array(
          '#type' => 'submit',
          '#value' => t('Save to preset'),
          '#submit' => array('spaces_overrides_preset_save'),
        );
      }
      $form['revert'] = array(
        '#tree' => FALSE,
        '#type' => 'item',
        '#title' => t('Revert'),
        '#description' => t('Revert the selected overrides for this space.'),
      );
      $form['revert']['revert'] = array(
        '#type' => 'submit',
        '#value' => t('Revert overrides'),
        '#submit' => array('spaces_overrides_revert'),
      );
    }
  }
  return $form;
}

/**
 * Submit handler for saving overrides to a preset.
 */
function spaces_overrides_preset_save(&$form, &$form_state) {
  $space = $form_state['values']['space'];
  $preset = spaces_preset_load(variable_get('spaces_preset_'. $space->type, NULL), NULL, TRUE);
  $selected = FALSE;
  $space->activate();
  foreach (array_keys(spaces_controllers()) as $controller) {
    $save = !empty($form_state['values'][$controller]) ? array_filter($form_state['values'][$controller]) : array();
    foreach (array_keys($save) as $key) {
      $override = $space->controllers->{$controller}->get($key, 'space');
      if ($override !== NULL) {
        $selected = TRUE;
        $preset->value[$controller][$key] = $override;
      }
    }
  }
  if ($selected) {
    spaces_preset_save($preset);
    drupal_set_message(t('Saved preset %title.', array('%title' => $preset->title)));
  }
  else {
    drupal_set_message(t('You need to select at least one override to save to the preset.'), 'error');
  }
}

/**
 * Submit handler for reverting overrides.
 */
function spaces_overrides_revert(&$form, &$form_state) {
  $space = $form_state['values']['space'];
  foreach (array_keys(spaces_controllers()) as $controller) {
    $remove = !empty($form_state['values'][$controller]) ? array_filter($form_state['values'][$controller]) : array();
    foreach (array_keys($remove) as $key) {
      $space->controllers->{$controller}->del($key);
    }
  }
  drupal_set_message(t('Saved %title.', array('%title' => $space->title())));
}

/**
 * Override of user/autocomplete. This accomplishes two things:
 * - Pushes the result set through db_rewrite_sql() which allows access
 *   conditions to be placed on the query.
 * - Uses a View, which allows implementing space types to filter the result
 *   set when a space is active.
 */
function spaces_user_autocomplete($string = '') {
  $matches = array();
  if ($string && module_exists('views')) {
    views_include('view');
    $view = new view;
    $view->base_table = 'users';
    $handler = $view->new_display('default', 'Defaults', 'default');
    $handler->override_option('filters', array(
      'current' => array(
        'id' => 'current',
        'table' => 'spaces',
        'field' => 'current',
      ),
    ));
    $view->set_display('default');
    $view->build();
    $view->query->add_field('users', 'name', 'name');
    $view->query->add_where(0, "LOWER(users.name) LIKE LOWER('%s%%')", $string);

    // Rebuild queries since we've altered the query object.
    $view->build_info['query'] = $view->query->query();
    $view->build_info['count_query'] = $view->query->query(TRUE);
    $view->build_info['query_args'] = $view->query->get_where_args();
    $view->execute_display();
    foreach ($view->result as $user) {
      $matches[$user->name] = check_plain($user->name);
    }    
  }
  drupal_json($matches);
}
