<?php namespace Revel;

use GuzzleHttp\Client;
use Revel\Api\Api;
use Revel\Api\Categories;
use Revel\Api\Establishments;
use Revel\Api\Modifiers;
use Revel\Api\Ordering;
use Revel\Api\Products;
use Revel\Api\Discounts;

class Revel {

	/** @var string */
	private $_domain;

	/** @var string */
	private $_secret;

	/** @var string */
	private $_key;

	/** @var Client */
	private $_client;

	/** @var Api[] */
	private $_providers = [];

	/**
	 * Revel constructor.
	 *
	 * @param string $domain The Revel domain prefix.
	 * @param string $secret The Revel API secret, provided by Revel.
	 * @param string $key The Revel API key, provided by Revel.
	 */
	public function __construct($domain, $secret, $key) {
		$this->_client = new Client();
		$this->_domain = $domain;
		$this->_secret = $secret;
		$this->_key = $key;
	}

	/**
	 * Get an API provider.
	 *
	 * @param string $name The API provider name.
	 *
	 * @return Api|mixed
	 */
	private function _provider($name) {
		if (!array_key_exists($name, $this->_providers)) {
			$this->_providers[$name] = new $name($this);
		}

		return $this->_providers[$name];
	}

	/**
	 * Get the Guzzle client.
	 *
	 * @return Client
	 */
	public function guzzle() {
		return $this->_client;
	}

	/**
	 * Get the API-AUTHENTICATION header.
	 *
	 * @return string
	 */
	public function auth() {
		return $this->_key . ':' . $this->_secret;
	}

	/**
	 * Get the full API URL e.g. `https://<domain>.revelup.com`. Never contains a trailing slash.
	 *
	 * @return string
	 */
	public function fullUrl() {
		return 'https://' . $this->_domain . '.revelup.com';
	}

	/**
	 * @return Categories
	 */
	public function categories() {
		return $this->_provider(Categories::class);
	}

	/**
	 * @return Products
	 */
	public function products() {
		return $this->_provider(Products::class);
	}

	/**
	 * @return Establishments
	 */
	public function establishments() {
		return $this->_provider(Establishments::class);
	}

	/**
	 * @return Ordering
	 */
	public function ordering() {
		return $this->_provider(Ordering::class);
	}

	/**
	 * @return Discounts
	 */
	public function discounts() {
		return $this->_provider(Discounts::class);
	}

	/**
	 * @return Discounts
	 */
	public function modifiers() {
		return $this->_provider(Modifiers::class);
	}

}