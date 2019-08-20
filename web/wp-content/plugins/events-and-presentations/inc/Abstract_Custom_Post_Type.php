<?php
/**
 * ataylorme\EventsAndPresentations\Abstract_Custom_Post_Type interface
 *
 * @package ataylorme
 */

namespace ataylorme\EventsAndPresentations;

/**
 * Interface for a theme component.
 */
abstract class Abstract_Custom_Post_Type
{

	/**
	 * The translation domain
	 *
	 * @var string
	 */
	protected $translation_domain = 'ataylorme';

	/**
	 * The custom post type slug
	 *
	 * @var string
	 */
	protected $slug;

	/**
	 * The custom post type name
	 *
	 * @var string
	 */
	protected $name;

	/**
	 * The custom post type singular name
	 *
	 * @var string
	 */
	protected $name_singular;

	/**
	 * Gets the the custom post type's slug.
	 *
	 * @return string post type slug.
	 */
	public function get_slug()
	{
		return $this->slug;
	}

	/**
	 * Gets the the custom post type's plural name.
	 *
	 * @return string post type plural name.
	 */
	public function get_name()
	{
		return $this->name;
	}

	/**
	 * Gets the the custom post type's singular name.
	 *
	 * @return string post type singular name.
	 */
	public function get_name_singular()
	{
		return $this->name_singular;
	}

	/**
	 * Gets the custom post type's human readable labels.
	 *
	 * @return array labels for the custom post type.
	 */
	protected function get_labels()
	{
		$name = $this->name;
		$singular_name = $this->name_singular;
		$translation_domain = $this->translation_domain;

		return [
			'name'               => _x( $name, 'post type general name', $translation_domain ),
			'singular_name'      => _x( $singular_name, 'post type singular name', $translation_domain),
			'menu_name'          => _x( $name, 'admin menu', $translation_domain ),
			'name_admin_bar'     => _x( $singular_name, 'add new on admin bar' ),
			'add_new'            => _x( 'Add New', $translation_domain ),
			'add_new_item'       => __( 'Add New ' . $singular_name, $translation_domain ),
			'new_item'           => __( 'New ' . $singular_name, $translation_domain ),
			'edit_item'          => __( 'Edit ' . $singular_name, $translation_domain ),
			'view_item'          => __( 'View ' . $singular_name, $translation_domain ),
			'all_items'          => __( 'All ' . $name, $translation_domain ),
			'search_items'       => __( 'Search ' . $name, $translation_domain ),
			'parent_item_colon'  => __( 'Parent :' . $name, $translation_domain ),
			'not_found'          => __( 'No ' . $name . ' found.', $translation_domain ),
			'not_found_in_trash' => __( 'No ' . $name . ' found in Trash.', $translation_domain ),
		];
	}

	/**
	 * Registers the post type with WordPress.
	 */
	abstract public function registerPostType();
	
}
