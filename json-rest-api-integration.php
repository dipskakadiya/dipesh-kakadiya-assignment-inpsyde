<?php # -*- coding: utf-8 -*-

/**
 * Plugin Name: Json Rest API Integration
 * Plugin URI: https://github.com/dipskakadiya/dipesh-kakadiya-assignment-inpsyde
 * Description: Inpsyde Assignment Json Rest API Integration
 * Version: 1.0
 * Author: Dipesh Kakadiya
 * Author URI: https://devdips.wordpress.com/
 * License: GPL-2.0
 */

namespace Inpsyde\JsonRestApiIntegration;

if ( ! defined( 'JSON_REST_API_INTEGRATION_DIR' ) ) {
	define( 'JSON_REST_API_INTEGRATION_DIR', __DIR__ );
}

if ( ! class_exists( JsonRestApiIntegration::class ) && is_readable( __DIR__ . '/vendor/autoload.php' ) ) {
	require_once __DIR__ . '/vendor/autoload.php';
}

class_exists( JsonRestApiIntegration::class ) && JsonRestApiIntegration::instance();
