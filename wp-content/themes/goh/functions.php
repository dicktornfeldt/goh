<?php
/**
 * Function includes
 *
 * The $function_includes array determines the code library included in your theme.
 * Add or remove files to the array as needed. Supports child theme overrides.
 *
 * Please note that missing files will produce a fatal error.
 *
 */

$function_includes = [
  'app/setup.php', // Theme setup
  'app/cpt.php', // Custom post type
  // 'app/wp_mail_smtp.php' // Handle all mails sent from site

  /**
   * Handle AJAX requests
   */
  'app/WP_Ajax/WP_Ajax.php',                // Class for handling WP AJAX calls
  'app/WP_Ajax/ajax-requests/autoload.php', // All AJAX Classes
];

foreach ($function_includes as $file) {
  if (!$filepath = locate_template($file)) {
    trigger_error(sprintf(__('Error locating %s for inclusion'), $file), E_USER_ERROR);
  }

  require_once $filepath;
}
unset($file, $filepath);
