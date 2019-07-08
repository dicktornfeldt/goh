<?php

// get Timber context
$context = Timber::get_context();


$args = [
  'post_type'      => 'post',
  'post_status'    => 'publish',
  'posts_per_page' => 5,
];
$frontpage_posts = Timber::get_posts($args);
$context['posts'] = $frontpage_posts;


Timber::render('frontpage.twig', $context);
