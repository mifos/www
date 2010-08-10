<?php
// $Id: space_type_purl.inc,v 1.1.2.2 2009/12/16 19:23:50 yhahn Exp $

/**
 * Common functionality for space types that use a PURL modifier to trigger
 * their activation. Examples: space_og, space_taxonomy.
 */
class space_type_purl extends space_type {
  /**
   * Verify that this space's PURL modifier is present for the current
   * page request.
   */
  protected function verify_purl() {
    $method = variable_get("purl_method_spaces_{$this->type}", 'path');
    $elements = purl_active()->get($method);
    foreach ($elements as $element) {
      if ($element->provider == "spaces_{$this->type}" && $element->id == $this->id) {
        return TRUE;
      }
    }
    return FALSE;
  }

  /**
   * Return an array of paths from which the space should never be active.
   */
  protected function excluded_paths() {
    return array('features', 'features/*', 'admin', 'admin/*');
  }

  /**
   * Override of activate(). Ensure that the PURL modifier is present when the
   * space is active.
   */
  function activate() {
    $paths = implode("\n", $this->excluded_paths());
    if (!drupal_match_path($_GET['q'], $paths)) {
      if (!$this->verify_purl()) {
        // @TODO: This will drop other PURL providers. Probably not the desired behavior!
        purl_goto($_GET['q'], array('query' => drupal_query_string_encode($_GET, array('q')), 'purl' => array('provider' => "spaces_{$this->type}", 'id' => $this->id)));
      }
      return parent::activate();
    }
    return FALSE;
  }

  /**
   * Override of deactivate(). Ensure that the PURL modifier is not present
   * when the space is not active.
   */
  function deactivate() {
    purl_goto($_GET['q'], array('query' => drupal_query_string_encode($_GET, array('q')), 'purl' => array('remove' => array("spaces_{$this->type}"))));
  }
}
