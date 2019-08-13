<?php

// Get Timber context.
$context = Timber::get_context();


// If page is roster, use that twig template.
if (is_page('roster')) {
  // Set arguments for what users we want to fetch.
  $user_args = [
    'orderby' => 'display_name',
    'order'   => 'DESC',
    'exclude' => [66]
  ];


  /**
   * Get all users and pass to context.
   *
   * @var array $context['users'] Array of users.
   */
  $context['users'] = get_users($user_args);

  // Render roster twig template.
  Timber::render('page-roster.twig', $context);
  exit;
}


// If page is my account, use that twig template.
if (is_page('mitt-konto')) {
  if (! is_user_logged_in()) {
    exit(wp_safe_redirect(home_url()));
  }

  // Render my account twig template.
  Timber::render('page-myaccount.twig', $context);
  exit;
}


// If page is my account, use that twig template.
if (is_page('raidschema')) {
  if (! is_user_logged_in()) {
    exit(wp_safe_redirect(home_url()));
  }


  // get current time in order to query raids that hasnt happened
  date_default_timezone_set('Europe/Stockholm');
  $formatted_time = strftime("%Y-%m-%d %T");


  /**
   * Query raids.
   * @var array $args defines the query we want to do
   */
  $args = [
    'post_type'      => 'raid',
    'post_status'    => 'publish',
    'posts_per_page' => 15,
    'meta_key'       => 'datetime',
    'orderby'        => 'meta_value',
    'order'          => 'ASC',
    'meta_query'             => [
      [
        'key'     => 'datetime',
        'value'   => $formatted_time,
        'compare' => '>',
        'type'    => 'DATE'
      ]
    ]
  ];


  // get raids
  $raids = Timber::get_posts($args);
  $context['raids'] = $raids;


  // Render raidschedule twig template.
  Timber::render('page-raid.twig', $context);
  exit;
}


// If not already rendered, use basic page twig template.
Timber::render('page.twig', $context);
