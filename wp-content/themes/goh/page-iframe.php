<?php
/*
|--------------------------------------------------------------------------
| Template Name: Iframe
|--------------------------------------------------------------------------
|
*/

// Get Timber context.
$context = Timber::get_context();

if (! is_user_logged_in()) {
  exit(wp_safe_redirect(home_url()));
}

// Render my account twig template.
Timber::render('page-iframe.twig', $context);
