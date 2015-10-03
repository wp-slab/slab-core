<?php

/**
 * Get a slab instance or resolve a class
 *
 * @param string Class name to resolve
 * @return mixed Value
 **/
if(!function_exists('slab')) {
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
}


/**
 * Get a value from an array by key
 *
 * @param array Array
 * @param string Key
 * @param mixed Default
 * @return mixed Value
 **/
if(!function_exists('array_get')) {
function array_get(array $arr, $key, $default = null) {

	return array_key_exists($key, $arr) ? $arr[$key] : $default;

}
}



/**
 * Ensure value is between the min and max, inclusive
 *
 * @param int|float Value
 * @param int|float Minimum value
 * @param int|float Maximum value
 * @return int|float Clamped value
 **/
if(!function_exists('clamp')) {
function clamp($value, $min, $max) {

	return max($min, min($value, $max));

}
}


/**
 * Output print_r wrapped in pre tags
 *
 * @param mixed Var
 * @return void
 **/
if(!function_exists('_print_r')) {
function _print_r() {
	echo '<pre>';
	foreach(func_get_args() as $var) {
		print_r($var);
	}
	echo '</pre>';
}
}


/**
 * Output var_dump wrapped in pre tags
 *
 * @param mixed Var
 * @return void
 **/
if(!function_exists('_var_dump')) {
function _var_dump() {
	echo '<pre>';
	foreach(func_get_args() as $var) {
		var_dump($var);
	}
	echo '</pre>';
}
}
