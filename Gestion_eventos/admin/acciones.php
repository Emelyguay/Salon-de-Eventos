<?php
session_start();
require '../db/conexion.php';

if (isset($_POST['accion']) && isset($_POST['id_reserva']) && isset($_SESSION['admin'])) {
    $estado = $_POST['accion'];
    $id = $_POST['id_reserva'];
    
    $sql = "UPDATE reservas SET estado = :e WHERE id = :id";
    $stmt = $conexion->prepare($sql);
    $stmt->execute([':e' => $estado, ':id' => $id]);
}

header("Location: dashboard.php");
exit;
?>