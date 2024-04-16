<?php
defined('MOODLE_INTERNAL') || die();



require_once($CFG->dirroot.'/course/moodleform_mod.php');
$PAGE->requires->css('/mod/certifieth/styles.css');

class mod_certifieth_mod_form extends moodleform_mod {
    public function definition() {
        $logourl = new moodle_url('/mod/certifieth/pix/LogoCertifiEth.svg');
        $arbitrumurl = new moodle_url('/mod/certifieth/pix/arbitrum.png');
        $signurl = new moodle_url('/mod/certifieth/pix/sign.svg');
        $witnessurl = new moodle_url('/mod/certifieth/pix/witness.png');
        $filecoinurl = new moodle_url('/mod/certifieth/pix/filecoin.svg.png');
    global $CFG, $DB, $USER, $COURSE;

    $quiz = $DB->get_records('quiz');
    
    $mform = $this->_form;
    $landing_page_html = "";
    $landing_page_html .= '<div id="shortDescription">' . get_string('shortDescription', 'mod_certifieth') . '</div>';
    $landing_page_html .= '<img src="' . $logourl . '" alt="CertifiEth Logo" class="certifieth-logo">';
    $landing_page_html .= get_string('description', 'mod_certifieth');
    $landing_page_html .= '<div class="sponsor-logos-container">';
    $landing_page_html .= '<img src="' . $arbitrumurl . '" alt="Arbitrum Logo" class="sponsor-logo">';
    $landing_page_html .= '<img src="' . $signurl . '" alt="Sign Logo" class="sponsor-logo1">';
    $landing_page_html .= '<img src="' . $witnessurl . '" alt="Witness Logo" class="sponsor-logo1">';
    $landing_page_html .= '<img src="' . $filecoinurl . '" alt="Filecoin Logo" class="sponsor-logo">';
    $landing_page_html .= '';
    $landing_page_html .= '</div>';
    $landing_page_html .= '<div class="continue-button-container">';
    $landing_page_html .= '<a href="#formStart" class="mainButton btn btn-primary">Continue</a>';
    $landing_page_html .= '</div>';
    //$landing_page_html .= var_dump($USER);

    $mform->addElement('html', $landing_page_html);
    $attributes_text = ['size' => '60'];
    $attributes_textarea = ['cols' => '47', 'rows' => '10'];

    
    // $static_question_html = '<div class="static-element">WHICH COURSE DO YOU WANT TO ENABLE FOR CERTIFICATION?</div>';
    $quizArray = get_object_vars($quiz[1]);
    foreach ($quiz as $qu) {
        $quises[] = [
            'id'   => $qu->id,
            'name' => $qu->name,
        ];
    }
    foreach ($quises as $qui) {
        $quisesoptions[$qui['id']] = $qui['name'];
    }

    // General settings
    $openingDiv = '<div id="formStart">';
    $mform->addElement('html', $openingDiv);
    $mform->addElement('header', 'general', get_string('general', 'form'));
    $closingDiv = '</div>';
    $mform->addElement('html', $closingDiv);
    $mform->addElement('html', $static_question_html);
    $mform->addElement('text', 'teacherHash', 'Teacher Hash', $attributes_text);
    $mform->setType('teacherHash', PARAM_TEXT); 
    $mform->addElement('text', 'IpfsHash', 'Image Certificate Hash', $attributes_text);
    $mform->setType('IpfsHash', PARAM_TEXT); 
    $mform->addElement('select', 'selectquiz', 'Quiz required', $quisesoptions);
    $mform->setType('selectquiz', PARAM_INT);
    $mform->addElement('text', 'name', get_string('certifiethname', 'mod_certifieth'), ['size' => '64']);
    $mform->setType('name', !empty($CFG->formatstringstriptags) ? PARAM_TEXT : PARAM_CLEANHTML);
    $mform->addRule('selectcourse', null, 'required', null, 'client');
    $mform->addRule('teacherName', null, 'required', null, 'client');
    $mform->addRule('IpfsHash', null, 'required', null, 'client');
    $mform->addRule('name', null, 'required', null, 'client');
    $mform->addHelpButton('name', 'certifiethname', 'mod_certifieth');


      // Adding the standard "intro" and "introformat" fields.
      if ($CFG->branch >= 29) {
        $this->standard_intro_elements();
    } else {
        $this->add_intro_editor();
    }


    // Add standard elements.
    $this->standard_coursemodule_elements();

    // Add standard buttons.
    $this->add_action_buttons();
    }

    public function self_test() {
        return true;
    }
}

$PAGE->requires->js_init_code("
    document.addEventListener('DOMContentLoaded', function() {
        var element = document.getElementById('shortDescription');
        if (element) {
            var offset = 150;
            var elementPosition = element.getBoundingClientRect().top + window.pageYOffset;
            var offsetPosition = elementPosition - offset;
            
            window.scrollTo({
                top: offsetPosition,
                behavior: 'smooth'
            });
        }
    });
");