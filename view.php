<?php
require_once('../../config.php');
require_login();


$id = 1; // Example ID
$moduleinstance = new stdClass();
$moduleinstance->course = 1; // Assuming course ID 1 exists

$course = new stdClass();
$course->id = 1;
$name = 'test';
$fullname = 'test test';

$context = context_course::instance($course->id);
// require_capability('mod/certifieth:view', $context);


// $id = required_param('id', PARAM_INT); // instance id
// $moduleinstance = $DB->get_record('certifieth', array('id' => $id), '*', MUST_EXIST);
// $course = $DB->get_record('course', array('id' => $moduleinstance->course), '*', MUST_EXIST);

$context = context_course::instance($course->id);

// Format date+
$moduleinstance->timecreated = time(); // Assign current time for example
$date = userdate($moduleinstance->timecreated);

// Assuming grade is stored or calculated somehow
$grade = 'A'; // Placeholder for actual grade calculation

// Render the page header
$PAGE->set_context($context);
$PAGE->set_url('/mod/certifieth/view.php', array('id' => $id));
$PAGE->set_title(format_string('name'));
$PAGE->set_heading(format_string('fullName'));

echo $OUTPUT->header();

// Display the information
echo '<h2>'.format_string('name').'</h2>';
echo '<p><strong>Course:</strong> '.format_string('fullName').'</p>';
echo '<p><strong>Date:</strong> '.$date.'</p>';
echo '<p><strong>Grade:</strong> '.$grade.'</p>';

// Action button
echo '<form method="post" action="some_action.php">';
echo '<input type="hidden" name="id" value="'.$id.'">';
echo '<button type="button" id="metamaskButton">Take Action with MetaMask</button>';
echo '</form>';

echo $OUTPUT->footer();
?>

<script>
    document.getElementById('metamaskButton').addEventListener('click', async function() {
    if (typeof window.ethereum !== 'undefined') {
        try {
        const accounts = await ethereum.request({ method: 'eth_requestAccounts' });
        const userAddress = accounts[0];
        const message = "Please sign this message to request your certificate.";
        const signature = await ethereum.request({
            method: 'personal_sign',
            params: [message, userAddress],
        });

        // Next, send the signature and address to your server
        sendDataToServer(signature, userAddress);
        } catch (error) {
        console.error(error);
        }
    } else {
        console.log('MetaMask is not installed. Please consider installing it.');
    }
    });

    async function sendDataToServer(signature, userAddress) {
    const response = await fetch('metamaskrequest.php', {
        method: 'POST',
        headers: {
        'Content-Type': 'application/json',
        },
        body: JSON.stringify({ signature, userAddress }),
    });

    const responseData = await response.json();
    console.log(responseData); // Handle the response from your server
    }
</script>
