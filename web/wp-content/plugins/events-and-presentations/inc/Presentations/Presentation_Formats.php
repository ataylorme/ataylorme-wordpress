<?php
/**
 * ataylorme\EventsAndPresentations\Presentations\Presentation_Formats
 *
 * @package ataylorme
 */

namespace ataylorme\EventsAndPresentations\Presentations;

use ataylorme\EventsAndPresentations\Abstract_Custom_Taxonomy;

class Presentation_Formats extends Abstract_Custom_Taxonomy
{
    public function __construct()
    {
        $this->slug = 'presentation-formats';
		$this->name = 'Formats';
		$this->name_singular = 'Format';
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
                'hierarchical'       => true,
                'public'             => true,
                'show_ui'            => true,
                'show_admin_column'  => true,
                'show_in_nav_menus'  => true,
                'show_tagcloud'      => true,
            ]
        );
    }
}