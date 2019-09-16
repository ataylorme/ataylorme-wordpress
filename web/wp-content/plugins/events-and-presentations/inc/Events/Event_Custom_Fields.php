<?php
/**
 * ataylorme\EventsAndPresentations\Events\Event_Custom_Fields
 *
 * @package ataylorme
 */

namespace ataylorme\EventsAndPresentations\Events;

class Event_Custom_Fields
{
    public static function initialize()
    {
        // Initialize the class
        $instance = new self;

        // Add ACF fields
        if( function_exists('acf_add_local_field_group') ) {
            add_action('plugins_loaded', [$instance, 'registerCustomFields']);
            add_action( 'save_post', [ $instance, 'modify_post_date' ] );
        }
    }

    public function registerCustomFields()
    {
        acf_add_local_field_group(array(
            'key' => 'group_5d5aa4921af09',
            'title' => 'Events Custom Fields',
            'fields' => array(
                array(
                    'key' => 'field_5d5aa4b5f7501',
                    'label' => 'Presentation',
                    'name' => 'presentation',
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
                        0 => 'presentations',
                    ),
                    'taxonomy' => '',
                    'allow_null' => 0,
                    'multiple' => 1,
                    'return_format' => 'object',
                    'ui' => 1,
                ),
                array(
                    'key' => 'field_5d5aa60c7f3ed',
                    'label' => 'Year',
                    'name' => 'year',
                    'type' => 'number',
                    'instructions' => '',
                    'required' => 1,
                    'conditional_logic' => 0,
                    'wrapper' => array(
                        'width' => '',
                        'class' => '',
                        'id' => '',
                    ),
                    'default_value' => '',
                    'placeholder' => '',
                    'prepend' => '',
                    'append' => '',
                    'min' => 2000,
                    'max' => 3000,
                    'step' => 1,
                ),
                array(
                    'key' => 'field_5d5aa6487f3ee',
                    'label' => 'Month',
                    'name' => 'month',
                    'type' => 'number',
                    'instructions' => '',
                    'required' => 1,
                    'conditional_logic' => 0,
                    'wrapper' => array(
                        'width' => '',
                        'class' => '',
                        'id' => '',
                    ),
                    'default_value' => '',
                    'placeholder' => '',
                    'prepend' => '',
                    'append' => '',
                    'min' => 1,
                    'max' => 12,
                    'step' => 1,
                ),
                array(
                    'key' => 'field_5d5aa65d7f3ef',
                    'label' => 'Online',
                    'name' => 'online',
                    'type' => 'true_false',
                    'instructions' => '',
                    'required' => 1,
                    'conditional_logic' => 0,
                    'wrapper' => array(
                        'width' => '',
                        'class' => '',
                        'id' => '',
                    ),
                    'message' => '',
                    'default_value' => 0,
                    'ui' => 0,
                    'ui_on_text' => '',
                    'ui_off_text' => '',
                ),
                array(
                    'key' => 'field_5d5aa6737f3f0',
                    'label' => 'Country',
                    'name' => 'country',
                    'type' => 'text',
                    'instructions' => '',
                    'required' => 0,
                    'conditional_logic' => array(
                        array(
                            array(
                                'field' => 'field_5d5aa65d7f3ef',
                                'operator' => '!=',
                                'value' => '1',
                            ),
                        ),
                    ),
                    'wrapper' => array(
                        'width' => '',
                        'class' => '',
                        'id' => '',
                    ),
                    'default_value' => 'United States',
                    'placeholder' => '',
                    'prepend' => '',
                    'append' => '',
                    'maxlength' => '',
                ),
                array(
                    'key' => 'field_5d5aa6947f3f1',
                    'label' => 'Region',
                    'name' => 'region',
                    'type' => 'text',
                    'instructions' => '',
                    'required' => 0,
                    'conditional_logic' => array(
                        array(
                            array(
                                'field' => 'field_5d5aa65d7f3ef',
                                'operator' => '!=',
                                'value' => '1',
                            ),
                        ),
                    ),
                    'wrapper' => array(
                        'width' => '',
                        'class' => '',
                        'id' => '',
                    ),
                    'default_value' => '',
                    'placeholder' => '',
                    'prepend' => '',
                    'append' => '',
                    'maxlength' => '',
                ),
                array(
                    'key' => 'field_5d5aa6bb7f3f2',
                    'label' => 'City',
                    'name' => 'city',
                    'type' => 'text',
                    'instructions' => '',
                    'required' => 0,
                    'conditional_logic' => array(
                        array(
                            array(
                                'field' => 'field_5d5aa65d7f3ef',
                                'operator' => '!=',
                                'value' => '1',
                            ),
                        ),
                    ),
                    'wrapper' => array(
                        'width' => '',
                        'class' => '',
                        'id' => '',
                    ),
                    'default_value' => '',
                    'placeholder' => '',
                    'prepend' => '',
                    'append' => '',
                    'maxlength' => '',
                ),
                array(
                    'key' => 'field_5d5aa6ce7f3f3',
                    'label' => 'Latitude',
                    'name' => 'latitude',
                    'type' => 'number',
                    'instructions' => '',
                    'required' => 0,
                    'conditional_logic' => array(
                        array(
                            array(
                                'field' => 'field_5d5aa65d7f3ef',
                                'operator' => '!=',
                                'value' => '1',
                            ),
                        ),
                    ),
                    'wrapper' => array(
                        'width' => '',
                        'class' => '',
                        'id' => '',
                    ),
                    'default_value' => '',
                    'placeholder' => '',
                    'prepend' => '',
                    'append' => '',
                    'min' => '',
                    'max' => '',
                    'step' => '',
                ),
                array(
                    'key' => 'field_5d5aa6d97f3f4',
                    'label' => 'Longitude',
                    'name' => 'longitude',
                    'type' => 'number',
                    'instructions' => '',
                    'required' => 0,
                    'conditional_logic' => array(
                        array(
                            array(
                                'field' => 'field_5d5aa65d7f3ef',
                                'operator' => '!=',
                                'value' => '1',
                            ),
                        ),
                    ),
                    'wrapper' => array(
                        'width' => '',
                        'class' => '',
                        'id' => '',
                    ),
                    'default_value' => '',
                    'placeholder' => '',
                    'prepend' => '',
                    'append' => '',
                    'min' => '',
                    'max' => '',
                    'step' => '',
                ),
            ),
            'location' => array(
                array(
                    array(
                        'param' => 'post_type',
                        'operator' => '==',
                        'value' => 'events',
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

    /**
	 * Replace the year in an ISO formatted date string with a new, 4-digit value
	 *
	 * @param string $date ISO formatted date.
	 * @param string $year 4 digit year.
	 *
	 * @return string ISO formatted date.
	 */
	protected function replace_year( string $date, string $year ) {
		$date = preg_replace( '/^([0-9]{4})/', $year, $date );
		return $date;
	}

	/**
	 * Replace the month in an ISO formatted date string with a new, 2-digit value
	 *
	 * @param string $date ISO formatted date.
	 * @param string $month 4 digit month.
	 *
	 * @return string ISO formatted date.
	 */
	protected function replace_month( string $date, string $month ) {
		$date = preg_replace( '/^([0-9]{4})-([0-9]{2})/', '$1-' . $month, $date );
		return $date;
	}

	/**
	 * Modifies the post date for the events post type
	 * by replacing the year and month with the
	 * corresponding meta values, if they are set.
	 *
	 * @param int $post_id ID of the post being saved.
	 *
	 * @return $data modified slashed post data
	 */
	public function modify_post_date( $post_id ) {

		if ( 'events' !== get_post_type( $post_id ) ) {
			return;
		}

        $related_presentation_ids = $_POST['acf']['field_5d5aa4b5f7501'];
        $event_year               = $_POST['acf']['field_5d5aa60c7f3ed'];
        $event_month              = $_POST['acf']['field_5d5aa6487f3ee'];
        $post_date                = get_the_date( 'Y-m-d H:i:s', $post_id );

        if ( ! empty( $event_year ) ) :
            $post_date = $this->replace_year( $post_date, $event_year );
        endif;

        if ( ! empty( $event_month ) ) :
            $post_date = $this->replace_month( $post_date, $event_month );
        endif;

        $post_date_gmt = get_gmt_from_date( $post_date );

		$postarr = [
			'ID' => $post_id,
			'post_date' => $post_date,
			'post_date_gmt' => $post_date_gmt,
		];

        remove_action( 'save_post', [ $this, 'modify_post_date' ] );

        wp_update_post( $postarr );

        if( !empty( $related_presentation_ids ) ) :
            foreach( $related_presentation_ids as $related_presentation_id ) :
                $postarr['ID'] = (int) $related_presentation_id;
                wp_update_post( $postarr );
            endforeach;
        endif;

		add_action( 'save_post', [ $this, 'modify_post_date' ] );
	}
}