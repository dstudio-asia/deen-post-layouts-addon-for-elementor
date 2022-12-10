<?php
/**
 * Plugin Name: Deen Post Layouts Addon For Elementor
 * Description: Create an appealing blog layout using creative styles. Filter your blog posts and showcases to suit your needs.
 * Version: 1.0.1
 * Requires at least: 5.2
 * Requires PHP: 7.2
 * Elementor tested up to: 3.8.0
 * Author: Debuggers Studio
 * Text Domain: deen-post-layouts-addon
 * Domain Path: /languages
 */
 
function deen_post_layout_addon() {

	require_once( __DIR__ . '/includes/deen.php' );
    
	\DeenPostLayoutAddon\DeenPostLayout::instance();

}
add_action( 'plugins_loaded', 'deen_post_layout_addon' );