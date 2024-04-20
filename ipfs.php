<?php
global $COURSE, $USER, $CFG;

$diripfs='/var/www/html/moodle/mod/certifieth/ipfs_storage/';
$studentname = $USER->firstname.' '.$USER->lastname;
$coursename = $COURSE->fullname;
$coursedescription= $COURSE->summary;
$imagenipfs = 'icon.svg';


//$comando = shell_exec('/var/www/html/moodle/mod/certifieth/ipfs_storage /var/www/html/moodle/mod/certifieth/icon.svg');

exec($diripfs.'ipfs_storage.sh response.jpg', $salida, $retorno);

//echo implode($salida);
//echo $retorno;

$nombre_archivo = $diripfs.'response.json'; // Reemplaza con el nombre de tu archivo
$archivo = fopen($nombre_archivo, 'r');
$datosipfs=fgets($archivo);
//echo $datosipfs;
$datosjsonipfs = json_decode($datosipfs);
$datosjsonipfs2 = json_encode($datosipfs);

//var_dump($datosjsonipfs);
echo 'Hash'.$datosjsonipfs->Hash;
echo 'Salida'.var_dump($salida);
echo 'retorno'.$retorno;