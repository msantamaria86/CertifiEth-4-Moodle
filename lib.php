<?php
// This file is part of Moodle - https://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <https://www.gnu.org/licenses/>.

/**
 * Library of interface functions and constants.
 *
 * @package     mod_certifieth
 * @copyright   2024 Miguel Santamaria <msantamaria86@gmail.com>
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

/**
 * Return if the plugin supports $feature.
 *
 * @param string $feature Constant representing the feature.
 * @return true | null True if the feature is supported, null otherwise.
 */
function certifieth_supports($feature) {
    switch ($feature) {
        case FEATURE_MOD_INTRO:
            return true;
        default:
            return null;
    }
}


/**
 * Saves a new instance of the mod_certifieth into the database.
 *
 * Given an object containing all the necessary data, (defined by the form
 * in mod_form.php) this function will create a new instance and return the id
 * number of the instance.
 *
 * @param object $moduleinstance An object from the form.
 * @param mod_certifieth_mod_form $mform The form.
 * @return int The id of the newly inserted record.
 */
function certifieth_add_instance($certifieth) {
    global $CFG, $DB, $COURSE;

    $customData = new stdClass();
    $customData->course = $COURSE->id;
    $customData->name = 'Certificate in '.$COURSE->fullname;
    $customData->teacher = $certifieth->teacherName;
    $customData->refid = $certifieth->name;
    $customData->quizid = $certifieth->selectquiz;
    $customData->image = $certifieth->IpfsHash;
    $customData->intro = $certifieth->intro; 
    $customData->introformat = $certifieth->introformat; 

    // Debugging: Print the object to error log to inspect its structure.
    error_log(print_r($certifieth, true));

    // Attempt to insert the record.
    $insertedId = $DB->insert_record('certifieth', $customData);

    return $insertedId; // Return the ID of the inserted record.
}

/**
 * Updates an instance of the mod_certifieth in the database.
 *
 * Given an object containing all the necessary data (defined in mod_form.php),
 * this function will update an existing instance with new data.
 *
 * @param object $moduleinstance An object from the form in mod_form.php.
 * @param mod_certifieth_mod_form $mform The form.
 * @return bool True if successful, false otherwise.
 */
function certifieth_update_instance($moduleinstance, $mform = null) {
    global $DB;

    $moduleinstance->timemodified = time();
    $moduleinstance->id = $moduleinstance->instance;

    return $DB->update_record('certifieth', $moduleinstance);
}

/**
 * Removes an instance of the mod_certifieth from the database.
 *
 * @param int $id Id of the module instance.
 * @return bool True if successful, false on failure.
 */
function certifieth_delete_instance($id) {
    global $DB;

    $exists = $DB->get_record('certifieth', array('id' => $id));
    if (!$exists) {
        return false;
    }

    $DB->delete_records('certifieth', array('id' => $id));

    return true;
}
