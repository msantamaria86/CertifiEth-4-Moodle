<?php
require_once('../../config.php');
require_login();
global $COURSE, $USER, $CFG;

$dirimage='/var/www/html/moodle/mod/certifieth/pix/';
$diripfs='/var/www/html/moodle/mod/certifieth/ipfs_storage/';
$studentname = $USER->firstname.' '.$USER->lastname;
$coursename = $COURSE->fullname;
$coursedescription= $COURSE->summary;


$lighthousegateway = 'https://files.lighthouse.storage/viewFile/';
$imageurl = "$lighthousegateway/$imageipfshash/";


error_log('POSTED');
$ch = curl_init();

// Configura la URL de destino
curl_setopt($ch, CURLOPT_URL, 'https://adjusted-weekly-cattle.ngrok-free.app/certificate/certify');

// Configura el método HTTP como POST
curl_setopt($ch, CURLOPT_POST, 1);

// Configura la opción para que curl devuelva la respuesta como un string
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

// Configura los datos a enviar en el formulario
$postData = [
    'file' => new CURLFile($dirimage.'test.jpg', 'image/jpeg'),
    'name' => $studentname,
    'course' => $coursename,
];
curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);

// Configura las cabeceras
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'accept: */*',
    'Content-Type: multipart/form-data',
]);

// Ejecuta la solicitud y almacena la respuesta
$response = curl_exec($ch);

// Verifica si hubo algún error en la solicitud
if ($response === false) {
    echo 'Error: ' . curl_error($ch);
} else {
    // Guarda la respuesta en un archivo
    file_put_contents($diripfs.'response.jpg', $response);
    echo 'Solicitud completada correctamente';
}

// Cierra la sesión cURL
curl_close($ch);
echo $studentname;
echo $coursename;
echo "vacios";

exec($diripfs.'ipfs_storage.sh response.jpg', $salida, $retorno);

//echo implode($salida);
//echo $retorno;

$nombre_archivo = $diripfs.'response.json'; // Reemplaza con el nombre de tu archivo
$archivo = fopen($nombre_archivo, 'r');
$datosipfs=fgets($archivo);
//echo $datosipfs;
$datosjsonipfs = json_decode($datosipfs);

//var_dump($datosjsonipfs);
echo "<p>Hash</p>";
$urltemp = $lighthousegateway.$datosjsonipfs->Hash;
echo '<iframe src="'.$urltemp.'" alt="Certificado en BlockChain"></iframe>';