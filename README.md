# GOH Theme

- [Features](#features)
- [Requirements](#requirements)
- [Getting Started](#getting-started)
- [Developing Locally](#developing-locally)
- [Building for Production](#building-for-production)
- [Project Structure](#project-structure)

## Features

- Modern JavaScript through Webpack
- Live reload via BrowserSync
- SCSS support
- PHPCS for linting PHP
- Helpful HTML5 Router for firing JS based on WordPress page slug.
- Twig via Timber as template engine.

## Requirements

- Node.js
- Yarn
- PHP

## Getting Started

```bash
# download or git clone and cd into theme folder
yarn install
```

## Developing Locally

First we need to set BrowserSync `proxy` to mirror your dev-environment.

```js
// scripts/webpack.config.js
...
new BrowserSyncPlugin({
  notify: false,
  host: 'localhost',
  port: 4000, // this is the port you develop on. Can be anything.
  logLevel: 'silent',
  files: ['./*.php'],
  proxy: 'https://pigment.test/', // match your local dev-url
}),
...
```

To work on the theme locally, open another window/tab in terminal and run:

```bash
yarn start
```

This will open a browser, watch all files (php, scss, js, etc) and reload the
browser when you press save.

## Building for Production

To create an optimized production build, run:

```bash
yarn build
```

This will minify assets, bundle and uglify javascript, and compile scss to css.
It will also add cachebusting names to then ends of the compiled files, so you
do not need to bump any enqueued asset versions in `functions.php`.

## Project Structure

```bash
.
├── functions.php
├── index.php
├── front-page.php
├── page.php
├── single.php
├── phpcs.xml   # Custom ruleset for phpcs
├── package.json    # Node.js dependencies
├── app   # Theme functionality
   └── setup.php    # Theme setup
├── views   # Prensentational layers
├── app   # Theme functionality
   └── setup.php    # Theme setup
├── scripts   # Build / Dev Scripts
   ├── build.js   # Build task
   ├── start.js   # Start task
   └── webpack.config.js    # Webpack configuration
└──src
   ├── index.js   # JavaScript entry point
   ├── javascripts    # JavaScript
      └── util
         ├── Router.js    # HTML5 Router, DO NOT TOUCH
         ├── camelCase.js   # Helper function for Router, DO NOT TOUCH
      ├── routes    # Routes
         ├── common.js    # JS that will run on EVERY page
         ├── <xxx>.js   # JS that will run on pages with <xxx> slug
   ├── style.scss   # SCSS style entry point
   ├── styles   # SCSS
      ├── _global-vars.scss
      ├── _base.scss
      └── ...

```
