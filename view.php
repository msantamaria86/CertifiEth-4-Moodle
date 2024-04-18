<?php
require_once('../../config.php');
require_login();


$moduleinstance = new stdClass();
$moduleinstance->course = 1; // Assuming course ID 1 exists
$course = new stdClass();
$course->id = 1;
$name = "$USER->firstname $USER->lastname";
$fullname = $COURSE->fullname;
$summary = $COURSE->summary;

$context = context_course::instance($course->id);
// require_capability('mod/certifieth:view', $context);


// $id = required_param('id', PARAM_INT); // instance id
// $moduleinstance = $DB->get_record('certifieth', array('id' => $id), '*', MUST_EXIST);
// $course = $DB->get_record('course', array('id' => $moduleinstance->course), '*', MUST_EXIST);

$context = context_course::instance($course->id);

// Format date+
$moduleinstance->timecreated = time(); // Assign current time for example
$date = userdate($moduleinstance->timecreated);
$grade = 'A'; 

// Render the page header
$PAGE->set_context($context);
$PAGE->set_url('/mod/certifieth/view.php', array('id' => $course->id));
$PAGE->set_title(format_string($name));
$PAGE->set_heading(format_string($fullname));

echo $OUTPUT->header();

// Display the information
echo '<h2>'.format_string($name).'</h2>';
echo '<p><strong>Course:</strong> '.format_string($fullname).'</p>';
echo '<p><strong>Summary:</strong> '.format_string($summary).'</p>';
echo '<p><strong>Date:</strong> '.$date.'</p>';
echo '<p><strong>Grade:</strong> '.$grade.'</p>';

// Action button
echo '<form method="post" action="some_action.php">';
echo '<input type="hidden" name="id" value="'.$course->id.'">';
echo '<button type="button" id="metamaskButton">Certify!</button>';
echo '</form>';

echo $OUTPUT->footer();
?>

<script>
    document.getElementById('metamaskButton').addEventListener('click', async function() {
    if (typeof window.ethereum !== 'undefined') {
        try {
            // Get the current chainId
            const chainId = await ethereum.request({ method: 'eth_chainId' });
            console.log('ID', chainId)
            if (chainId !== '0x66eee') {
                alert('Please connect to the Arbitrum/Sepolia Mainnet');
                return;
            }
            const accounts = await ethereum.request({ method: 'eth_requestAccounts' });
            const userAddress = accounts[0];
            const message = "Please sign this message to request your certificate.";
            const hash = '0x7f27bd98731bc959add0028cd2c0d6019c2db6e2c490c37978b738f93522167f';
            const signature = await ethereum.request({
                method: 'personal_sign',
                params: [message, userAddress],
            });


            // Next, send the signature and address to your server
            sendDataToServer(signature, userAddress, hash);
        } catch (error) {
            console.error(error);
        }
    } else {
        console.log('MetaMask is not installed. Please consider installing it.');
    }
    });

    async function sendDataToServer(signature, userAddress, hash) {
    const response = await fetch('metamaskrequest.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({ signature, userAddress, hash }),
    });

    const responseData = await response.json();
    console.log('💥 Minted')
    }
</script>