<?php

namespace WCD;

/**
 * Class WPSiteConfig
 * @package WCD
 */
class WPSiteConfig extends \Timber\Site
{
	/**
	 * @var
	 */
	private $_site;
	/**
	 * @var
	 */
	private $_config;

	/**
	 * WPSiteConfig constructor.
	 * @param $site
	 * @param $config
	 */
	function __construct($site, $config)
	{
		$this->_site = $site;
		$this->_config = $config;

		add_filter('timber/twig', array($this, 'add_to_twig'));
		add_action('init', array($this, 'add_theme_supports_for'));

		add_action('after_setup_theme', array($this, 'register_navigations'));
		add_action('after_setup_theme', array($this, 'set_templates_place'));

		add_action('wp_enqueue_scripts', array($this, 'theme_styles'));
		add_action('wp_enqueue_scripts', array($this, 'theme_scripts'), 10, 1);

		add_action('admin_enqueue_scripts', array($this, 'admin_styles'), 10, 1);
		add_filter('timber_context', array($this, 'add_to_context'));

		// Remove WP Emoji
		remove_action('wp_head', 'print_emoji_detection_script', 7);
		remove_action('wp_print_styles', 'print_emoji_styles');

		// Disable that freaking admin bar
		add_filter('show_admin_bar', '__return_false');

		add_filter('manage_media_posts_columns', array($this, 'add_media_columns'));
		add_action('manage_media_posts_custom_column', array($this, 'media_custom_column'), 10, 2);
		add_filter('wp_setup_nav_menu_item', array($this, 'setup_nav_menu_item'));

		remove_filter('nav_menu_description', 'strip_tags');

		parent::__construct();
	}

	/**
	 * Define supported features
	 */
	function add_theme_supports_for()
	{
		add_theme_support('post-formats');
		add_theme_support('post-thumbnails');
		add_theme_support('menus');
		add_theme_support('title-tag');
	}

	/**
	 * Register WP navigations
	 */
	function register_navigations()
	{
		register_nav_menus(array(
			'primary' => esc_html__('Primary menu', $GLOBALS['slug']),
			'secondary' => esc_html__('Secondary menu', $GLOBALS['slug']),
			'tertiary' => esc_html__('Tertiary menu', $GLOBALS['slug']),
			'social' => esc_html__('Social menu', $GLOBALS['slug'])
		));
	}

	/**
	 * Define Timber context
	 * @param $context
	 * @return mixed
	 */
	function add_to_context($context)
	{
		$context['nav'] = array(
			'primary' => new \TimberMenu('primary'),
			'secondary' => new \TimberMenu('secondary'),
			'tertiary' => new \TimberMenu('tertiary'),
			'social' => new \TimberMenu('social')
		);

		$context['site'] = $this;
		$context['current_user'] = new \TimberUser();


		// ACF Support Options page
		if (function_exists('get_fields'))
		{
			$context['options'] = get_fields('options');
		}

		return $context;
	}

	/**
	 * Add custom twig filters and functions
	 * @param $twig
	 * @return mixed
	 */
	function add_to_twig($twig)
	{

		$twig->addFunction(new \Timber\Twig_Function('display_read_time', array($this, 'display_read_time')));
		$twig->addFilter(new \Timber\Twig_Filter('slugify', function ($title) {
			return sanitize_title($title);
		}));

		return $twig;
	}

	/**
	 * Embed CSS files defined in config
	 */
	function theme_styles()
	{
		if (isset($this->_config['embed_css']) && count($this->_config['embed_css']))
		{
			foreach ($this->_config['embed_css'] as $handle => $path)
				if (file_exists(get_stylesheet_directory() . $path))
					wp_enqueue_style($handle, get_stylesheet_directory_uri() . $path, [], filemtime(get_stylesheet_directory() . $path), 'all');
		}
	}

	/**
	 * Embed JS files defined in config
	 */
	function theme_scripts()
	{
		$this->embed_localized_script();

		if (isset($this->_config['embed_js']) && count($this->_config['embed_js']))
		{
			foreach ($this->_config['embed_js'] as $handle => $path)
				if (file_exists(get_stylesheet_directory() . $path))
					wp_enqueue_script('main-scripts', get_template_directory_uri() . $path, array('jquery', 'wp-util'), filemtime(get_stylesheet_directory() . $path), TRUE);
		}
	}

	/**
	 * Set timber templates path defined in config
	 */
	function set_templates_place()
	{
		$site = $this->_site;
		$config = $this->_config;

		$site::$dirname = $config['site']['timber_template_paths'];
	}

	/**
	 *    Embed translations for JS
	 */
	function embed_localized_script()
	{
		if (!function_exists('get_language_strings') && isset($this->_config['language_strings']) && count($this->_config['language_strings']))
		{
			wp_localize_script(
				"main-scripts",
				"strings",
				$this->_config['language_strings']
			);
		} else if (isset($this->_config['language_strings']) && count($this->_config['language_strings']))
		{
			wp_localize_script(
				"main-scripts",
				"strings",
				get_language_strings()
			);
		}
	}

	/**
	 * Embed Admin CSS files defined in config
	 */
	function admin_styles()
	{
		if (isset($this->_config['embed_admin_css']) && count($this->_config['embed_admin_css']))
		{
			foreach ($this->_config['embed_admin_css'] as $handle => $path)
			{
				if (file_exists(get_stylesheet_directory() . $path))
					wp_enqueue_style($handle, get_stylesheet_directory_uri() . $path, [], filemtime(get_stylesheet_directory() . $path), 'all');

			}
		}
	}

	/**
	 * Debug dump for use in Twig files
	 * @param $var
	 */
	static function dump($var)
	{
		echo '<pre>';
		var_dump($var);
		echo '</pre>';
	}

	/**
	 * Read time function for articles
	 * @param $postId
	 * @return string
	 */
	public function display_read_time($postId)
	{
		$content = get_post_field('post_content', $postId);
		$count_words = str_word_count(strip_tags($content));

		$read_time = ceil($count_words / 250);

		$prefix = '<span class="rt-prefix"></span>';

		if ($read_time == 1)
		{
			$suffix = '<span class="rt-suffix"> min read</span>';
		} else
		{
			$suffix = '<span class="rt-suffix"> min read</span>';
		}

		$read_time_output = $prefix . $read_time . $suffix;

		return $read_time_output;
	}

	/**
	 * Define extra column for Media list
	 * @param $columns
	 * @return array
	 */
	function add_media_columns($columns)
	{
		return array_merge($columns, array(
			'format' => __('Format'),
		));
	}

	/**
	 *  Define data for extra column in Media list
	 * @param $column
	 * @param $post_id
	 */
	function media_custom_column($column, $post_id)
	{
		switch ($column)
		{
			case 'format':
				echo get_post_meta($post_id, 'media_format', true);
				break;
		}
	}

	/**
	 * @param $menu_item
	 * @return mixed
	 */
	function setup_nav_menu_item($menu_item)
	{
		if (isset($menu_item->post_type))
		{
			if ('nav_menu_item' == $menu_item->post_type)
			{
				$menu_item->description = apply_filters('nav_menu_description', $menu_item->post_content);
			}
		}

		return $menu_item;
	}

}
