<?php

// Get Timber context.
$context = Timber::get_context();


// If page is roster, use that twig template.
if (is_page('roster')) {
  // Set arguments for what users we want to fetch.
  $user_args = [
    'orderby' => 'display_name',
    'order'   => 'DESC',
  ];


  /**
   * Get all users and pass to context.
   *
   * @var array $context['users'] Array of users.
   */
  $context['users'] = get_users($user_args);

  // Render roster twig template.
  Timber::render('roster.twig', $context);
  exit;
}


// If page is my account, use that twig template.
if (is_page('mitt-konto')) {
  // Render roster twig template.
  Timber::render('my-account.twig', $context);
  exit;
}


// If not already rendered, use basic page twig template.
Timber::render('page.twig', $context);
