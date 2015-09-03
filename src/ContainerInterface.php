<?php

namespace Slab\Core;

/**
 * IoC Container Interface
 *
 * @package default
 * @author Luke Lanchester
 **/
interface ContainerInterface {


	/**
	 * Bind an alias to another binding
	 *
	 * @param string Aliased key
	 * @param string Concrete binding
	 * @return void
	 **/
	public function alias($key, $concrete);


	/**
	 * Set a value as a singleton
	 *
	 * @param string Key
	 * @param mixed Value
	 * @return void
	 **/
	public function singleton($key, $value = null);


	/**
	 * Bind a value to the container
	 *
	 * @param string Key
	 * @param mixed Value
	 * @return void
	 **/
	public function bind($key, $value = null, $singleton = false);


	/**
	 * Resolve a class from the container
	 *
	 * @param string Class name
	 * @return mixed Value
	 **/
	public function make($key);


	/**
	 * Make and execute a method on a class
	 *
	 * @param string Callback e.g. MyClass@myMethod
	 * @param array Optional method args
	 * @return mixed Result
	 **/
	public function makeMethod($str, array $args = null);


	/**
	 * Fire a method on an object after resolving any dependencies
	 *
	 * @param stdClass Object
	 * @param string Method name
	 * @param array Optional args
	 * @return mixed Result
	 **/
	public function fireMethod($obj, $method, array $input_args = null);


}
