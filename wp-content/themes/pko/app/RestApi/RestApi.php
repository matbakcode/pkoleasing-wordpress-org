<?php

namespace WCD;

/**
 * Class RestAPI
 * @package WCD
 */
class RestAPI
{
	/**
	 * RestAPI constructor.
	 */
	public function __construct()
	{
		$instance = $this;
		add_action('rest_api_init', [$this, 'enable_rest_endpoints']);
	}

	/**
	 * Define list of API modules / Items
	 */
	public function enable_rest_endpoints()
	{
		new \WCD\RestAPI\Sandbox();
	}
}
