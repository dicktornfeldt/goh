import jQuery from "jquery";
import "./style.scss";

import Router from "./javascripts/util/Router";
import common from "./javascripts/routes/common";
import home from "./javascripts/routes/home";
import mittKonto from "./javascripts/routes/my-account";

/**
 * Populate Router instance with DOM routes
 * @type {Router} routes - An instance of our router
 */
const routes = new Router({
  common,
  home,
  mittKonto
});

// Load Events
jQuery(document).ready(() => routes.loadEvents());
