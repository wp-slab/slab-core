<?php

namespace Slab\Core\Util;

/**
 * Basic Collection
 *
 * @package default
 * @author Luke Lanchester
 **/
interface CollectionInterface {


	/**
	 * Set data
	 *
	 * @param string|array Key or data
	 * @param mixed Data
	 * @return void
	 **/
	public function set($key, $value = null);


	/**
	 * Get an item
	 *
	 * @param string Key
	 * @param mixed Default
	 * @return mxied Value
	 **/
	public function get($key, $default = null);


	/**
	 * Get all data
	 *
	 * @return array Data
	 **/
	public function all();


}
