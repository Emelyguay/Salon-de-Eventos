<?php
$host = "localhost";
$port = "5432";
$dbname = "postgres";   
$user = "postgres";
$password = "emely123"; 

try {
    // Conexion con PDO a PostgreSQL
    $conexion = new PDO("pgsql:host=$host;port=$port;dbname=$dbname", $user, $password);
    $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    echo "<h2>Conexión exitosa a PostgreSQL</h2>";

    //  Verificar si la tabla usuarios existe
   
    $check = $conexion->query("
        SELECT table_name 
        FROM information_schema.tables 
        WHERE table_schema = 'public'
        AND table_name = 'usuarios'
    ");

    if ($check->rowCount() === 0) {
        exit("<p style='color:red'>❌ La tabla <b>usuarios</b> NO existe.  
        Debes ejecutar el archivo SQL antes.</p>");
    }

    echo "<p>✔ La tabla <b>usuarios</b> existe.</p>";

    //Verificar si ya existe el usuario admin
    
    $stmt = $conexion->prepare("SELECT * FROM usuarios WHERE usuario = :user");
    $stmt->execute([':user' => 'admin']);

    if ($stmt->rowCount() > 0) {
        echo "<p>✔ El usuario <b>admin</b> ya existe. Nada que hacer.</p>";
    } else {

        echo "<p>Creando usuario admin...</p>";

        // Contraseña por defecto
        $defaultPassword = "123";
        $hashed = password_hash($defaultPassword, PASSWORD_BCRYPT);

        // Insertar admin
        $insert = $conexion->prepare("
            INSERT INTO usuarios (usuario, password, rol)
            VALUES (:user, :pass, 'admin')
        ");

        $insert->execute([
            ':user' => 'admin',
            ':pass' => $hashed
        ]);

        echo "<p style='color:green'>✔ Usuario admin creado correctamente</p>
              <p><b>Usuario:</b> admin <br>
              <b>Contraseña:</b> 123</p>";
    }

    echo "<p><a href='admin/login.php'>Ir al login</a></p>";

} catch (PDOException $e) {
    die("<p style='color:red'>Error: " . $e->getMessage() . "</p>");
}
?>
