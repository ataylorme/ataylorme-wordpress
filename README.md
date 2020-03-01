# ataylorme-wordpress

## Archived in 2020

As of 2020, this project has been archived and is no longer maintained. It can still be used as a reference example but is out of date.

## About

The [WordPress](https://wordpress.org/) and [WP Rig](https://github.com/wprig/wprig) powered [personal site of Andrew Taylor](https://ataylor.me). 

## Build Status

[![CircleCI](https://circleci.com/gh/ataylorme/ataylorme-wordpress.svg?style=shield)](https://circleci.com/gh/ataylorme/ataylorme-wordpress)
[![Dashboard ataylorme-wordpress](https://img.shields.io/badge/dashboard-ataylorme_wordpress-yellow.svg)](https://dashboard.pantheon.io/sites/489520a4-b156-4743-8e4c-dffdcf353fa2#dev/code)
[![Dev Site ataylorme-wordpress](https://img.shields.io/badge/site-ataylorme_wordpress-blue.svg)](http://dev-ataylorme-wordpress.pantheonsite.io/)

## Tools Used

This open-source repository is an extension of [`pantheon-systems/example-wordpress-composer`](https://github.com/pantheon-systems/example-wordpress-composer/) and serves as a reference implementation of an advanced WordPress deployment workflow on [Pantheon](https://pantheon.io). Some of the open-source tools used are:
- Local development environment with [Lando](https://docs.devwithlando.io/)
- Asset compilation with [gulp](https://gulpjs.com/)
- PHP dependency management with [Composer](https://getcomposer.org/)
- Build and testing processes run on [CircleCI](https://circleci.com/)
  - Additional Pantheon command-line commands with the [Terminus Buld Tools Plugin](https://github.com/pantheon-systems/terminus-build-tools-plugin/)
  - [`pantheon-systems/docker-build-tools-ci`](https://github.com/pantheon-systems/docker-build-tools-ci/) a custom docker image with PHP, NodeJS and Headless Chrome
- Unit tests with [PHP Unit](https://phpunit.de/)
- [Behat](http://behat.org/en/latest/) testing with [WordHat](https://github.com/paulgibbs/behat-wordpress-extension/)
- Enforced [WordPress coding standards](https://github.com/WordPress-Coding-Standards/WordPress-Coding-Standards) with [PHP code sniffer](https://github.com/squizlabs/PHP_CodeSniffer)
- Performance testing with [Lighthouse](https://developers.google.com/web/tools/lighthouse/) and [Jest](https://jestjs.io/)
- Visual regression testing with [BackstopJS](https://github.com/garris/BackstopJS/)
- Daily Composer update pull requests with [Composer lock updater](https://github.com/danielbachhuber/composer-lock-updater)
