<?php

namespace WCD\RestAPI;

use WCD\RestAPIItem;

/**
 * Class Sandbox
 * @package WCD\RestAPI
 */
class Sandbox extends RestAPIItem
{
	/**
	 * Sandbox constructor.
	 */
	public function __construct()
	{
		parent::__construct();
		$this->define_rest_endpoints();
	}

	/**
	 * Create list of REST Endpoints in module
	 */
	private function define_rest_endpoints()
	{
		$this->register('get', 'sandbox', [$this, 'get_callback']);
	}

	/**
	 * REST endpoint callback
	 * @return string
	 */
	public function get_callback()
	{
		return 'hello';
	}

}
