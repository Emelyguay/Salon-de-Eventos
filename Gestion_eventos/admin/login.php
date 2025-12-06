<?php
session_start();
require '../db/conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $usuario = $_POST['usuario'];
    $pass = $_POST['password'];

    // Consulta simple sin encriptacion
    $sql = "SELECT * FROM usuarios WHERE usuario = :u AND password = :p";
    $stmt = $conexion->prepare($sql);
    $stmt->execute([':u' => $usuario, ':p' => $pass]);
    
    if ($stmt->rowCount() > 0) {
        $_SESSION['admin'] = $usuario;
        header("Location: dashboard.php");
        exit;
    } else {
        $error = "Usuario o contraseña incorrectos";
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Login Admin</title>
    <link rel="stylesheet" href="../css/estilo.css">
</head>
<body style="display:flex; justify-content:center; align-items:center; height:100vh;">
    <div class="card" style="width: 300px; padding: 20px;">
        <h2>Acceso Admin</h2>
        <?php if(isset($error)) echo "<p style='color:red'>$error</p>"; ?>
        <form method="POST">
            <label>Usuario:</label><br>
            <input type="text" name="usuario" required style="width:100%"><br><br>
            <label>Contraseña:</label><br>
            <input type="password" name="password" required style="width:100%"><br><br>
            <button type="submit" class="btn">Entrar</button>
        </form>
        <br>
        <a href="../index.php">Volver al Inicio</a>
    </div>
</body>
</html>