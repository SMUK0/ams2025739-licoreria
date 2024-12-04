<?php

// Configuración de la base de datos
$servername = "localhost"; // o "127.0.0.1"
$username = "root"; // Cambia esto por tu nombre de usuario de MySQL
$password = ""; // Cambia esto por tu contraseña de MySQL
$dbname = "licoreria_db"; // Cambia esto por el nombre de tu base de datos

// Crear la conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error . " (" . $conn->connect_errno . ")");
}

// Establecer el conjunto de caracteres a utf8
$conn->set_charset("utf8");

// Verificar que la conexión sea exitosa
echo "Conectado a la base de datos $dbname";

// Función para obtener la conexión
function getConexion() {
    global $conn;
    return $conn;
}

// Función para cerrar la conexión
function closeConexion() {
    global $conn;
    $conn->close();
}

// Ejemplo de uso
$conn = getConexion();

// Realizar una consulta
$result = $conn->query("SELECT * FROM usuarios");

// Cerrar la conexión
closeConexion();

?>