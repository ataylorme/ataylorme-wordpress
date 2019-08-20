<?php
/**
 * ataylorme\EventsAndPresentations\Abstract_Custom_Taxonomy interface
 *
 * @package ataylorme
 */

namespace ataylorme\EventsAndPresentations;

/**
 * Interface for a theme component.
 */
abstract class Abstract_Custom_Taxonomy
{

	/**
	 * The translation domain
	 *
	 * @var string
	 */
	protected $translation_domain = 'ataylorme';

	/**
	 * The custom taxonomy slug
	 *
	 * @var string
	 */
	protected $slug;

	/**
	 * The custom taxonomy name
	 *
	 * @var string
	 */
	protected $name;

	/**
	 * The custom taxonomy singular name
	 *
	 * @var string
	 */
	protected $name_singular;

	/**
	 * Gets the custom taxonomy's slug.
	 *
	 * @return string taxonomy slug.
	 */
	public function get_slug()
	{
		return $this->slug;
	}

	/**
	 * Gets the custom taxonomy's plural name.
	 *
	 * @return string taxonomy plural name.
	 */
	public function get_name()
	{
		return $this->name;
	}

	/**
	 * Gets the custom taxonomy's singular name.
	 *
	 * @return string taxonomy singular name.
	 */
	public function get_name_singular()
	{
		return $this->name_singular;
	}

	/**
	 * Gets the custom taxonomy's human readable labels.
	 *
	 * @return array labels for the custom taxonomy.
	 */
	protected function get_labels()
	{
		$name = $this->name;
		$singular_name = $this->name_singular;
		$translation_domain = $this->translation_domain;

		return [
			'name'                       => _x( $name, 'taxonomy general name', $translation_domain ),
			'singular_name'              => _x( $singular_name, 'taxonomy singular name', $translation_domain),
			'menu_name'                  => _x( $name, 'admin menu', $translation_domain ),
			'name_admin_bar'             => _x( $singular_name, 'add new on admin bar' ),
			'add_new'                    => _x( 'Add New', $translation_domain ),
			'add_new_item'               => __( 'Add New ' . $singular_name, $translation_domain ),
			'new_item'                   => __( 'New ' . $singular_name, $translation_domain ),
			'edit_item'                  => __( 'Edit ' . $singular_name, $translation_domain ),
			'update_item'                => __( 'Update ' . $singular_name, $translation_domain ),
			'view_item'                  => __( 'View ' . $singular_name, $translation_domain ),
			'all_items'                  => __( 'All ' . $name, $translation_domain ),
			'search_items'               => __( 'Search ' . $name, $translation_domain ),
			'parent_item'                => __( 'Parent Item', $translation_domain ),
			'parent_item_colon'          => __( 'Parent :' . $name, $translation_domain ),
			'not_found'                  => __( 'No ' . $name . ' found.', $translation_domain ),
			'not_found_in_trash'         => __( 'No ' . $name . ' found in Trash.', $translation_domain ),
			'new_item_name'              => __( 'New ' . $singular_name, $translation_domain ),
			'separate_items_with_commas' => __( 'Separate ' . $name . ' with commas', $translation_domain ),
			'add_or_remove_items'        => __( 'Add or remove ' . $name, $translation_domain ),
			'choose_from_most_used'      => __( 'Choose from the most used ' . $name, $translation_domain ),
			'popular_items'              => __( 'Popular ' . $name, $translation_domain ),
			'no_terms'                   => __( 'No ' . $name, $translation_domain ),
			'items_list'                 => __( $name . ' list', $translation_domain ),
			'items_list_navigation'      => __( $name . ' list navigation', $translation_domain ),
		];
	}

	/**
	 * Registers the taxonomy with WordPress.
	 */
	abstract public function registerTaxonomy();
	
}
