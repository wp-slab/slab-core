<?php

/**
 * Get a slab instance or resolve a class
 *
 * @param string Class name to resolve
 * @return mixed Value
 **/
function slab($class = null) {

	static $slab;

	if($slab === null) {
		$slab = Slab\Core\Application::instance();
	}

	if($class === null) {
		return $slab;
	}

	return $slab->make($class);

}


/**
 * Output print_r wrapped in pre tags
 *
 * @param mixed Var
 * @return void
 **/
function _print_r() {
	echo '<pre>';
	foreach(func_get_args() as $var) {
		print_r($var);
	}
	echo '</pre>';
}


/**
 * Output var_dump wrapped in pre tags
 *
 * @param mixed Var
 * @return void
 **/
function _var_dump() {
	echo '<pre>';
	foreach(func_get_args() as $var) {
		var_dump($var);
	}
	echo '</pre>';
}
