<?php
/*
Plugin Name: Slab &mdash; Core
Plugin URI: http://www.wp-slab.com/components/core
Description: The Slab framework. The core functionality to make your site better.
Version: 2.0.0
Author: Slab
Author URI: http://www.wp-slab.com
Created: 2014-06-30
Updated: 2015-08-08
Repo URI: github.com/wp-slab/slab-core
*/


// Define
define('SLAB_CORE_INIT', true);
define('SLAB_CORE_DIR', plugin_dir_path(__FILE__));
define('SLAB_CORE_URL', plugin_dir_url(__FILE__));
define('SLAB_CORE_START_TIME', microtime(true));
define('SLAB_CORE_START_MEMORY', memory_get_usage());


// Include
include SLAB_CORE_DIR . 'helpers.php';
include SLAB_CORE_DIR . 'functions.php';
include SLAB_CORE_DIR . 'src/Autoloader.php';


// Hooks
add_action('plugins_loaded', 'Slab\Core\slab_core_init', 5);
