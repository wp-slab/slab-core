<?php

namespace Slab\Core;

use Slab\Core\Http\Request;

/**
 * Initialize Slab Core
 *
 * @return void
 **/
function slab_core_init() {

	// $autoloader = new Autoloader;
	// $autoloader->registerNamespace('Slab\Core', SLAB_CORE_DIR . 'src');

	$slab = Application::instance();
	$slab->singleton('Slab\Core\Application', $slab);
	$slab->alias('Slab\Core\ContainerInterface', 'Slab\Core\Application');

	// $slab->singleton('Slab\Core\Autoloader', $autoloader);
	// $slab->alias('autoloader', 'Slab\Core\Autoloader');

	$slab->singleton('Slab\Core\Http\RequestInterface', function(){
		return Request::createFromGlobals();
	});
	$slab->alias('request', 'Slab\Core\Http\RequestInterface');

	do_action('slab_init', $slab);
	do_action('slab_boot', $slab);
	do_action('slab_loaded', $slab);

}
