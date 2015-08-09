<?php

namespace Slab\Core\Http;

use OutOfBoundsException;
use RuntimeException;

/**
 * HTTP Request
 *
 * @package default
 * @author Luke Lanchester
 **/
class Request implements RequestInterface {


	/**
	 * Create a Request object from the current request globals
	 *
	 * @return Slab\Core\Http\Request
	 **/
	public static function createFromGlobals() {

		$request = new static;

		if(isset($_SERVER['REQUEST_METHOD'])) {
			$request->setMethod($_SERVER['REQUEST_METHOD']);
		}

		if(isset($_SERVER['HTTPS']) and $_SERVER['HTTPS'] === 'on') {
			$request->setScheme('https');
		} elseif(isset($_SERVER['HTTP_X_FORWARDED_PROTO'])) {
			$request->setScheme($_SERVER['HTTP_X_FORWARDED_PROTO']);
		}

		if(isset($_SERVER['HTTP_HOST'])) {
			$request->setHost($_SERVER['HTTP_HOST']);
		}

		if(isset($_SERVER['SERVER_PORT'])) {
			$request->setPort($_SERVER['SERVER_PORT']);
		}

		if(isset($_SERVER['REQUEST_URI'])) {
			$request->setPath(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
		}

		if(isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
			$request->setIp($_SERVER['HTTP_X_FORWARDED_FOR']);
		} elseif(isset($_SERVER['REMOTE_ADDR'])) {
			$request->setIp($_SERVER['REMOTE_ADDR']);
		}

		if(isset($_SERVER['HTTP_X_REQUESTED_WITH'])) {
			$request->setRequestedWith($_SERVER['HTTP_X_REQUESTED_WITH']);
		}

		if(isset($_SERVER['HTTP_ACCEPT_LANGUAGE'])) {
			$request->setAcceptLanguage($_SERVER['HTTP_ACCEPT_LANGUAGE']);
		}

		if(isset($_SERVER['HTTP_REFERER'])) {
			$request->setReferer($_SERVER['HTTP_REFERER']);
		}

		if(isset($_SERVER['HTTP_USER_AGENT'])) {
			$request->setUserAgent($_SERVER['HTTP_USER_AGENT']);
		}

		$request->query->set($_GET);
		$request->body->set($_POST);
		$request->files->set($_FILES);

		return $request;

	}



	/**
	 * Create a Request
	 *
	 * @param string Method
	 * @param string URL
	 * @param array Body data
	 * @param array Files data
	 * @return Slab\Core\Http\Request
	 **/
	public static function create($method, $url, array $_body = null, array $_files = null) {

		$parts = parse_url($url);

		if($parts === false) {
			throw new RuntimeException('Malformed URL passed to Slab Request');
		}

		$request = new static;

		$request->setMethod($method);

		if(isset($parts['scheme'])) {
			$request->setScheme($parts['scheme']);
		}

		if(isset($parts['host'])) {
			$request->setHost($parts['host']);
		}

		if(isset($parts['port'])) {
			$request->setPort($parts['port']);
		}

		if(isset($parts['path'])) {
			$request->setPath($parts['path']);
		}

		if(isset($parts['query'])) {
			parse_str($parts['query'], $_get);
			if(!empty($_get)) {
				$request->query->set($_get);
			}
		}

		if(!empty($_body)) {
			$request->body->set($_body);
		}

		if(!empty($_files)) {
			$request->files->set($_files);
		}

		return $request;

	}


	/**
	 * @var Slab\Core\Http\QueryCollection
	 **/
	public $query;


	/**
	 * @var Slab\Core\Http\BodyCollection
	 **/
	public $body;


	/**
	 * @var Slab\Core\Http\FilesCollection
	 **/
	public $files;


	/**
	 * @var Slab\Core\Http\AttributeCollection
	 **/
	public $attributes;


	/**
	 * @var array Allowed methods
	 **/
	protected $allowed_methods = ['GET'=>1, 'POST'=>1, 'PUT'=>1, 'DELETE'=>1, 'HEAD'=>1, 'OPTIONS'=>1];


	/**
	 * @var array Allowed schemes
	 **/
	protected $allowed_schemes = ['http'=>1, 'https'=>1];


	/**
	 * @var string Method
	 **/
	protected $method = 'GET';


	/**
	 * @var string Scheme
	 **/
	protected $scheme = 'http';


	/**
	 * @var string Is secure
	 **/
	protected $is_secure = false;


	/**
	 * @var string Host
	 **/
	protected $host;


	/**
	 * @var string Port
	 **/
	protected $port = 80;


	/**
	 * @var string Path
	 **/
	protected $path = '/';


	/**
	 * @var string Ip
	 **/
	protected $ip;


	/**
	 * @var string Requested_with
	 **/
	protected $requested_with;


	/**
	 * @var string Is_ajax
	 **/
	protected $is_ajax = false;


	/**
	 * @var string Accepted languages
	 **/
	protected $language;


	/**
	 * @var string Referer
	 **/
	protected $referer;


	/**
	 * @var string Useragent
	 **/
	protected $useragent;


	/**
	 * Constructor
	 *
	 * @return void
	 **/
	public function __construct() {

		$this->query      = new QueryCollection;
		$this->body       = new BodyCollection;
		$this->files      = new FilesCollection;
		$this->attributes = new AttributeCollection;

	}



	/**
	 * Set method
	 *
	 * @param string Method
	 * @return void
	 **/
	public function setMethod($method) {

		$method = strtoupper($method);

		if(!array_key_exists($method, $this->allowed_methods)) {
			throw new RuntimeException("Unknown method requested: $method");
		}

		$this->method = $method;

	}



	/**
	 * Get method
	 *
	 * @return string Method
	 **/
	public function getMethod() {

		return $this->method;

	}



	/**
	 * Set scheme
	 *
	 * @param string Scheme
	 * @return void
	 **/
	public function setScheme($scheme) {

		$scheme = strtolower($scheme);

		if(!array_key_exists($scheme, $this->allowed_schemes)) {
			throw new RuntimeException("Unknown scheme requested: $scheme");
		}

		$this->scheme = $scheme;
		$this->is_secure = ($scheme === 'https');

	}



	/**
	 * Get scheme
	 *
	 * @return string Scheme
	 **/
	public function getScheme() {

		return $this->scheme;

	}



	/**
	 * Returns true if scheme is https
	 *
	 * @return bool True if https
	 **/
	public function isSecure() {

		return $this->is_secure;

	}



	/**
	 * Set host
	 *
	 * @param string Host
	 * @return void
	 **/
	public function setHost($host) {

		$this->host = strtolower(trim($host));

	}



	/**
	 * Get host
	 *
	 * @return string Host
	 **/
	public function getHost() {

		return $this->host;

	}



	/**
	 * Set port
	 *
	 * @param string Port
	 * @return void
	 **/
	public function setPort($port) {

		$port = intval($port);

		if($port <= 0 or $port > 65535) {
			throw new OutOfBoundsException("Request port out of bounds: $port");
		}

		$this->port = $port;

	}



	/**
	 * Get port
	 *
	 * @return string Port
	 **/
	public function getPort() {

		return $this->port;

	}



	/**
	 * Set path
	 *
	 * @param string Path
	 * @return void
	 **/
	public function setPath($path) {

		$this->path = '/' . ltrim($path, '/');

	}



	/**
	 * Get path
	 *
	 * @return string Path
	 **/
	public function getPath() {

		return $this->path;

	}



	/**
	 * Set IP
	 *
	 * @param string IP
	 * @return void
	 **/
	public function setIp($ip) {

		$ip = filter_var($ip, FILTER_VALIDATE_IP);

		$this->ip = $ip ?: null;

	}



	/**
	 * Get IP
	 *
	 * @return string IP
	 **/
	public function getIp() {

		return $this->ip;

	}



	/**
	 * Set requested with
	 *
	 * @param string Requested with
	 * @return void
	 **/
	public function setRequestedWith($with) {

		$this->requested_with = $with;

		$this->is_ajax = (strtolower($with) === 'xmlhttprequest');

	}



	/**
	 * Get requested with
	 *
	 * @return string Requested with
	 **/
	public function getRequestedwith() {

		return $this->requested_with;

	}



	/**
	 * Returns true if the request was with XMLHttpRequest
	 *
	 * @return bool True if ajax
	 **/
	public function isAjax() {

		return $this->is_ajax;

	}



	/**
	 * Set accept language
	 *
	 * @param string Accept language
	 * @return void
	 **/
	public function setAcceptLanguage($language) {

		$this->language = $language;

	}



	/**
	 * Get accept language
	 *
	 * @return string Accept language
	 **/
	public function getAcceptLanguage() {

		return $this->language;

	}



	/**
	 * Set referer
	 *
	 * @param string Referer
	 * @return void
	 **/
	public function setReferer($referer) {

		$this->referer = trim($referer);

	}



	/**
	 * Get referer
	 *
	 * @return string Referer
	 **/
	public function getReferer() {

		return $this->referer;

	}



	/**
	 * Set useragent
	 *
	 * @param string Useragent
	 * @return void
	 **/
	public function setUserAgent($ua) {

		$this->useragent = trim($ua);

		// @todo is_mobile
		// @todo is_tablet

	}



	/**
	 * Get useragent
	 *
	 * @return string Useragent
	 **/
	public function getUserAgent() {

		return $this->useragent;

	}



}
