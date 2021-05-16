import jQuery from "jquery";
import "./style.scss";

import Router from "./javascripts/util/Router";
import common from "./javascripts/routes/common";

/**
 * Populate Router instance with DOM routes
 * @type {Router} routes - An instance of our router
 */
const routes = new Router({
  common,
});

// Load Events
jQuery(document).ready(() => routes.loadEvents());
