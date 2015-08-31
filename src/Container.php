<?php

namespace Slab\Core;

use ArrayAccess;
use BadMethodCallException;
use Closure;
use ReflectionClass;
use RuntimeException;

/**
 * IoC Container
 *
 * @package default
 * @author Luke Lanchester
 **/
class Container implements ArrayAccess {


	/**
	 * @var array Map of bindings
	 **/
	protected $bindings = [];


	/**
	 * @var array Binding aliases
	 **/
	protected $aliases = [];


	/**
	 * @var array Singleton instances
	 **/
	protected $instances = [];


	/**
	 * @var array Class reflectors
	 **/
	protected $class_reflectors = [];


	/**
	 * @var array Method reflectors
	 **/
	protected $method_reflectors = [];


	/**
	 * Bind an alias to another binding
	 *
	 * @param string Aliased key
	 * @param string Concrete binding
	 * @return void
	 **/
	public function alias($key, $concrete) {

		$this->aliases[$key] = $concrete;

	}



	/**
	 * Set a value as a singleton
	 *
	 * @param string Key
	 * @param mixed Value
	 * @return void
	 **/
	public function singleton($key, $value = null) {

		return $this->bind($key, $value, true);

	}



	/**
	 * Bind a value to the container
	 *
	 * @param string Key
	 * @param mixed Value
	 * @return void
	 **/
	public function bind($key, $value = null, $singleton = false) {

		if($value === null) {
			$value = $key;
		}

		$this->bindings[$key] = [
			'singleton' => (bool) $singleton,
			'value'     => $value,
		];

	}



	/**
	 * Resolve a class from the container
	 *
	 * @param string Class name
	 * @return mixed Value
	 **/
	public function make($key) {

		if(array_key_exists($key, $this->aliases)) {
			$key = $this->aliases[$key];
		}

		if(array_key_exists($key, $this->bindings)) {
			return $this->build($key);
		}

		return $this->resolveClass($key);

	}



	/**
	 * Make and execute a method on a class
	 *
	 * @param string Callback e.g. MyClass@myMethod
	 * @param array Optional method args
	 * @return mixed Result
	 **/
	public function makeMethod($str, array $args = null) {

		if(strpos($str, '@') === false) {
			return null;
		}

		list($class, $method) = explode('@', $str, 2);

		$obj = $this->make($class);

		return $this->resolveMethod($obj, $method, $args);

	}



	/**
	 * Does an element exist in the container?
	 *
	 * @param mixed Offset
	 * @return boolean
	 **/
	public function offsetExists($offset) {

		return array_key_exists($offset, $this->bindings);

	}



	/**
	 * Get an element from the container
	 *
	 * @param mixed Offset
	 * @return mixed Object
	 **/
	public function offsetGet($offset) {

		return $this->make($offset);

	}



	/**
	 * Bind an element to the container
	 *
	 * @param mixed Offset
	 * @return void
	 **/
	public function offsetSet($offset, $value) {

		return $this->bind($offset, $value);

	}



	/**
	 * Delete a binding
	 *
	 * @param mixed Offset
	 * @return void
	 **/
	public function offsetUnset($offset) {

		unset($this->bindings[$offset]);

	}



	/**
	 * Get a binding
	 *
	 * @param string Key
	 * @return object Value
	 **/
	public function __get($key) {

		return $this->make($key);

	}



	/**
	 * Set a binding
	 *
	 * @param string Key
	 * @param mixed Value
	 * @return void
	 **/
	public function __set($key, $value) {

		return $this->bind($key, $value);

	}



	/**
	 * Build an object
	 *
	 * @param string Key
	 * @return object Object
	 **/
	protected function build($key) {

		if(array_key_exists($key, $this->instances)) {
			return $this->instances[$key];
		}

		$map = $this->bindings[$key];

		if(is_object($map['value'])) {
			$obj = ($map['value'] instanceof Closure) ? $map['value']->__invoke($this) : $map['value'];
		} else {
			$obj = $this->resolveClass($map['value']);
		}

		if($map['singleton'] === true) {
			$this->instances[$key] = $obj;
		}

		return $obj;

	}



	/**
	 * Resolve class
	 *
	 * @param string Class name
	 * @return object Resolved object
	 **/
	protected function resolveClass($class) {

		$reflector = $this->getClassReflector($class);

		$params = $this->getMethodParams($reflector, '__construct');

		if(empty($params)) {
			return new $class;
		}

		$args = [];

		foreach($params as $param) {

			if($param->isOptional()) {
				break;
			}

			$param_class = $param->getClass();
			if(!$param_class) {
				throw new RuntimeException("Unresolvable dependency for $class: " . $param->getName());
			}

			$arg = $this->make($param_class->getName());
			if(!$arg) {
				throw new RuntimeException("Unknown dependency for $class: " . $param->getName());
			}

			$args[] = $arg;

		}

		return $reflector->newInstanceArgs($args);

	}



	/**
	 * Fire a method on an object after resolving any dependencies
	 *
	 * @param stdClass Object
	 * @param string Method name
	 * @param array Optional args
	 * @return mixed Result
	 **/
	protected function resolveMethod($obj, $method, array $input_args = null) {

		$class = get_class($obj);
		$key = "$class.$method";
		$reflector = $this->getClassReflector($class);

		$params = $this->getMethodParams($reflector, $method);

		if(empty($params)) {
			if(empty($input_args)) {
				return $obj->$method();
			} else {
				return call_user_func_array([$obj, $method], $input_args);
			}
		}

		$args = [];

		foreach($params as $param) {

			if($param->isOptional()) {
				break;
			}

			$param_class = $param->getClass();
			if(!$param_class) {
				if(empty($input_args)) {
					throw new RuntimeException("Unresolvable dependency for $class: " . $param->getName());
				}
				$args[] = array_shift($input_args);
			}

			$arg = $this->make($param_class->getName());
			if(!$arg) {
				throw new RuntimeException("Unknown dependency for $class: " . $param->getName());
			}

			$args[] = $arg;

		}

		if(!empty($input_args)) {
			$args = array_merge($args, $input_args);
		}

		return call_user_func_array([$obj, $method], $args);

	}



	/**
	 * Get reflector for class
	 *
	 * @param string Class name
	 * @return ReflectionClass
	 **/
	protected function getClassReflector($class) {

		if(array_key_exists($class, $this->class_reflectors)) {
			return $this->class_reflectors[$class];
		}

		return $this->class_reflectors[$class] = new ReflectionClass($class);

	}



	/**
	 * Get params for a class method
	 *
	 * @param ReflectionClass
	 * @return array ReflectionParameter
	 **/
	protected function getMethodParams(ReflectionClass $reflector, $method_name) {

		$class = $reflector->getName();
		$key = "$class.$method_name";

		if(array_key_exists($key, $this->method_reflectors)) {
			return $this->method_reflectors[$key];
		}

		if(!method_exists($class, $method_name)) {
			return $this->method_reflectors[$key] = [];
		}

		$method = $reflector->getMethod($method_name);
		if(!$method) {
			return $this->method_reflectors[$key] = [];
		}

		$params = $method->getParameters();
		if(empty($params)) {
			return $this->method_reflectors[$key] = [];
		}

		return $this->method_reflectors[$key] = $params;

	}



}
