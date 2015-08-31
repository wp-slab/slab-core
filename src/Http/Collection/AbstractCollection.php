<?php

namespace Slab\Core\Http\Collection;

/**
 * Abstract Collection
 *
 * @package default
 * @author Luke Lanchester
 **/
abstract class AbstractCollection {


	/**
	 * @var array Collection data
	 **/
	protected $data = [];


	/**
	 * Set data
	 *
	 * @param string|array Key or data
	 * @param mixed Data
	 * @return void
	 **/
	public function set($key, $value = null) {

		if(is_array($key)) {
			$this->data = $key;
		} else {
			$this->data[$key] = $value;
		}

	}



	/**
	 * Get an item
	 *
	 * @param string Key
	 * @param mixed Default
	 * @return mxied Value
	 **/
	public function get($key, $default = null) {

		return array_key_exists($key, $this->data) ? $this->data[$key] : $default;

	}



	/**
	 * Get all data
	 *
	 * @return array Data
	 **/
	public function all() {

		return $this->data;

	}



}
