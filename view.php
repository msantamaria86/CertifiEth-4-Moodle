<?php
require_once('../../config.php');
require_login();
global $USER, $DB, $COURSE;
$curso = 2;
$coursedb = $DB->get_record('course', ['id'=>$curso]);
//$datacourse = get_course($lastaccess->courseid);

$moduleinstance = new stdClass();
$moduleinstance->course = $curso; // Assuming course ID 1 exists
$course = new stdClass();
$course->id = $curso;
$name = "$USER->firstname $USER->lastname";
$fullname = $coursedb->fullname;
$summary = $coursedb->summary;
$isDisabled = false;
$context = context_course::instance($course->id);

$moduleinstance->timecreated = time(); // Assign current time for example
$date = userdate($moduleinstance->timecreated);
$resultquestion = $DB->get_record('certifieth',['course' => $coursedb->id]);
$question = $resultquestion->quizid;
$resultquiz = $DB->get_record('quiz_attempts',['userid' => $USER->id, 'quiz' => $question]);
$quiz = $resultquiz->sumgrades;
$resultimage = $DB->get_record('certifieth_user',['userid' => $USER->id, 'certifiethid' => $resultquestion->id]);
$urltemp=$resultimage->hashfileips;

if($quiz>7){
    if($urltemp=="")$isDisabled=false;
    else $isDisabled=true;
}
else $isDisabled=true;


$PAGE->set_context($context);
$PAGE->set_url('/mod/certifieth/view.php', array('id' => $course->id));
$PAGE->set_title(format_string($name));
$PAGE->set_heading(format_string($fullname));

echo $OUTPUT->header();
?>

<!-- Add some basic styling -->
<style>
    body { font-family: Arial, sans-serif; margin: 20px; }
    .info { margin-bottom: 20px; }
    .info strong { display: inline-block; width: 100px; }
    #metamaskButton { background-color: #4CAF50; color: white; padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer; }
    #metamaskButton:hover { background-color: #45a049; }
</style>

<div class="header">
    <h1>Course result</h1>
    <img src="pix/LogoCertifiEth.svg" alt="CertifiETH Logo" class="logo"></div>

<div class="info">
    <h2><?= format_string($name) ?></h2>
    <p><strong>Course:</strong> <?= format_string($fullname) ?></p>
    <p><strong>Summary:</strong> <?= format_string($summary) ?></p>
    <p><strong>Date:</strong> <?= $date ?></p>
    <p><strong>Result quiz:</strong> <?= $quiz ?></p>
   
</div>

<form method="post" action="some_action.php">
    <input type="hidden" name="id" value="<?= $course->id ?>">
    <button type="button" id="metamaskButton" <?= $isDisabled ? 'disabled="disabled" class="disabledButton"' : '' ?>>Certify!</button>
    <p></p>
    <p></p>    
<?php
if($urltemp=="")echo "";
else '<img src="<?= $urltemp ?>" alt="Certificado en BlockChain"></img>';
echo $OUTPUT->footer();
?>

<script>
document.addEventListener('DOMContentLoaded', (event) => {
    const metamaskButton = document.getElementById('metamaskButton');
    metamaskButton.addEventListener('click', async function() {
        if (typeof window.ethereum !== 'undefined') {
            try {
                const chainId = await ethereum.request({ method: 'eth_chainId' });
                console.log('ID', chainId);
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
                await sendDataToServer(signature, userAddress, hash);   
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
        console.log('💥 Minted', responseData);

    }
});
</script>

<style>
     .header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 10px 30px; /* Adjust padding as needed */
        background-color: #2c3e50; /* Dark blue background */
        color: white;
    }
    .header h1 {
        margin: 0; /* Removes default margin */
    }
    .logo {
        height: 50px; /* Adjust based on your logo's dimensions */
        width: auto;
    }
    body {
        font-family: Arial, sans-serif;
        margin: 40px; 
        background-color: #f4f4f9; 
        color: #333;
    }
    .info {
        background-color: #ffffff;
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0,0,0,0.1); 
        padding: 20px; 
        margin-bottom: 30px;
    }
    .info h2 {
        color: #2c3e50; 
    }
    .info strong {
        display: block;
        width: auto;
        color: #16a085; 
        margin-bottom: 5px; 
    }
    #metamaskButton {
        background-color: #3498db; /* Bright blue for the active button */
        color: white;
        padding: 15px 30px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        font-size: 16px;
    }
    #metamaskButton:hover {
        background-color: #2980b9; /* Darker blue on hover */
    }
    .disabledButton {
        background-color: #bdc3c7 !important; /* Gray color for disabled button */
        cursor: not-allowed !important;
        box-shadow: none !important;
    }
    .disabledButton:hover {
        background-color: #bdc3c7 !important; /* Keep the same color on hover for disabled button */
    }
</style>