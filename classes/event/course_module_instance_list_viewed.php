<?php
namespace mod_certifieth\event;

defined('MOODLE_INTERNAL') || die();

class course_module_instance_list_viewed extends \core\event\course_module_instance_list_viewed {
    public static function create_from_course(\stdClass $course) {
        $params = array(
            'context' => \context_course::instance($course->id)
        );
        $event = self::create($params);
        $event->add_record_snapshot('course', $course);
        return $event;
    }
}