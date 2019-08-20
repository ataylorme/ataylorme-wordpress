<?php
/**
 * Plugin name: Events and Presentations
 * Author: Andrew Taylor
 *
 * ataylorme\EventsAndPresentations
 *
 * @package ataylorme
 */

namespace ataylorme\EventsAndPresentations;

require plugin_dir_path(__FILE__) . 'vendor/autoload.php';

use ataylorme\EventsAndPresentations\Events\Event_Post_Type;
use ataylorme\EventsAndPresentations\Events\Event_Focus;
use ataylorme\EventsAndPresentations\Events\Event_Custom_Fields;
use ataylorme\EventsAndPresentations\Presentations\Presentation_Post_Type;
use ataylorme\EventsAndPresentations\Presentations\Presentation_Tags;
use ataylorme\EventsAndPresentations\Presentations\Presentation_Formats;
use ataylorme\EventsAndPresentations\Presentations\Presentation_Custom_Fields;

Event_Post_Type::initialize();
Event_Focus::initialize();
Event_Custom_Fields::initialize();
Presentation_Post_Type::initialize();
Presentation_Tags::initialize();
Presentation_Formats::initialize();
Presentation_Custom_Fields::initialize();