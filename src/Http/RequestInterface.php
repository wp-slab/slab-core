<?php

namespace Slab\Core\Http;

/**
 * Request Interface
 *
 * @package default
 * @author Luke Lanchester
 **/
interface RequestInterface {


	/**
	 * Set method
	 *
	 * @param string Method
	 * @return void
	 **/
	public function setMethod($method);


	/**
	 * Get method
	 *
	 * @return string Method
	 **/
	public function getMethod();


	/**
	 * Set scheme
	 *
	 * @param string Scheme
	 * @return void
	 **/
	public function setScheme($scheme);


	/**
	 * Get scheme
	 *
	 * @return string Scheme
	 **/
	public function getScheme();


	/**
	 * Returns true if scheme is https
	 *
	 * @return bool True if https
	 **/
	public function isSecure();


	/**
	 * Set host
	 *
	 * @param string Host
	 * @return void
	 **/
	public function setHost($host);


	/**
	 * Get host
	 *
	 * @return string Host
	 **/
	public function getHost();


	/**
	 * Set port
	 *
	 * @param string Port
	 * @return void
	 **/
	public function setPort($port);


	/**
	 * Get port
	 *
	 * @return string Port
	 **/
	public function getPort();


	/**
	 * Set path
	 *
	 * @param string Path
	 * @return void
	 **/
	public function setPath($path);


	/**
	 * Get path
	 *
	 * @return string Path
	 **/
	public function getPath();


	/**
	 * Set IP
	 *
	 * @param string IP
	 * @return void
	 **/
	public function setIp($ip);


	/**
	 * Get IP
	 *
	 * @return string IP
	 **/
	public function getIp();


	/**
	 * Set requested with
	 *
	 * @param string Requested with
	 * @return void
	 **/
	public function setRequestedWith($with);


	/**
	 * Get requested with
	 *
	 * @return string Requested with
	 **/
	public function getRequestedwith();


	/**
	 * Returns true if the request was with XMLHttpRequest
	 *
	 * @return bool True if ajax
	 **/
	public function isAjax();


	/**
	 * Set accept language
	 *
	 * @param string Accept language
	 * @return void
	 **/
	public function setAcceptLanguage($language);


	/**
	 * Get accept language
	 *
	 * @return string Accept language
	 **/
	public function getAcceptLanguage();


	/**
	 * Set referer
	 *
	 * @param string Referer
	 * @return void
	 **/
	public function setReferer($referer);


	/**
	 * Get referer
	 *
	 * @return string Referer
	 **/
	public function getReferer();


	/**
	 * Set useragent
	 *
	 * @param string Useragent
	 * @return void
	 **/
	public function setUserAgent($ua);


	/**
	 * Get useragent
	 *
	 * @return string Useragent
	 **/
	public function getUserAgent();


}
