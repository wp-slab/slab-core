<?php

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
