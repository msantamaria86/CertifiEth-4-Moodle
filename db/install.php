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
 * Code to be executed after the plugin's database scheme has been installed is defined here.
 *
 * @package     mod_certifieth
 * @category    upgrade
 * @copyright   2024 Pablo Vesga <pablovesga@outlook.com>
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

/**
 * Custom code to be run on installing the plugin.
 */
function xmldb_certifieth_install() {

    return true;
}

$installationForm = '<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Instalacion del APP</title>
</head>
<body>
    <p>se conectan tres tipos de usuarios</p>
    <p>expertos solo se necesita token</p>
    <p>completamente nuevos se les debe explicar un read more. etc</p>
    <p>ya lo han usado y desean comprar</p>
    <h1>Formulario de token</h1>
    <form action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="post">
        <label for="token">Token:</label>
        <input type="text" id="token" name="token" required>
        <br>
        <br>
        <input type="submit" value="Enviar">
    </form>
</body>
</html>';

// Procesar código ingresado
if (isset($_POST['token'])) {
    $codigoIngresado = $_POST['token'];

    // Validar el código
    if (validarCodigo($codigoIngresado)) {
        // Almacenar el código
        $codigoValido = $codigoIngresado;
        guardarCodigo($codigoValido);

        // Continuar con la instalación
        // ... (código para instalar el plugin)
    } else {
        // Mostrar mensaje de error
        echo '<p class="error">El código ingresado es incorrecto.</p>';
        // Detener la instalación
        exit;
    }
}
else {
        // Display the installation form
        echo $installationForm; // Replace with the generated HTML form

}