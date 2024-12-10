<?php
$conn = new mysqli("localhost", "root", "", "mi_pagina_web");

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $rol = 'usuario'; // Por defecto, los usuarios registrados son "usuario"

    // Verificar si el nombre de usuario ya existe
    $query = $conn->prepare("SELECT * FROM usuarios WHERE username = ?");
    $query->bind_param("s", $username);
    $query->execute();
    $result = $query->get_result();

    if ($result->num_rows === 0) {
        // Insertar nuevo usuario
        $query = $conn->prepare("INSERT INTO usuarios (username, password, rol) VALUES (?, SHA2(?, 256), ?)");
        $query->bind_param("sss", $username, $password, $rol);

        if ($query->execute()) {
            $success = "¡Registro exitoso! Ahora puedes iniciar sesión.";
        } else {
            $error = "Error al registrar el usuario.";
        }
    } else {
        $error = "El nombre de usuario ya está en uso.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <h1>Regístrate</h1>
    </header>
    <main>
        <form action="registro.php" method="post">
            <label for="username">Nombre de Usuario:</label>
            <input type="text" name="username" id="username" required>
            <label for="password">Contraseña:</label>
            <input type="password" name="password" id="password" required>
            <button type="submit">Registrarse</button>
        </form>
        <?php if (isset($error)): ?>
            <p style="color: red;"><?php echo $error; ?></p>
        <?php endif; ?>
        <?php if (isset($success)): ?>
            <p style="color: green;"><?php echo $success; ?></p>
        <?php endif; ?>
        <p>¿Ya tienes una cuenta? <a href="login.php">Inicia sesión aquí</a>.</p>
    </main>
</body>
</html>