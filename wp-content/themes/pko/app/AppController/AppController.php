<?php

namespace WCD;
/**
 * Class AppController
 * @package WCD
 */
class AppController
{
	/**
	 * AppController constructor.
	 * @param $site
	 * @param $config
	 */
	function __construct($site, $config)
	{

		// init REST API
		new RestAPI();

		// init Config
		new WPSiteConfig($site, $config);

		// init CPT if defined
		if (is_array($config['cpt']) && count($config['cpt']))
			new PostTypes($config['cpt']);

//		// init defined Gutenberg Blocks options
		if (isset($config['gutenberg_blocks']) && count($config['gutenberg_blocks']))
			new GutenbergBlocks($config['gutenberg_blocks']);

	}

}


