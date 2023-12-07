<?php

namespace WCD;

/**
 * Class PostTypes
 * @package WCD
 */
class PostTypes
{
	/**
	 * @var
	 */
	private $_config;

	/**
	 * PostTypes constructor.
	 * @param $config
	 */
	function __construct($config)
	{
		$this->_config = $config;
		add_action('init', array($this, 'register_post_types_and_taxonomies'));
	}

	/**
	 *    Register post types and taxonomies defined in config.
	 *  There's a lot of defaults defined in method's body.
	 */
	function register_post_types_and_taxonomies()
	{
		foreach ($this->_config as $cptSlug => $cptData)
		{
			$singularName = isset($cptData['singular']) ? $cptData['singular'] : ucfirst($cptSlug);;
			$pluralName = isset($cptData['plural']) ? $cptData['plural'] : $singularName . 's';

			$labels = [
				'name' => isset($cptData['labels']['name']) ? $cptData['labels']['name'] : $singularName,
				'singular_name' => $singularName,
				'menu_name' => isset($cptData['labels']['menu_name']) ? $cptData['labels']['menu_name'] : $pluralName,
				'name_admin_bar' => isset($cptData['labels']['name_admin_bar']) ? $cptData['labels']['name_admin_bar'] : $pluralName,
				'add_new' => isset($cptData['labels']['add_new']) ? $cptData['labels']['add_new'] : 'Add ' . $singularName
			];

			$cptArgs = [
				'labels' => $labels,
				'description' => isset($cptData['description']) ? $cptData['description'] : $singularName . ' Custom Post',
				'menu_icon' => isset($cptData['menu_icon']) ? $cptData['menu_icon'] : 'dashicons-carrot',
				'public' => isset($cptData['public']) ? $cptData['public'] : true,
				'publicly_queryable' => isset($cptData['publicly_queryable']) ? $cptData['publicly_queryable'] : true,
				'show_ui' => isset($cptData['show_ui']) ? $cptData['show_ui'] : true,
				'show_in_menu' => isset($cptData['show_in_menu']) ? $cptData['show_in_menu'] : true,
				'show_in_rest' => isset($cptData['show_in_rest']) ? $cptData['show_in_rest'] : false,
				'query_var' => isset($cptData['query_var']) ? $cptData['query_var'] : true,
				'rewrite' => isset($cptData['rewrite']) ? $cptData['rewrite'] : ['slug' => $cptSlug, 'with_front' => true],
				'capability_type' => isset($cptData['capability_type']) ? $cptData['capability_type'] : 'post',
				'has_archive' => isset($cptData['has_archive']) ? $cptData['has_archive'] : false,
				'hierarchical' => isset($cptData['hierarchical']) ? $cptData['hierarchical'] : false,
				'menu_position' => isset($cptData['menu_position']) ? $cptData['menu_position'] : null,
				'supports' => isset($cptData['supports']) ? $cptData['supports'] : ['title', 'editor', 'thumbnail'],
			];

			register_post_type($cptSlug, $cptArgs);

			if (isset($cptData['taxonomies']) && count($cptData['taxonomies']))
			{
				foreach ($cptData['taxonomies'] as $taxonomySlug => $taxonomyData)
				{

					$singularName = isset($taxonomyData['singular']) ? $taxonomyData['singular'] : str_replace('_', ' ', ucfirst($taxonomySlug));
					$pluralName = isset($taxonomyData['plural']) ? $taxonomyData['plural'] : $singularName . 's';

					$labels = array(
						'name' => isset($taxonomyData['labels']['name']) ? $taxonomyData['labels']['search_items'] : sprintf(__('%s Categories'), $pluralName),
						'singular_name' => $singularName,
						'search_items' => isset($taxonomyData['labels']['search_items']) ? $taxonomyData['labels']['search_items'] : sprintf(__('Search %s'), $pluralName),
						'popular_items' => isset($taxonomyData['labels']['popular_items']) ? $taxonomyData['labels']['popular_items'] : sprintf(__('Popular %s'), $pluralName),
						'all_items' => isset($taxonomyData['labels']['all_items']) ? $taxonomyData['labels']['popular_items'] : sprintf(__('All %s'), $pluralName),
						'parent_item' => isset($taxonomyData['labels']['parent_item']) ? $taxonomyData['labels']['parent_item'] : null,
						'parent_item_colon' => isset($taxonomyData['labels']['parent_item_colon']) ? $taxonomyData['labels']['parent_item_colon'] : null,
						'edit_item' => isset($taxonomyData['labels']['edit_item']) ? $taxonomyData['labels']['edit_item'] : sprintf(__('Edit %s'), $singularName),
						'update_item' => isset($taxonomyData['labels']['update_item']) ? $taxonomyData['labels']['update_item'] : sprintf(__('Update %s'), $singularName),
						'add_new_item' => isset($taxonomyData['labels']['add_new_item']) ? $taxonomyData['labels']['add_new_item'] : sprintf(__('Add New %s'), $singularName),
						'new_item_name' => isset($taxonomyData['labels']['new_item_name']) ? $taxonomyData['labels']['new_item_name'] : sprintf(__('New %s'), $singularName),
						'separate_items_with_commas' => isset($taxonomyData['labels']['separate_items_with_commas']) ? $taxonomyData['labels']['separate_items_with_commas'] : sprintf(__('Separate %s with commas'), strtolower($pluralName)),
						'add_or_remove_items' => isset($taxonomyData['labels']['add_or_remove_items']) ? $taxonomyData['labels']['add_or_remove_items'] : sprintf(__('Add or remove %s'), strtolower($pluralName)),
						'choose_from_most_used' => isset($taxonomyData['labels']['choose_from_most_used']) ? $taxonomyData['labels']['choose_from_most_used'] : sprintf(__('Choose from the most used %s'), strtolower($pluralName)),
						'menu_name' => isset($taxonomyData['labels']['menu_name']) ? $taxonomyData['labels']['menu_name'] : $pluralName,
					);

					register_taxonomy($taxonomySlug, $cptSlug, array(
						'hierarchical' => isset($taxonomyData['hierarchical']) ? $taxonomyData['hierarchical'] : false,
						'labels' => $labels,
						'show_ui' => isset($taxonomyData['show_ui']) ? $taxonomyData['show_ui'] : true,
						'update_count_callback' => isset($taxonomyData['update_count_callback']) ? $taxonomyData['update_count_callback'] : '_update_post_term_count',
						'query_var' => isset($taxonomyData['query_var']) ? $taxonomyData['query_var'] : true,
						'rewrite' => isset($taxonomyData['rewrite']) ? $taxonomyData['rewrite'] : ['slug' => $taxonomySlug],
					));
				}
			}
		}
	}
}
