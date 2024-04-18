<?php
require_once('../../config.php');
require_login();

global $DB, $COURSE, $CFG, $USER;

$id = 1; // Example ID
$moduleinstance = new stdClass();
$moduleinstance->course = 1; // Assuming course ID 1 exists
$imagenipfs='imagen.jpg';

$course = new stdClass();
$course->id = $COURSE->id;
$name = $COURSE->fullname;
$fullname = 'Certificate in'.$COURSE->fullname;

$context = context_course::instance($course->id);
// require_capability('mod/certifieth:view', $context);


// $id = required_param('id', PARAM_INT); // instance id
// $moduleinstance = $DB->get_record('certifieth', array('id' => $id), '*', MUST_EXIST);
// $course = $DB->get_record('course', array('id' => $moduleinstance->course), '*', MUST_EXIST);

$context = context_course::instance($course->id);

// Format date+
$moduleinstance->timecreated = time(); // Assign current time for example
$date = userdate($moduleinstance->timecreated);


// Render the page header
$PAGE->set_context($context);
$PAGE->set_url('/mod/certifieth/view.php', array('id' => $id));
$PAGE->set_title(format_string($name));
$PAGE->set_heading(format_string($fullName));

echo $OUTPUT->header();
        
    echo '<p>Variables</p>';
    echo '<p>'.$USER->firstname.' '.$USER->lastname.'</p>';
    echo '<p>'.$COURSE->fullname.'</p>';
    echo '<p>'.$COURSE->summary.'</p>';

    echo '<form method="post" action="imagen.php">';
    echo '<button onClick="dercargar()">imagen</button>';
    echo '</form>';
    echo '<p> </p>';
    echo '<form method="post" action="ipfs.php">';
    echo '<button onClick="dercargar()">ipfs</button>';
    echo '</form>';
        
echo $OUTPUT->footer();
?>
