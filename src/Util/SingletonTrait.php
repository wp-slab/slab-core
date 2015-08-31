<?php

namespace Slab\Core\Util;

/**
 * Singleton Trait
 *
 * For when a singleton makes sense
 *
 * @package default
 * @author Luke Lanchester
 **/
trait SingletonTrait {


	/**
	 * @var static Instance
	 **/
	protected static $instance;


	/**
	 * Singleoton
	 *
	 * @return void
	 **/
	public static function instance() {

		if(static::$instance === null) {
			static::$instance = new static;
		}

		return static::$instance;

	}



}
