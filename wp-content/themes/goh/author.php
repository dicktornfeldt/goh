<?php

// get Timber context
$context = Timber::get_context();


/** @var WP_User|false WP_User object on success get author fields and content, false on failure */
$author_archive = get_userdata($author);


/** Add author fields to context */
$context['author'] = $author_archive;


Timber::render('author.twig', $context);
