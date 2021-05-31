<?php

// Get Timber context.
$context = Timber::get_context();

// If page is application, use that twig template.
if (is_page('guildansokan')) {
  // Render my account twig template.
  Timber::render('page-guildapplication.twig', $context);
  exit;
}

// If page is application, use that twig template.
if (is_page('merch')) {
  // Render my account twig template.
  Timber::render('page-merch.twig', $context);
  exit;
}

// If page is application, use that twig template.
if (is_page('race-to-70')) {
  // Render my account twig template.
  Timber::render('page-race.twig', $context);
  exit;
}

// If not already rendered, use basic page twig template.
Timber::render('page.twig', $context);
