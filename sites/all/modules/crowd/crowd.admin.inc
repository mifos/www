<?php
// $Id: crowd.admin.inc,v 1.1.2.8 2010/04/08 13:34:09 ebeyrent Exp $

/**
 * Menu callback function to generate the module configuration form
 * @return
 *   Module configuration form
 */
function crowd_admin_settings() {
  $form['server'] = array(
    '#type' => 'fieldset',
    '#title' => t('Crowd server settings'),
    '#collapsible' => TRUE,
    '#collapsed' => FALSE,
  );
  
  $form['server']['crowd_server'] = array(
    '#type' => 'textfield',
    '#title' => t('Crowd server'),
    '#default_value' => variable_get('crowd_server', ''),
    '#size' => 30,
    '#maxlength' => 55,
    '#description' => t('Location of Atlassian Crowd authentication service.'),
  );
  
  $form['server']['crowd_port'] = array(
    '#type' => 'textfield',
    '#title' => t('Crowd port'),
    '#default_value' => variable_get('crowd_port', '443'),
    '#size' => 30,
    '#maxlength' => 8,
    '#description' => t('443 is the standard ssl port. 8443 is the standard non-root port for Tomcat.'),
  );
  
  $form['server']['crowd_uri'] = array(
    '#type' => 'textfield',
    '#title' => t('Crowd URI'),
    '#default_value' => variable_get('crowd_uri', ''),
    '#size' => 30, 
    '#description' => t('If Crowd is not at the root of the host, include a URI (e.g., /crowd).'),
  );
  
  $form['server']['crowd_application'] = array(
    '#type' => 'textfield',
    '#title' => t('Crowd Application Name'),
    '#default_value' => variable_get('crowd_application', ''),
    '#size' => 30, 
    '#description' => t('Applications need to be registered with Crowd in order to provide SSO services.  Enter the name of your registered application here.'),
  );
  
  $form['server']['crowd_application_password'] = array(
    //'#type' => 'password',
    '#type' => 'textfield',
    '#title' => t('Crowd Application Password'),
    '#default_value' => variable_get('crowd_application_password', ''),
    '#size' => 30, 
    '#description' => t('Enter the password used by your application to authenticate with Crowd'),
  );
  
  $form['server']['cookie_options'] = array(
    '#type' => 'fieldset',
    '#title' => t('SSO Cookie Options'),
    '#collapsible' => true,
    '#collapsed' => false,
  );
  
  $form['server']['cookie_options']['crowd_cookie_sso_domain'] = array(
    '#type' => 'textfield',
    '#title' => t('Crowd Cookie SSO Domain'),
    '#default_value' => variable_get('crowd_cookie_sso_domain', ''),
    '#size' => 30, 
    '#description' => t('This is the domain that Crowd will generate SSO cookies for.'),
  );
  
  $form['server']['cookie_options']['crowd_secure_sso_cookie'] = array(
    '#type' => 'checkbox',
    '#title' => t('Secure SSO Cookie'),
    '#default_value' => variable_get('crowd_secure_sso_cookie', false),
    '#description' => t('If checked, the "Secure" flag is set on the cookie. This will break SSO for applications not accessed over SSL/TLS (https://), potentially making logging into Crowd impossible.'),
  );
  
  $form['server']['cookie_options']['crowd_logout_no_cookie'] = array(
    '#type' => 'checkbox',
    '#title' => t('Log out if cookie is deleted?'),
    '#default_value' => variable_get('crowd_logout_no_cookie', false),
    '#description' => t('If enabled, this option will automatically log the current user out of Drupal if the Crowd SSO cookie has been deleted.  User 1 is exempted from this behavior.'),
  );
  
  $form['server']['cookie_options']['crowd_validate_token'] = array(
    '#type' => 'checkbox',
    '#title' => t('Validate the SSO auth token on each request?'),
    '#default_value' => variable_get('crowd_validate_token', false),
    '#description' => t('If enabled, this option will validate the SSO auth token against Crowd on every page load.  ').
      '<b>'.t('WARNING:').'</b> '.
      t('enabling this option may negatively impact performance of your web server and Crowd server significantly.  Use with caution!'),
  );
  
  $form['account'] = array(
    '#type' => 'fieldset',
    '#title' => t('User account settings'),
    '#collapsible' => TRUE,
    '#collapsed' => TRUE,
  );
  
  $form['account']['crowd_auto_assigned_role'] = array(
    '#type' => 'select',
    '#title' => t('Auto-assign users to the role(s)'),
    '#default_value' => variable_get('crowd_auto_assigned_role', array(DRUPAL_AUTHENTICATED_RID)),
    '#options' => user_roles(TRUE),
    '#multiple' => TRUE,
    '#description' => t('This value can be used to establish a role automatically for all Crowd users.  As an example, if you are also using the simple_ldap module, you can use this role to establish a tie between Crowd and LDAP-populated data.  i.e. Users with the role of \'crowd-user\' should have their LDAP data updated automatically.'),
  );
  
  $form['pages'] = array(
    '#type' => 'fieldset',
    '#title' => t('Redirection settings'),
    '#collapsible' => TRUE,
    '#collapsed' => TRUE,
  );
  
  $form['pages']['crowd_access'] = array(
    '#type' => 'radios',
    '#title' => t('Require Crowd login for'),
    '#default_value' => variable_get('crowd_access', 0),
    '#options' => array(t('specific pages'), t('all pages except specific pages')),
  );
  
  $form['pages']['crowd_pages'] = array(
    '#type' => 'textarea',
    '#title' => t('Specific pages'),
    '#default_value' => variable_get('crowd_pages', ''),
    '#cols' => 40,
    '#rows' => 5,
    '#description' => t("Enter one page per line as Drupal paths. The '*' character is a wildcard. Example paths are '<em>blog</em>' for the blog page and '<em>blog/*</em>' for every personal blog. '<em>&lt;front&gt;</em>' is the front page."),
  );
  
  $form['pages']['crowd_exclude'] = array(
    '#type' => 'textarea',
    '#title' => t('Excluded Pages'),
    '#default_value' => variable_get('crowd_exclude', ''),
    '#cols' => 40,
    '#rows' => 5,
    '#description' => t("Indicates which pages will be ignored (no login checks). Enter one page per line as Drupal paths. The '*' character is a wildcard. Example paths are '<em>blog</em>' for the blog page and '<em>blog/*</em>' for every personal blog. '<em>&lt;front&gt;</em>' is the front page."),
  );
  
  /**
   * Include LDAP configuration settings if the LDAP Auth module is enabled
   */
  if(module_exists('ldapauth')) {
    $form['ldap'] = array(
      '#type' => 'fieldset',
      '#title' => t('LDAP settings'),
      '#collapsible' => TRUE,
      '#collapsed' => TRUE,
    );
    
    $form['ldap']['crowd_useldap'] = array(
      '#type' => 'checkbox',
      '#title' => t('Should we extract the user email from an LDAP directory?'),
      '#default_value' => variable_get('crowd_useldap', 0),
      '#description' => t('Activate this option if you want to extract the user email from an LDAP directory. <strong>Ldapauth module must be enabled and configured</strong>.'),
    );
    
    $form['ldap']['crowd_ldap_email_attribute'] = array(
      '#type' => 'textfield',
      '#title' => t('Email attribute'),
      '#default_value' => variable_get('crowd_ldap_email_attribute', 'mail'),
      '#size' => 30,
      '#maxlength' => 55,
      '#description' => t('LDAP entry attribute containing the email address.'),
    );
    
    /**
     * Include LDAP Groups configuration settings if the LDAP Groups module is enabled
     */
    if(module_exists('ldapgroups')) {
      $form['ldap']['crowd_useldap_groups'] = array(
        '#type' => 'checkbox',
        '#title' => t('Should we extract user groups from an LDAP directory?'),
        '#default_value' => variable_get('crowd_useldap_groups', 0),
        '#description' => t('Activate this option if you want to extract the user groups from an LDAP directory. <strong>Ldapgroups module must be enabled and configured</strong>.'),
      );
    }
  }
  return system_settings_form($form);
}

/**
 * Helper function to cache the remote WSDL locally.  This function is required to overcome several bugs in PHP.
 * 
 * @see http://bugs.php.net/48216
 * @see http://bugs.php.net/31050
 */
function crowd_check_wsdl($redirect=true) {
  $crowd_wsdl = trim(variable_get('crowd_server', ''), '/').':'.
    variable_get('crowd_port', '443').'/'.
    variable_get('crowd_uri', '');

  $wsdl_file = file_directory_path().DIRECTORY_SEPARATOR.'crowdsoapservice.wsdl';
  $crowd_handler = curl_init($crowd_wsdl);
  $wsdl_handler = fopen($wsdl_file, 'w');
  @curl_setopt($crowd_handler, CURLOPT_FILE, $wsdl_handler);
  @curl_setopt($crowd_handler, CURLOPT_HEADER, 0);
  @curl_exec($crowd_handler);
  @curl_close($crowd_handler);
  @fclose($wsdl_handler);
  
  if(file_exists(file_directory_path().DIRECTORY_SEPARATOR.'crowdsoapservice.wsdl')) {
    watchdog('crowd', t('Crowd WSDL file successfully cached at %wsdl', array('%wsdl' => file_directory_path().DIRECTORY_SEPARATOR.'crowdsoapservice.wsdl')));
    drupal_set_message('Crowd WSDL file successfully cached.');
  }
  else {
    watchdog('crowd', t('Failed to cache the WSDL file located at %wsdl', array('%wsdl' => $crowd_wsdl)), WATCHDOG_ERROR);
  }
  
  if($redirect) {
    $url = empty($_SERVER['HTTP_REFERER']) ? 'admin/settings/crowd' : $_SERVER['HTTP_REFERER'];
    drupal_goto($url);
  }
}