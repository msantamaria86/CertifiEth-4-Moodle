<?php
// This file is part of Moodle - http://moodle.org/
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
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * post installation hook for adding data.
 *
 * @package    mod_certifieth
 * @copyright  2024 CertifiETH 4 Moodle <pablovesga@outlook.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

/**
 * Post installation procedure
 */
function xmldb_certifieth_install() {
    global $DB;

    $result = true;
    $arr = array('P' => 2, 'A' => 0, 'L' => 1, 'E' => 1);
    foreach ($arr as $k => $v) {
        $rec = new stdClass;
        $rec->certifiethid = 0;
        //$rec->acronym = get_string($k.'acronym', 'certifieth');
        // Sanity check - if language translation uses more than the allowed 2 chars.
        //if (mb_strlen($rec->acronym) > 2){$rec->acronym = $k;}
        $rec->description = get_string($k.'full', 'certifieth');
        $rec->grade = $v;
    }
    return $result;
}