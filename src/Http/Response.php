<?php

namespace Slab\Core\Http;

/**
 * HTTP Response
 *
 * @package default
 * @author Luke Lanchester
 **/
class Response implements ResponseInterface {


	/**
	 * @var mixed Data
	 **/
	protected $data;


	/**
	 * @var string Content type
	 **/
	protected $content_type;


	/**
	 * Constructor
	 *
	 * @param mixed Data
	 * @return void
	 **/
	public function __construct($data = null) {

		$this->setData($data);

	}



	/**
	 * Set data
	 *
	 * @param mixed Data
	 * @return void
	 **/
	public function setData($data) {

		$this->data = $data;

	}



	/**
	 * Get data
	 *
	 * @return mixed Data
	 **/
	public function getData() {

		return $this->data;

	}



	/**
	 * Set content type
	 *
	 * @param string Content type
	 * @return void
	 **/
	public function setContentType($type) {

		$this->content_type = $type;

	}



	/**
	 * Get content type
	 *
	 * @return string Content type
	 **/
	public function getContentType() {

		return $this->content_type;

	}



	/**
	 * Output JSON
	 *
	 * @return void
	 **/
	public function serve() {

		if(!headers_sent()) {
			header('Content-Type: ' . $this->getContentType());
		}

		echo (string) $this->getData();

	}



}
