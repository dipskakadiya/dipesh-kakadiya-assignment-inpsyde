<?php

declare(strict_types=1);

# -*- coding: utf-8 -*-

putenv('TESTS_PATH='.__DIR__);
putenv('LIBRARY_PATH='.dirname(__DIR__));
$vendor = dirname(dirname(dirname(__FILE__))).'/vendor/';
if (! realpath($vendor)) {
    die('Please install via Composer before running tests.');
}
if (! defined('PHPUNIT_COMPOSER_INSTALL')) {
    define('PHPUNIT_COMPOSER_INSTALL', $vendor.'autoload.php');
}

if (!class_exists(WP_CLI_Command::class)) {
	class WP_CLI_Command
	{
	}
}

require_once $vendor.'/antecedent/patchwork/Patchwork.php';
require_once $vendor.'autoload.php';
unset($vendor);

if (! defined('JSON_REST_API_INTEGRATION_DIR')) {
    define('JSON_REST_API_INTEGRATION_DIR', dirname(__DIR__, 2));
}
