<?php

namespace Slab\Core\Http;

/**
 * HTTP Response Interface
 *
 * @package default
 * @author Luke Lanchester
 **/
interface ResponseInterface {


	/**
	 * Output response
	 *
	 * @return void
	 **/
	public function serve();


}
