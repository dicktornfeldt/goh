<?php

// get Timber context
$context = Timber::get_context();

// adds posts to the $context
$args = array(
  'post_type'      => 'post',
  'posts_per_page' => -1,
);
$context['articles'] = Timber::get_posts($args);

//adds the current post to the $context
$context['post'] = Timber::get_post();

Timber::render('frontpage.twig', $context);
