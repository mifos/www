<?php
// $Id: node_widget.class.inc,v 1.7 2010/05/07 09:46:23 antoniodemarco Exp $

/**
 * Node Widget class
 *
 * @author antoniodemarco
 */
class node_widget {

  /**
   * Main $form array
   */
  var $form = array();

  /**
   * Main $form_state array
   */
  var $form_state = array();

  /**
   * Node widget field object
   */
  var $field = array();

  /**
   * Fieldgroup the node widget may belong to
   */
  var $fieldgroup = NULL;

  /**
   * Current user object
   */
  var $user = NULL;

  /**
   * Initialize the node widget object.
   *
   * @param $form
   *    Main $form array
   * @param $form_state
   *    Main $form_state array
   */
  function __construct(&$field, &$form, &$form_state) {

    global $user;
    $this->set_field($field);
    $this->user = $user;
    $this->form = &$form;
    $this->form_state = &$form_state;
    $form['#field_info'][$field['field_name']] = $field;
  }

  /**
   * Current node widget field being processed
   *
   * @param $field
   *    Node Widget field object
   */
  function set_field($field) {

    $this->field = $field;
    if (module_exists('fieldgroup')) {
      $this->fieldgroup = fieldgroup_get_group($this->field['type_name'], $this->field['field_name']);
    }
  }

  /**
   * Get node widget form
   */
  function &get_form($delta = 0) {

    if ($this->fieldgroup) {
      $form = $this->form[$this->fieldgroup][$this->field['field_name']][$delta][NODE_WIDGET_VALUES];
    }
    else {
      $form = $this->form[$this->field['field_name']][$delta][NODE_WIDGET_VALUES];
    }
    $form['#type'] = 'form';
    return $form;
  }

  /**
   * Build node widget forma state
   */
  function get_form_state($delta, $submitted = FALSE) {

    $form_state = array();
    $form_state['values'] = &$this->form_state['values'][$this->field['field_name']][$delta][NODE_WIDGET_VALUES];
    $form_state['values']['uid'] = $this->user->uid;
    $form_state['values']['name'] = $this->user->name;
    $form_state['storage'] = NULL;
    $form_state['submitted'] = $submitted;
    $form_state['clicked_button'] = $this->form_state['clicked_button'];
    $form_state['#field_info'] = isset($this->form['#field_info']) ? $this->form['#field_info'] : array();
    return $form_state;
  }

  /**
   * Validate a node form submission
   */
  function validate($delta) {

    $element = $this->get_element($delta);
    $form = $this->get_form($delta);
    $form_state = $this->get_form_state($delta);
    $form_id = $this->get_form_id($delta);

    $this->reset_parents($form);
    if (!$this->is_empty($form, $form_state)) {
      $this->toggle_validation($form, TRUE);
      drupal_validate_form($form_id, $form, $form_state);
      node_validate($form_state['values'], $form);
      $this->fix_error_messages($element);
    }
  }

  /**
   * Validate a node form submission
   */
  function submit($delta) {

    $form = $this->get_form($delta);
    $form_state = $this->get_form_state($delta, TRUE);
    if ($form_state['values']['remove'] && $form_state['values']['nid']) {
      node_delete($form_state['values']['nid']);
    }
    elseif (!$form_state['values']['remove'] && !$this->is_empty($form, $form_state)) {
      // TODO: Inherit promote and sticky from parent node
      if ($form_state['values']['body_field']) {
        $form_state['values']['body'] = $form_state['values']['body_field']['body'];
      }
      node_form_submit($form, $form_state);
      return $form_state['nid'];
    }
  }

  /**
   * After build callback for node widget
   */
  function build($delta, &$form) {

    if ($this->fieldgroup) {
      $this->toggle_validation($form[$this->fieldgroup][$this->field['field_name']][$delta][NODE_WIDGET_VALUES], FALSE);
    }
    else {
      $this->toggle_validation($form[$this->field['field_name']][$delta][NODE_WIDGET_VALUES], FALSE);
    }
  }

  /**
   * Get node widget element
   */
  function get_element($delta = 0) {

    if ($this->fieldgroup) {
      return $this->form[$this->fieldgroup][$this->field['field_name']][$delta];
    }
    else {
      return $this->form[$this->field['field_name']][$delta];
    }
  }

 /**
   * Get node widget form id
   */
  function get_form_id($delta = 0) {

    $form = $this->get_form($delta);
    return $form['form_id']['#value'] .'_'. $delta;
  }

  /**
   * Return array keys of children elements
   *
   * @return unknown
   */
  function get_children() {

    $elements = array();
    if ($this->fieldgroup) {
      $elements = element_children($this->form[$this->fieldgroup][$this->field['field_name']]);
    }
    else {
      $elements = element_children($this->form[$this->field['field_name']]);
    }
    return array_filter($elements, 'is_numeric');
  }

  /**
   * Reset #parents to their original values
   */
  private function reset_parents(&$elements) {

    foreach (element_children($elements) as $key) {
      if (isset($elements[$key]) && $elements[$key]) {
        $this->reset_parents($elements[$key]);
      }
    }
    if (is_array($elements['#parents']) && in_array(NODE_WIDGET_VALUES, $elements['#parents'])) {
      $elements['#parents'] = array_slice($elements['#parents'], 3);
    }
  }

  /**
   * Check if a node widget form contains an empty node.
   */
  function is_empty(&$form, &$form_state) {

    $result = module_invoke_all('node_widget_is_empty', $form, $form_state);
    if (is_array($result)) {
      foreach ($result as $empty) {
        $return = isset($return) ? ($return && $empty) : $empty;
      }
    }
    return $return;
  }

  /**
   * Toggle FAPI element validation by recursively setting #valideted to TRUE or FALSE.
   *
   * @param $elements
   *    Array of FAPI elements
   * @param $value
   *    TRUE or FALSE
   */
  function toggle_validation(&$elements, $value = TRUE) {

    foreach (element_children($elements) as $key) {
      if (isset($elements[$key]) && $elements[$key]) {
        $this->toggle_validation($elements[$key], $value);
      }
    }
    if ($elements['#needs_validation']) {
      $elements['#validated'] = !$value;
    }
  }

  /**
   * Return polished widget settings
   */
  function get_widget_settings() {

    $settings = array();
    $type = $this->get_referenced_type();
    foreach ($this->field['widget'] as $key => $value) {
      if (strstr($key, 'enable_'. $type) !== FALSE) {
       $name = substr($key, strlen('enable_'. $type) + 1, strlen($key));
       $settings[$name] = $value;
      }
    }
    return $settings;
  }

  /**
   * Fix Drupal error messages by cleaning duplicates
   * and highlighting the right form fields
   *
   * @param $element
   *    Node widget form element.
   */
  function fix_error_messages(&$element) {

    static $errors_cache = array();
    $children = element_children($element[NODE_WIDGET_VALUES]);
    $delta = $element['#delta'];
    $field_name = $element['#field_name'];

    // Fix error messages.
    $processed = array();
    $errors = form_get_errors() ? form_get_errors() : array();
    form_set_error(NULL, NULL, TRUE);
    $diff = array_diff_key($errors, $errors_cache);
    foreach ($diff as $key => $message) {
      $name = strstr($key, '][') === FALSE ? $key : array_shift(explode('][', $key));
      if (in_array($name, $children)) {
        $key = $field_name .']['. $delta .']['. NODE_WIDGET_VALUES .']['. $key;
      }
      $processed[$key] = $message;
    }
    $errors_cache = array_merge($processed, $errors_cache);
    foreach ($errors_cache as $key => $message) {
      form_set_error($key, $message);
    }

    // Remove duplicatete error messages
    if (is_array($_SESSION['messages']['error'])) {
      $duplicate = array();
      foreach ($_SESSION['messages']['error'] as $key => $message) {
        if (in_array($message, $duplicate)) {
          unset($_SESSION['messages']['error'][$key]);
        }
        $duplicate[] = $message;
      }
    }
  }

  /**
   * Get content type name referenced by the node widget
   */
  function get_referenced_type() {

    return array_shift(array_filter($this->field['referenceable_types'], 'is_string'));
  }

}