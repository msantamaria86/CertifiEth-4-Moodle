<?php
global $COURSE, $USER, $CFG;

$diripfs='/var/www/html/moodle/mod/certifieth/ipfs_storage/';
$studentname = $USER->firstname.' '.$USER->lastname;
$coursename = $COURSE->fullname;
$coursedescription= $COURSE->summary;
$imagenipfs = 'icon.svg';


$lighthousegateway = 'https://files.lighthouse.storage/viewFile';
$imageurl = "$lighthousegateway/$imageipfshash";

//$comando = shell_exec('/var/www/html/moodle/mod/certifieth/ipfs_storage /var/www/html/moodle/mod/certifieth/icon.svg');

exec($diripfs.'ipfs_storage.sh icon.svg', $salida, $retorno);

//echo implode($salida);
//echo $retorno;

$nombre_archivo = $diripfs.'icon.json'; // Reemplaza con el nombre de tu archivo
$archivo = fopen($nombre_archivo, 'r');
$datosipfs=fgets($archivo);
//echo $datosipfs;
$datosjsonipfs = json_decode($datosipfs);
$datosjsonipfs2 = json_encode($datosipfs);

//var_dump($datosjsonipfs);
echo $datosjsonipfs->Hash;
