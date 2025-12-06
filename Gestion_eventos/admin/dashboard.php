<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit;
}
require '../db/conexion.php';

// Obtener todas las reservas
$sql = "SELECT r.*, s.nombre as salon FROM reservas r JOIN salones s ON r.salon_id = s.id ORDER BY r.fecha_evento DESC";
$reservas = $conexion->query($sql)->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Panel de Administracion</title>
    <link rel="stylesheet" href="../css/estilo.css">
</head>
<body>
    <header>
        <h1>Panel de Administracion</h1>
        <nav>
            <span>Bienvenido, <?php echo $_SESSION['admin']; ?></span>
            <a href="../index.php" target="_blank">Ver Catálogo</a>
            <a href="logout.php">Cerrar Sesión</a>
        </nav>
    </header>

    <div class="container">
        <h2>Gestion de Reservas</h2>
        <table border="1" cellpadding="10" style="width:100%; border-collapse: collapse;">
            <thead>
                <tr>
                    <th>Salon</th>
                    <th>Cliente</th>
                    <th>Fecha</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($reservas as $res): ?>
                <tr>
                    <td><?php echo htmlspecialchars($res['salon']); ?></td>
                    <td>
                        <?php echo htmlspecialchars($res['cliente_nombre']); ?><br>
                        <small><?php echo htmlspecialchars($res['cliente_contacto']); ?></small>
                    </td>
                    <td><?php echo $res['fecha_evento'] . ' ' . $res['hora_evento']; ?></td>
                    <td>
                        <span class="badge <?php echo strtolower($res['estado']); ?>">
                            <?php echo $res['estado']; ?>
                        </span>
                    </td>
                    <td>
                        <form action="acciones.php" method="POST" style="display:inline;">
                            <input type="hidden" name="id_reserva" value="<?php echo $res['id']; ?>">
                            <button name="accion" value="Confirmada" class="btn-small" style="background:green;">Confirmar</button>
                            <button name="accion" value="Cancelada" class="btn-small" style="background:red;">Cancelar</button>
                        </form>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>