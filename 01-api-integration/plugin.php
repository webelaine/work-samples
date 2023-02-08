<?php
/**
 * Plugin Name:  Fish Rules API Integration
 * Description:  Pull regulation and species data from the Fish Rules API (requires API credentials).
 * Version:      0.0.1
 * Plugin URI:   https://github.com/happyprime/fish-rules-api-integration/
 * Author:       Happy Prime
 * Author URI:   https://happyprime.co
 * Text Domain:  fish-rules-api-integration
 * Requires PHP: 7.4
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * @package fish-rules-api-integration
 */

namespace FishRulesAPIIntegration;

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

require_once __DIR__ . '/blocks/all-regulations/index.php';
require_once __DIR__ . '/blocks/species-regulations/index.php';
require_once __DIR__ . '/includes/api-import.php';
require_once __DIR__ . '/includes/options-page.php';
require_once __DIR__ . '/includes/post-type-species.php';
