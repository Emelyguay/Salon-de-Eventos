<?php
$host = "localhost";
$dbname = "postgres"; 
$username = "postgres";
$password = "emely123";

try {
    $conexion = new PDO("pgsql:host=$host;dbname=$dbname", $username, $password);
    $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Error de conexión: " . $e->getMessage();
    die();
}
?>

