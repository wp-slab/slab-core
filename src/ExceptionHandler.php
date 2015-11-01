<?php

namespace Slab\Core;

use Exception;
use Symfony\Component\Debug\ExceptionHandler as SymfonyExceptionHandler;

use Slab\Core\Http\RequestInterface;
use Slab\Core\Http\Response;

/**
 * Exception Handler
 *
 * @package default
 * @author Luke Lanchester
 **/
class ExceptionHandler {


	/**
	 * @var Slab\Core\Http\RequestInterface
	 **/
	protected $request;


	/**
	 * Constructor
	 *
	 * @param Slab\Core\Http\RequestInterface
	 * @return void
	 **/
	public function __construct(RequestInterface $request) {

		$this->request = $request;

	}



	/**
	 * Handle an exception
	 *
	 * @param Exception
	 * @return void
	 **/
	public function handle(Exception $e) {

		$this->log($e, $this->request);

		$response = $this->render($e, $this->request);

		if($response and is_a($response, 'Slab\Core\Http\ResponseInterface')) {
			$response->serve();
		}

		die();

	}



	/**
	 * Log exceptions
	 *
	 * @return void
	 **/
	public function log(Exception $e) {

		// @todo monolog

	}



	/**
	 * Output info
	 *
	 * @return Slab\Core\Http\ResponseInterface
	 **/
	public function render(Exception $e) {

		if(getenv('DEBUG') !== 'true') {
			return new Response('An error occurred', 500);
		}

		(new SymfonyExceptionHandler)->handle($e);

	}



}
