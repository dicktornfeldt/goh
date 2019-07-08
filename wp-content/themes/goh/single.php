<?php

// get Timber context
$context = Timber::get_context();

//adds the current post to the $context
$context['post'] = Timber::get_post();

Timber::render('components/posts/post-single.twig', $context);
