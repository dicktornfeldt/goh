<?php

/*
|--------------------------------------------------------------------------
| Autoloader
|--------------------------------------------------------------------------
|
| This fle is responsible to autolad all files added inside app/ajax
| directory except autoload.php file. This wil help autoloading
| class and functions automatically without requiring each files
| everytime when we create new file inside this directory.
|
*/

/**
 * Add a global JavaScript variable named ‘ajaxurl’
 * this is the URL that AJAX requests need to be sent to.
 */
\WP_AJAX::WP_HeadAjaxURL();

/**
 * Autoload all files inside this directory
 * except autoload.php
 */
foreach (scandir(dirname(__FILE__)) as $filename) {
  if ($filename != 'autoload.php') {
    $path = dirname(__FILE__) . '/' . $filename;
    if (is_file($path) && file_exists($path)) {
      require_once $path;
    }
  }
}
