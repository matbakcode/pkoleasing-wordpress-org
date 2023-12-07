<?php

namespace WCD;

/**
 * Class GutenbergBlocks
 * @package WCD
 */
class GutenbergBlocks
{
	/**
	 * @var mixed
	 */
	private $_blocks_enabled;

	/**
	 * @var mixed
	 */
	private $_blocks_path;

	/**
	 * GutenbergBlocks constructor.
	 * @param $blocksConfig
	 */
	public function __construct($blocksConfig)
	{
		// read block
		$this->_blocks_enabled = $blocksConfig['blocks'];
		$this->_blocks_path = $blocksConfig['path'];

		// register gutenberg blocks
		add_action('init', [$this, 'register_blocks']);
	}

	/**
	 * Reads blocks defined in config and fires their registration in WP
	 */
	public function register_blocks()
	{
        foreach ($this->_blocks_enabled as $blockSlug => $blockData)
        {

            // load block config file if exists, otherwise use default rendering method
            if (file_exists($this->_blocks_path . '/' . $blockSlug . '/plugin.php')) {
                require_once $this->_blocks_path . '/' . $blockSlug . '/plugin.php';
                add_action( 'widgets_init', 'cards_cgb_block_assets' );
            }


        }
	}


}
