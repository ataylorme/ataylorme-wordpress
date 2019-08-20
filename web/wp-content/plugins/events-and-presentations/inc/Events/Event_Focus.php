<?php
/**
 * ataylorme\EventsAndPresentations\Events\Event_Focus
 *
 * @package ataylorme
 */

namespace ataylorme\EventsAndPresentations\Events;

use ataylorme\EventsAndPresentations\Abstract_Custom_Taxonomy;

class Event_Focus extends Abstract_Custom_Taxonomy
{
    public function __construct()
    {
        $this->slug = 'event-focus';
		$this->name = 'Focuses';
		$this->name_singular = 'Focus';
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
            [ 'events' ],
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