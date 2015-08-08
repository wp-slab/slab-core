<?php

class ContainerTestClass {}

/**
 * Container Test
 *
 * @package default
 * @author Luke Lanchester
 **/
class ContainerTest extends PHPUnit_Framework_TestCase {


	/**
	 * @var Slab\Core\Container
	 **/
	protected $container;


	/**
	 * Set up
	 *
	 * @return void
	 **/
	public function setUp() {

		$this->container = new Slab\Core\Container;

	}



	/**
	 * Test container can be instantiated
	 *
	 * @return void
	 **/
	public function testInstantiate() {

		$this->assertInstanceOf('Slab\Core\Container', $this->container);

	}



	/**
	 * Test can bind a class
	 *
	 * @return void
	 **/
	public function testBindClass() {

		$key = 'exampleClass';
		$value = 'ContainerTestClass';

		$this->container->bind($key, $value);

		$this->assertInstanceOf($value, $this->container->make($key));

	}



	/**
	 * Test can bind an object
	 *
	 * @return void
	 **/
	public function testBindObject() {

		$key = 'exampleObject';
		$value = new stdClass;

		$this->container->bind($key, $value);

		$this->assertEquals($value, $this->container->make($key));

	}



	/**
	 * Test binding an object as a singleton
	 *
	 * @return void
	 **/
	public function testBindSingletonObject() {

		$key = 'example';
		$value = new ContainerTestClass;

		$this->container->singleton($key, $value);

		$this->assertEquals($value, $this->container->make($key));
		$this->assertEquals($value, $this->container->make($key));

	}



	/**
	 * Test can bind a class as a singleton
	 *
	 * @return void
	 **/
	public function testBindSingletonClass() {

		$key = 'example';
		$value = 'ContainerTestClass';

		$this->container->bind($key, $value);

		$result1 = $this->container->make($key);
		$result2 = $this->container->make($key);

		$this->assertInstanceOf($value, $result1);
		$this->assertInstanceOf($value, $result2);
		$this->assertEquals($result1, $result2);

	}



	/**
	 * Test can bind a closure as a singleton
	 *
	 * @return void
	 **/
	public function testBindSingletonClosure() {

		$key = 'example';
		$value = function(){
			return new ContainerTestClass;
		};

		$this->container->bind($key, $value);

		$result1 = $this->container->make($key);
		$result2 = $this->container->make($key);

		$this->assertInstanceOf('ContainerTestClass', $result1);
		$this->assertInstanceOf('ContainerTestClass', $result2);
		$this->assertEquals($result1, $result2);

	}



}
