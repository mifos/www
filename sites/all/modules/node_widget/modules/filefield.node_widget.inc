<?php
// $Id: filefield.node_widget.inc,v 1.1 2010/03/05 13:47:21 antoniodemarco Exp $

/**
 * Implementation of hook_node_widget_widgets_info()
 */
function filefield_node_widget_widgets_info() {
  return array(
    'filefield_widget',
  );
}

/**
 * Element #process callback for the filefield_widget field type
 * when used into a node_widget form.
 */
function filefield_widget_node_widget_process($element, $edit, &$form_state, $form) {
  return _filefield_node_widget_process($element);
}

/**
 * Helper function shared between FileField and ImageField modules
 */
function _filefield_node_widget_process($element) {
  if (in_array(NODE_WIDGET_VALUES, $element['#parents'])) {
    $arguments =  $element['#type_name'] .'/'. $element['#field_name'] .'/'. $element['#delta'] .'/'. $element['#parents'][0] .'/'. $element['#parents'][1];
    $element['filefield_upload']['#ahah']['path'] = 'filefield/ahah/'. $arguments;
    $element['filefield_remove']['#ahah']['path'] = 'filefield/ahah/'. $arguments;
  }
  return $element;
}

/**
 * Menu callback for handling node_widget AHAH requests.
 */
function filefield_node_widget_js($type_name, $field_name, $delta, $node_widget = NULL, $node_widget_delta = 0) {
  $field = content_fields($field_name, $type_name);

  if (empty($field) || empty($_POST['form_build_id'])) {
    // Invalid request.
    drupal_set_message(t('An unrecoverable error occurred. The uploaded file likely exceeded the maximum file size (@size) that this server supports.', array('@size' => format_size(file_upload_max_size()))), 'error');
    print drupal_to_js(array('data' => theme('status_messages')));
    exit;
  }

  // Build the new form.
  $form_state = array('submitted' => FALSE);
  $form_build_id = $_POST['form_build_id'];
  $form = form_get_cache($form_build_id, $form_state);

  if (!$form) {
    // Invalid form_build_id.
    drupal_set_message(t('An unrecoverable error occurred. This form was missing from the server cache. Try reloading the page and submitting again.'), 'error');
    print drupal_to_js(array('data' => theme('status_messages')));
    exit;
  }

  // Build the form. This calls the file field's #value_callback function and
  // saves the uploaded file. Since this form is already marked as cached
  // (the #cache property is TRUE), the cache is updated automatically and we
  // don't need to call form_set_cache().
  $args = $form['#parameters'];
  $form_id = array_shift($args);
  $form['#post'] = $_POST;
  $form = form_builder($form_id, $form, $form_state);

  if ($node_widget) {
    if (module_exists('fieldgroup') && ($group_name = _fieldgroup_field_get_group($form_state['values']['type'], $node_widget))) {
      $parents[] = $group_name;
    }
    $parents[] = $node_widget;
    $parents[] = $node_widget_delta;
    $parents[] = NODE_WIDGET_VALUES;
    $parents[] = $field_name;
    $form_element = $form;
    do {
      $key = array_shift($parents);
      $form_element = $form_element[$key];
    } while ($key != $field_name);
  }
  else {
    // Update the cached form with the new element at the right place in the form.
    if (module_exists('fieldgroup') && ($group_name = _fieldgroup_field_get_group($type_name, $field_name))) {
      if (isset($form['#multigroups']) && isset($form['#multigroups'][$group_name][$field_name])) {
        $form_element = $form[$group_name][$delta][$field_name];
      }
      else {
        $form_element = $form[$group_name][$field_name][$delta];
      }
    }
    else {
      $form_element = $form[$field_name][$delta];
    }

//    $form_element = $form['group_band_test']['field_band_albums'][$delta]['node_widget'][$field_name];
  }
  if (isset($form_element['_weight'])) {
    unset($form_element['_weight']);
  }

  $output = drupal_render($form_element);

  // AHAH is not being nice to us and doesn't know the "other" button (that is,
  // either "Upload" or "Delete") yet. Which in turn causes it not to attach
  // AHAH behaviours after replacing the element. So we need to tell it first.

  // Loop through the JS settings and find the settings needed for our buttons.
  $javascript = drupal_add_js(NULL, NULL);
  $filefield_ahah_settings = array();
  if (isset($javascript['setting'])) {
    foreach ($javascript['setting'] as $settings) {
      if (isset($settings['ahah'])) {
        foreach ($settings['ahah'] as $id => $ahah_settings) {
          if (strpos($id, 'filefield-upload') || strpos($id, 'filefield-remove')) {
            $filefield_ahah_settings[$id] = $ahah_settings;
          }
        }
      }
    }
  }

  // Add the AHAH settings needed for our new buttons.
  if (!empty($filefield_ahah_settings)) {
    $output .= '<script type="text/javascript">jQuery.extend(Drupal.settings.ahah, '. drupal_to_js($filefield_ahah_settings) .');</script>';
  }

  $output = theme('status_messages') . $output;

  // For some reason, file uploads don't like drupal_json() with its manual
  // setting of the text/javascript HTTP header. So use this one instead.
  $GLOBALS['devel_shutdown'] = FALSE;
  print drupal_to_js(array('status' => TRUE, 'data' => $output));
  exit;
}
