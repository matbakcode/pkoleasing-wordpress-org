<?php

namespace WCD;

/**
 * Class RestAPIItem
 * @package WCD
 */
class RestAPIItem
{
	/**
	 * @var mixed|string
	 */
	public $namespace = '';
	/**
	 * @var int
	 */
	public $version = 1;

	/**
	 * RestAPIItem constructor.
	 */
	public function __construct()
	{
		global $GLOBALS;
		// define app's API namespace
		$this->namespace = $GLOBALS['slug'];
	}

	/**
	 * Register API endpoint
	 * @param $method
	 * @param $route
	 * @param $callback
	 */
	public function register($method, $route, $callback)
	{
		register_rest_route($this->namespace . '/v' . $this->version, $route, [
			'methods' => is_array($method) ? $method : strtoupper($method),
			'callback' => $callback,
		]);
	}
}
