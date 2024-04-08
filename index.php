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
 * @package     local_greetings
 * @copyright   2023 Miguel S <msantamaria86@gmail.com>
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

 require_once('../../config.php');

 $PAGE->requires->css('/blocks/certifieth/styles.css');
 $context = context_system::instance();
 $PAGE->set_context($context);
 $PAGE->set_url(new moodle_url('/blocks/certifieth/index.php'));
 $PAGE->set_pagelayout('standard');
 $PAGE->set_title(get_string('pluginname', 'block_certifieth'));
 $PAGE->set_heading(get_string('pluginname', 'block_certifieth'));

 $logourl = new moodle_url('/blocks/certifieth/pix/LogoCertifiEth.svg');
 $witnessurl = new moodle_url('/blocks/certifieth/pix/witness.png');
 $signurl = new moodle_url('/blocks/certifieth/pix/sign.svg');

 echo $OUTPUT->header();
 echo get_string('shortDescription', 'block_certifieth');
 echo '<img src="' . $logourl . '" alt="CertifiEth Logo" class="certifieth-logo">';
 echo get_string('description', 'block_certifieth');
 echo '<div class="sponsor-logos-container">';
 echo '<img src="' . $witnessurl . '" alt="Witness Logo" class="sponsor-logo">';
 echo '<img src="' . $signurl . '" alt="Sign Logo" class="sponsor-logo">';
 echo '</div>';
 echo '<div class="continue-button-container">';
 echo '<a href="' . './' . '" class="mainButton btn btn-primary">Continue</a>';
 echo '</div>';
 echo $OUTPUT->footer();
 