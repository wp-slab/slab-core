<?php

namespace Slab\Core\Http;

/**
 * JSON Response
 *
 * @package default
 * @author Luke Lanchester
 **/
class JsonResponse implements ResponseInterface {


	/**
	 * @var mixed Data
	 **/
	protected $data = null;


	/**
	 * @var bool If true, enable jsonp
	 **/
	protected $jsonp_enabled = false;


	/**
	 * @var string JSONP query string argument
	 **/
	protected $jsonp_query_key = 'jsonp';


	/**
	 * @var string JSON content type
	 **/
	protected $content_type = 'application/json';


	/**
	 * @var string JSONP content type
	 **/
	protected $jsonp_content_type = 'application/javascript';


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
	 * Set whether JSONP support is enabled
	 *
	 * @param bool Enabled?
	 * @return void
	 **/
	public function setJsonpEnabled($enabled) {

		$this->jsonp_enabled = (bool) $enabled;

	}



	/**
	 * Get whether JSONP support is enabled
	 *
	 * @return bool Enabled?
	 **/
	public function getJsonpEnabled() {

		return $this->jsonp_enabled;

	}



	/**
	 * Set JSONP query argument key
	 *
	 * @param string Query argument key
	 * @return void
	 **/
	public function setJsonpKey($key) {

		$this->jsonp_query_key = $key;

	}



	/**
	 * Get JSONP query argument key
	 *
	 * @return bool Query argument key
	 **/
	public function getJsonpKey() {

		return $this->jsonp_query_key;

	}



	/**
	 * Output JSON
	 *
	 * @return void
	 **/
	public function serve() {

		$output = json_encode($this->getData());

		$jsonp = $this->getJsonpCallback();

		if($jsonp) {
			$output = "$jsonp($output);";
			$header = $this->jsonp_content_type;
		} else {
			$header = $this->content_type;
		}

		if(!headers_sent()) {
			header("Content-Type: $header");
		}

		echo $output;

	}



	/**
	 * Get JSONP callback argument, if enabled & set
	 *
	 * @return string Callback
	 **/
	public function getJsonpCallback() {

		if($this->jsonp_enabled !== true) {
			return null;
		}

		$callback = slab('request')->query->get($this->jsonp_query_key);

		if(empty($callback)) {
			return null;
		}

		$callback = preg_replace('/[^a-zA-Z0-9-_]/', '', $callback);

		return !empty($callback) ? $callback : null;

	}



}
