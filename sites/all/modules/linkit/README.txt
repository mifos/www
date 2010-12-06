; $Id: README.txt,v 1.7 2010/06/26 17:29:22 anon Exp $

-- INTRODUCTION --

Linkit provides an easy interface for internal linking. Linkit links to
nodes, users, views and terms by default, using an autocomplete field.
Linkit has two major advantages over traditional linking

 1. The user does not have to copy or remember a URL
 2. If the target node changes it's alias (e.g. if the node's menu item
    title is changed) the link will remain functional

See http://drupal.org/project/linkit for more information

-- INSTALLATION --

 1. Install and enable Linkit's dependencies (see below). Make sure
    Path Filter OR Pathologic is enabled on the input formats you intend to use with linkit
 2. Install and enable linkit (required) and at least one of linkit_node,
    linkit_views, linkit_taxonomy or linkit_user
 3. Enable the Linkit button in your WYSIWYG editor's settings

-- CONFIGURATION --

No additional configuration is necessary though you may fine-tune settings at
Administer -> Site configuration -> Linkit settings (/admin/settings/linkit).

To administrate this settings, you need "administer linkit" premission (/admin/user/permissions) or be user 1.

-- DEPENDENCIES --

Path Filter <http://drupal.org/project/pathfilter> OR Pathologic <http://drupal.org/project/pathologic>
One of these editors:
 * WYSIWYG <http://drupal.org/project/wysiwyg> with TinyMCE or CKEditor (recommended)
 * CKEditor <http://drupal.org/project/ckeditor>

-- HOOKS --

The autocomplete field is extendeble, so you can easy extend it with your own plugins.
For example you may wan't to integrate a third party web service.

There are two hooks that MUST be defined if you want to extend the autocomplete field.

- hook_linkit_load_plugins() - Will load the plugin results.
- hook_linkit_info_plugins() - Will be used if linkit_permissions is enables.

- hook_linkit_get_search_styled_link() - Will be used when a link is being edited (This hook is not necessary).

-- HOOK EXAMPLE --

/**
 * hook_linkit_load_plugins()
 *
 * This hook will extend the linkit module autocompele field with your own
 * matches.
 */
function MYMODULENAME_linkit_load_plugins($string) {
  $matches = array();
  
  // Get foo´s
  $result = db_query_range("SELECT foo, bar FROM {foo_table} WHERE LOWER(foo) LIKE LOWER('%%%s%%')", $string, 0, 10);
  while ($foo = db_fetch_object($result)) {
    $matches['MYMODULETYPE'][] = array(
      'title' => $foo->foo,
      'path' => 'internal:' . $foo->path, 
      'information' => array(
        'type' => 'Foos',
        'info1' => 'value1',
        'info2' => 'value2',
        'info3' => 'value3',
      ),
    );
  }
  return $matches;
}
(For alias link, use "base_path().$foo->path" instead of "'internal:' . $foo->path")

/**
 * Implementation of hook_linkit_info_plugins().
 */
function MYMODULENAME_linkit_info_plugins() {
  $return['MYMODULENAME'] = array(
    'type' => 'MYMODULETYPE',
  );
  return $return;
}


/**
 * Implementation of hook_linkit_get_search_styled_link().
 */
function MYMODULETYPE_linkit_get_search_styled_link($string) {
  // Node links created with Linkit will always begin with "internal:"
  if(strpos($string, 'internal:') === FALSE) {
    return;
  }

  // Check to see that the link really is a node link
  $splitted_string = explode('/', str_replace('internal:', '', $string));
  if($splitted_string[0] != 'node') {
    return;
  }

  // This is a node link created with Linkit, try to grab the title and path now. 
  $result = db_query(db_rewrite_sql("SELECT n.nid, n.title FROM {node} n WHERE n.nid = %d"), $splitted_string[1]);
  $node = db_fetch_object($result);
  
  // No reault or no node was found
  if(!$result || !$node) {
    return;
  }

  return check_plain($node->title) . ' [path:internal:node/' . $node->nid . ']';
}

-- MAINTAINERS --

 * anon <http://drupal.org/user/464598>
 * betamos <http://drupal.org/user/442208>
 * blackdog <http://drupal.org/user/110169>
 * freakalis <http://drupal.org/user/204187>
