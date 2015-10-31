<?php

namespace Slab\Core\Http;

use Symfony\Component\HttpFoundation\Response as SymfonyResponse;

/**
 * HTTP Response
 *
 * @package default
 * @author Luke Lanchester
 **/
class Response extends SymfonyResponse implements ResponseInterface {


	/**
	 * Serve the response
	 *
	 * @param Slab\Core\Http\RequestInterface
	 * @return void
	 **/
	public function serve(RequestInterface $request = null) {

		if($request === null) {
			$request = slab('request');
		}

		$this->prepare($request);

		$this->send();

	}



}
