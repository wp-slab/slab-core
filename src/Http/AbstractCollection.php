<?php

namespace Slab\Core\Http;

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



}
