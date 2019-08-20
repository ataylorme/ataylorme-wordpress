<?php
/**
 * ataylorme\EventsAndPresentations\Presentations\Presentation_Tags
 *
 * @package ataylorme
 */

namespace ataylorme\EventsAndPresentations\Presentations;

use ataylorme\EventsAndPresentations\Abstract_Custom_Taxonomy;

class Presentation_Tags extends Abstract_Custom_Taxonomy
{
    public function __construct()
    {
        $this->slug = 'presentation-tags';
		$this->name = 'Tags';
		$this->name_singular = 'Tag';
    }

    public static function initialize()
    {
        // Initialize the class
        $instance = new self;

        // Add the taxonomy registration hook
        add_action('init', [$instance, 'registerTaxonomy']);
    }

    public function registerTaxonomy()
    {
        $slug = $this->slug;
        register_taxonomy( 
            $slug,
            [ 'presentations' ],
            [
                'labels'             => $this->get_labels(),
                'hierarchical'       => false,
                'public'             => true,
                'show_ui'            => true,
                'show_admin_column'  => true,
                'show_in_nav_menus'  => true,
                'show_tagcloud'      => true,
            ]
        );
    }
}