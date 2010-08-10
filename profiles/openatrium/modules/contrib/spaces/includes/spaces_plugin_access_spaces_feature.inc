<?php
// $Id: spaces_plugin_access_spaces_feature.inc,v 1.1.2.3.2.2.2.4 2009/12/16 19:57:13 yhahn Exp $

/**
 * Provides access control for views by checking against the current space's feature settings.
 *
 * This access plugin delegates access control first to spaces_feature_access() which
 * will check whether the user can first access content, then the active space type's
 * 'feature_access' method will be called.  If implementing your own space type you have
 * the ability to define your own access control.  See 'space_og' class in Spaces OG
 * module for an example implementation.
 */
class spaces_plugin_access_spaces_feature extends views_plugin_access {
  /**
   * Check access directly.
   */
  function access($account) {
    $feature = $this->options['spaces_feature'] == 0 ? $this->get_my_feature() : $this->options['spaces_feature'];
    return spaces_access_feature('view', $feature, NULL);
  }

  /**
   * Provide the access check as a callback.
   */
  function get_access_callback() {
    $feature = $this->options['spaces_feature'] == 0 ? $this->get_my_feature() : $this->options['spaces_feature'];
    return array('spaces_access_feature', array('view', $feature, NULL));
  }

  /**
   * Display for Views UI.
   */
  function summary_title() {
    $features = spaces_features();
    if (isset($features[$this->options['spaces_feature']])) {
      return t('Feature: @feature', array('@feature' => $features[$this->options['spaces_feature']]->info['name']));
    }
    return $options['spaces_feature'] == 0 ? t('Autodetect') : t('Broken');
  }

  /**
   * Override of option_defaults().
   */
  function option_defaults(&$options) {
    $options['spaces_feature'] = 0;
  }

  /**
   * Override of options_form().
   */
  function options_form(&$form, &$form_state) {
    // Generate feature options.
    $options = array(0 => t('Autodetect'));
    foreach (spaces_features() as $feature) {
      $options[$feature->name] = check_plain($feature->info['name']);
    }
    $form['spaces_feature'] = array(
      '#type' => 'select',
      '#title' => t('Feature'),
      '#default_value' => $this->options['spaces_feature'],
      '#options' => $options,
      '#description' => t('Only allow access to this view if the user has access to the selected feature.'),
    );
  }

  /**
   * Attempt to detect the feature that this view belongs to.
   */
  protected function get_my_feature() {
    $map = spaces_features_map('views');
    return isset($map[$this->view->name]) ? $map[$this->view->name] : FALSE;
  }
}
