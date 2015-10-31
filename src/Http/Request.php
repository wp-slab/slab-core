<?php

namespace Slab\Core\Http;

use Mobile_Detect;
use Symfony\Component\HttpFoundation\Request as SymfonyRequest;

/**
 * HTTP Request
 *
 * @package default
 * @author Luke Lanchester
 **/
class Request extends SymfonyRequest implements RequestInterface {


	/**
	 * @var Mobile_Detect
	 **/
	protected $device_detector;


	/**
	 * @var bool True if desktop
	 **/
	protected $is_desktop;


	/**
	 * @var bool True if tablet
	 **/
	protected $is_tablet;


	/**
	 * @var bool True if mobile
	 **/
	protected $is_mobile;


	/**
	 * Get client IP address
	 *
	 * @return string IP address
	 **/
	public function getIp() {

		return $this->getClientIp();

	}



	/**
	 * Get path
	 *
	 * @return string Path
	 **/
	public function getPath() {

		return $this->getPathInfo();

	}



	/**
	 * Get referer
	 *
	 * @return string Referer
	 **/
	public function getReferer() {

		return $this->headers->get('referer');

	}



	/**
	 * Get useragent
	 *
	 * @return string Useragent
	 **/
	public function getUserAgent() {

		return $this->headers->get('User-Agent');

	}


	/**
	 * Returns true if the request was with XMLHttpRequest
	 *
	 * @return bool True if ajax
	 **/
	public function isAjax() {

		return $this->isXmlHttpRequest();

	}


	/**
	 * Is the user using a desktop browser?
	 *
	 * @return bool True if desktop
	 **/
	public function isDesktop() {

		if($this->is_desktop !== null) {
			return $this->is_desktop;
		}

		$is_mobile = $this->isMobile();
		$is_tablet = $this->isTablet();

		return $this->is_desktop = (!$is_mobile and !$is_tablet);

	}



	/**
	 * Is the user using a mobile browser?
	 *
	 * @return bool True if mobile
	 **/
	public function isMobile() {

		if($this->is_mobile !== null) {
			return $this->is_mobile;
		}

		return $this->is_mobile = (bool) $this->getDeviceDetector()->isMobile();

	}



	/**
	 * Is the user using a tablet browser?
	 *
	 * @return bool True if tablet
	 **/
	public function isTablet() {

		if($this->is_desktop !== null) {
			return $this->is_desktop;
		}

		return $this->is_desktop = (bool) $this->getDeviceDetector()->isTablet();

	}



	/**
	 * Get device detector
	 *
	 * @return Mobile_Detect
	 **/
	public function getDeviceDetector() {

		if($this->device_detector !== null) {
			return $this->device_detector;
		}

		return $this->device_detector = new Mobile_Detect($this->headers->all(), $this->getUserAgent());

	}



}
