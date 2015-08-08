<?php

namespace Slab\Core;

/**
 * Slab Autoloader
 *
 * @package slab\core
 * @author Luke Lanchester
 **/
class Autoloader {


	/**
	 * @var array Registered locations
	 **/
	protected $map = [];


	/**
	 * Constructor
	 *
	 * @return void
	 **/
	public function __construct() {

		$this->registerAutoloader();

	}



	/**
	 * Register a PSR-4 compatible loader
	 *
	 * @param string Namespace
	 * @param string Class directory
	 * @return void
	 **/
	public function registerNamespace($namespace, $directory) {

		$namespace = trim($namespace, '\\');
		$directory = rtrim($directory, '/');

		$this->map[] = [
			'type'       => 'namespace', // @todo implement
			'namespace'  => $namespace . '\\',
			'directory'  => $directory . '/',
			'prefix_len' => strlen($namespace) + 1,
		];

	}



	/**
	 * Autoload a requested class if known
	 *
	 * @param string Class name
	 * @return void
	 **/
	public function splCallback($class) {

		foreach($this->map as $test) {

			if(substr_compare($class, $test['namespace'], 0, $test['prefix_len']) !== 0) {
				continue;
			}

			$file = substr($class, $test['prefix_len']);
			$file = str_replace('\\', '/', $file);
			$file = $test['directory'] . $file . '.php';

			if(is_file($file)) {
				include $file;
			}

		}

		return false;

	}



	/**
	 * Register the autoloader
	 *
	 * @return void
	 **/
	protected function registerAutoloader() {

		spl_autoload_register([$this, 'splCallback']);

	}



}
