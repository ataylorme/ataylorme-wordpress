<?php
/**
 * ataylorme\EventsAndPresentations\Presentations\Presentation_Custom_Fields
 *
 * @package ataylorme
 */

namespace ataylorme\EventsAndPresentations\Presentations;

class Presentation_Custom_Fields
{
    public static function initialize()
    {
        // Initialize the class
        $instance = new self;

        // Add ACF fields
        if( function_exists('acf_add_local_field_group') ) {
            add_action('plugins_loaded', [$instance, 'registerCustomFields']);
        }
    }

    public function registerCustomFields()
    {
        acf_add_local_field_group(array(
            'key' => 'group_5d5aa767944e5',
            'title' => 'Presentation Custom Fields',
            'fields' => array(
                array(
                    'key' => 'field_5d5aa778ed15b',
                    'label' => 'Formats',
                    'name' => 'formats',
                    'type' => 'checkbox',
                    'instructions' => '',
                    'required' => 0,
                    'conditional_logic' => 0,
                    'wrapper' => array(
                        'width' => '',
                        'class' => '',
                        'id' => '',
                    ),
                    'choices' => array(
                        'full-length' => 'full-length',
                        'lightning' => 'lightning',
                        'workshop' => 'workshop',
                    ),
                    'allow_custom' => 0,
                    'default_value' => array(
                    ),
                    'layout' => 'horizontal',
                    'toggle' => 0,
                    'return_format' => 'value',
                    'save_custom' => 0,
                ),
                array(
                    'key' => 'field_5d5aa7b6ed15c',
                    'label' => 'Slide Link',
                    'name' => 'slide_link',
                    'type' => 'url',
                    'instructions' => '',
                    'required' => 0,
                    'conditional_logic' => 0,
                    'wrapper' => array(
                        'width' => '',
                        'class' => '',
                        'id' => '',
                    ),
                    'default_value' => '',
                    'placeholder' => '',
                ),
                array(
                    'key' => 'field_5d5aa7cbed15d',
                    'label' => 'Recording Link',
                    'name' => 'recording_link',
                    'type' => 'url',
                    'instructions' => '',
                    'required' => 0,
                    'conditional_logic' => 0,
                    'wrapper' => array(
                        'width' => '',
                        'class' => '',
                        'id' => '',
                    ),
                    'default_value' => '',
                    'placeholder' => '',
                ),
                array(
                    'key' => 'field_5d5aa7daed15e',
                    'label' => 'Events',
                    'name' => 'events',
                    'type' => 'post_object',
                    'instructions' => '',
                    'required' => 0,
                    'conditional_logic' => 0,
                    'wrapper' => array(
                        'width' => '',
                        'class' => '',
                        'id' => '',
                    ),
                    'post_type' => array(
                        0 => 'events',
                    ),
                    'taxonomy' => '',
                    'allow_null' => 0,
                    'multiple' => 1,
                    'return_format' => 'object',
                    'ui' => 1,
                ),
            ),
            'location' => array(
                array(
                    array(
                        'param' => 'post_type',
                        'operator' => '==',
                        'value' => 'presentations',
                    ),
                ),
            ),
            'menu_order' => 0,
            'position' => 'normal',
            'style' => 'seamless',
            'label_placement' => 'top',
            'instruction_placement' => 'label',
            'hide_on_screen' => '',
            'active' => true,
            'description' => '',
        ));
    }
}