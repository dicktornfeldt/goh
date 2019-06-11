import jQuery from 'jquery';
import './style.scss';

import Router from './javascripts/util/Router';
import common from './javascripts/routes/common';
import home from './javascripts/routes/home';
import about from './javascripts/routes/about';

/**
 * Populate Router instance with DOM routes
 * @type {Router} routes - An instance of our router
 */
const routes = new Router({
  /** All pages */
  common,
  /** Home page */
  home,
  /** About Us page, note the change from about-us to aboutUs. */
  about
});

/** Load Events */
jQuery(document).ready(() => routes.loadEvents());
