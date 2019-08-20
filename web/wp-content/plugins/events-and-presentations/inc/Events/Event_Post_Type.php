<?php
/**
 * ataylorme\EventsAndPresentations\Events\Event_Post_Type
 *
 * @package ataylorme
 */

namespace ataylorme\EventsAndPresentations\Events;

use ataylorme\EventsAndPresentations\Abstract_Custom_Post_Type;

class Event_Post_Type extends Abstract_Custom_Post_Type
{
    public function __construct()
    {
        $this->slug = 'events';
		$this->name = 'Events';
		$this->name_singular = 'Event';
    }

    public static function initialize()
    {
        // Initialize the class
        $instance = new self;

        // Add the post type registration hook
        add_action('init', [$instance, 'registerPostType']);
    }

    public function registerPostType()
    {
        $slug = $this->slug;
        register_post_type( 
            $slug,
            [
                'public'             => true,
                'publicly_queryable' => true,
                'show_ui'            => true,
                'show_in_menu'       => true,
                'query_var'          => true,
                'capability_type'    => 'post',
                'labels'             => $this->get_labels(),
                'has_archive'        => true,
                'show_in_rest'       => true,
                'supports'           => [
                    'title',
                    'editor',
                    'thumbnail',
                ],
                'rewrite'            => array( 'slug' => $slug ),
                'menu_icon'          => 'dashicons-calendar-alt',
            ]
        );
    }
}