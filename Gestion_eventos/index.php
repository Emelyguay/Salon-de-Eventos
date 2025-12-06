<?php
require 'db/conexion.php';

// consultar salones
try {
    $sql = "SELECT * FROM salones WHERE activo = TRUE ORDER BY id ASC";
    $stmt = $conexion->prepare($sql);
    $stmt->execute();
    $salones = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Error al cargar salones: " . $e->getMessage();
    die();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eventos Exclusivos - Reserva de Salones</title>
    <link rel="stylesheet" href="css/estilo.css">
</head>
<body>

    <header>
        <div class="logo">
            <h1>Eventos Exclusivos</h1>
        </div>
        <nav>
            <a href="admin/login.php" class="btn-small" style="background: transparent; border: 1px solid white;">Acceso Admin</a>
        </nav>
    </header>

    <div class="container">
        <div style="text-align: center; margin-bottom: 30px;">
            <h2>Nuestros Salones Disponibles</h2>
            <p>Seleccione el salon ideal para su proximo evento.</p>
        </div>
        
        <div class="grid-salones">
            <?php if (count($salones) > 0): ?>
                <?php foreach($salones as $salon): ?>
                <div class="card">
                    
                    <?php 
                        // Verificamos si la ruta de la imagen existe y no esta vacia
                        // si la imagen falla o no carga colocamos una imagen como manejo
                        // de error que diga que la imagen no esta disponible o que fallo
                        $imagen = !empty($salon['imagen_url']) ? $salon['imagen_url'] : 'imagenes/default.jpg';
                    ?>
                    <img src="<?php echo htmlspecialchars($imagen); ?>" 
    
                         alt="Imagen del salon"
                         onerror="this.src='imagenes/imagenNoDispo';"> 
                         <div class="card-header">
                        <?php echo htmlspecialchars($salon['nombre']); ?>
                    </div>

                    <div class="card-body">
                        <p><strong>Capacidad:</strong> <?php echo $salon['capacidad']; ?> personas</p>
                        <p><strong>Ubicacion:</strong> <?php echo htmlspecialchars($salon['ubicacion']); ?></p>
                        <p><strong>Precio:</strong> <span style="color: green; font-weight: bold;">$<?php echo number_format($salon['precio'], 2); ?></span></p>
                        <p style="font-size: 0.9em; color: #555;"><?php echo htmlspecialchars($salon['descripcion']); ?></p>

                        <a href="reservar.php?id=<?php echo $salon['id']; ?>" class="btn btn-block">
                            Reservar Ahora
                        </a>
                    </div>
                </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p style="text-align: center; width: 100%;">No hay salones disponibles en este momento.</p>
            <?php endif; ?>
        </div>
    </div>

</body>
</html>