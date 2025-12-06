<?php
require 'db/conexion.php';

$mensaje = "";
$salon_id = isset($_GET['id']) ? $_GET['id'] : null;

// Validar que exista el salon
if ($salon_id) {
    $stmt = $conexion->prepare("SELECT * FROM salones WHERE id = :id");
    $stmt->execute([':id' => $salon_id]);
    $salon = $stmt->fetch(PDO::FETCH_ASSOC);
}

// Procesar el formulario
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = $_POST['nombre'];
    $contacto = $_POST['contacto'];
    $fecha = $_POST['fecha'];
    $hora = $_POST['hora'];
    $s_id = $_POST['salon_id'];

    $sql = "INSERT INTO reservas (salon_id, cliente_nombre, cliente_contacto, fecha_evento, hora_evento) 
            VALUES (:sid, :nom, :con, :fec, :hor)";
    $stmt = $conexion->prepare($sql);
    
    if ($stmt->execute([':sid' => $s_id, ':nom' => $nombre, ':con' => $contacto, ':fec' => $fecha, ':hor' => $hora])) {
        $mensaje = "¡Solicitud enviada con exito! El administrador revisara su reserva.";
    } else {
        $mensaje = "Hubo un error al registrar la reserva.";
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reservar Salón</title>
    <link rel="stylesheet" href="css/estilo.css">
</head>
<body>
    <header>
        <h1>Eventos Exclusivos</h1>
        <nav><a href="index.php">Volver al Catálogo</a></nav>
    </header>

    <div class="container">
        <div class="card" style="max-width: 600px; margin: 0 auto;">
            <div class="card-header">
                Reservar: <?php echo isset($salon) ? $salon['nombre'] : 'Salón no encontrado'; ?>
            </div>
            <div class="card-body">
                <?php if ($mensaje): ?>
                    <p style="background: #d4edda; color: #155724; padding: 10px;"><?php echo $mensaje; ?></p>
                <?php endif; ?>

                <?php if (isset($salon)): ?>
                <form method="POST">
                    <input type="hidden" name="salon_id" value="<?php echo $salon['id']; ?>">
                    
                    <label>Su Nombre:</label>
                    <input type="text" name="nombre" required class="input-full">
                    
                    <label>Teléfono / Email:</label>
                    <input type="text" name="contacto" required class="input-full">
                    
                    <label>Fecha del Evento:</label>
                    <input type="date" name="fecha" required class="input-full">
                    
                    <label>Hora del Evento:</label>
                    <input type="time" name="hora" required class="input-full">
                    
                    <br><br>
                    <button type="submit" class="btn">Confirmar Solicitud</button>
                </form>
                <?php else: ?>
                    <p>Error: Salon no especificado.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</body>
</html>
