# Dipesh Kakadiya Assignment Inpsyde
Senior Full Stack WordPress Developer assignment for Inpsyde

## Requirements
- WordPress 6.1+.
- Theme Support: Legacy Theme 
  - Block based theme is currently not supported: 
      - As per my knowledge, Virtual page will not handle with Block based because of currently we can't load Block based theme template form plugin. There is workaround but that not 100% perfect [ Theme styling is not working. ]
      - **Possible solution** is we need to create WordPress page and add `user-list-block` in to that page.
- PHP 8.0 or later, [Composer](https://getcomposer.org) and [Node.js](https://nodejs.org) for dependency management.
- [Docker](https://docs.docker.com/install/)

We suggest using a software package manager for installing the development dependencies such as [Homebrew](https://brew.sh) on MacOS:

	brew install php composer node docker docker-compose

## Development

1. Clone the plugin repository.


2. Setup the development environment and tools using [Node.js](https://nodejs.org) and [Composer](https://getcomposer.org):

   	npm install

3. For Development, Start watch to build js/Css assets of blocks.

   	npm run start

**Note: I already committed build version with git repo.** 


## Testing

1. Clone the plugin repository.


2. install Composer dependencies.

   	composer install

3. Please make sure Legacy Theme activated [ Example: `twentytwentyone` ]
   - Block based theme is currently not supported for virtual pages:
       - As per my knowledge, Virtual page will not handle with Block based because of currently we can't load Block based theme template form plugin. There is workaround but that not 100% perfect [ Theme styling is not working. ] 
       - **Possible solution** is we need to create WordPress page and add `user-list-block` in to that page.


4. User table will be found on http://localhost:8888/users-table/.


## Local environment setup

This repository create local WordPress development environment based on [Docker](https://docs.docker.com/install/) using `wp-env` package.

To start local environment, run:

	npm run env-start

To stop local environment, run:

	npm run env-stop

which will make it available at [localhost:8888](http://localhost:8888/). Ensure that no other Docker containers or services are using port 8888 on your machine.

Local environment **WordPress credentials**: 
- Username: `admin`
- Password: `password`

`wp-env` detail information: [Documentation](https://developer.wordpress.org/block-editor/reference-guides/packages/packages-env/)
