# Dipesh Kakadiya Assignment Inpsyde
Senior Full Stack WordPress Developer assignment for Inpsyde

## Requirements
- WordPress 6.1+.
- Theme Support: Legacy Theme 
  - Block based theme is currently not supported: 
      - As per my knowledge handling template for virtual page form plugin is not possible. Possible solution is we need to create page in WordPress backend.
      - We can create User list as custom Gutenberg block for block based theme. 
- PHP 8.0 or later, [Composer](https://getcomposer.org) and [Node.js](https://nodejs.org) for dependency management.
- [Docker](https://docs.docker.com/install/)

We suggest using a software package manager for installing the development dependencies such as [Homebrew](https://brew.sh) on MacOS:

	brew install php composer node docker docker-compose

## Development

1. Clone the plugin repository.

2. Setup the development environment and tools using [Node.js](https://nodejs.org) and [Composer](https://getcomposer.org):

   	npm install

## Local environment setup

This repository create local WordPress development environment based on [Docker](https://docs.docker.com/install/) using `wp-env` package.

To start local environment, run:

	npm run env-start

To stop local environment, run:

	npm run env-stop

which will make it available at [localhost:8888](http://localhost:8888/). Ensure that no other Docker containers or services are using port 8888 on your machine.

`wp-env` detail information: [Documentation](https://developer.wordpress.org/block-editor/reference-guides/packages/packages-env/)


