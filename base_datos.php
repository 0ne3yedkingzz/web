<?php
session_start();
// Conexión a la base de datos
$conn = new mysqli("localhost", "root", "", "mi_pagina_web");

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Insertar registro
if (isset($_POST['agregar'])) {
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $conn->query("INSERT INTO registros (nombre, descripcion) VALUES ('$nombre', '$descripcion')");
}

// Eliminar registro
if (isset($_GET['eliminar'])) {
    $id = $_GET['eliminar'];
    $conn->query("DELETE FROM registros WHERE id = $id");
}

// Actualizar registro
if (isset($_POST['actualizar'])) {
    $id = $_POST['id'];
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $conn->query("UPDATE registros SET nombre = '$nombre', descripcion = '$descripcion' WHERE id = $id");
    header("Location: base_datos.php"); // Redirigir para evitar reenvíos
    exit();
}

// Consultar registros
$result = $conn->query("SELECT * FROM registros");
?>


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Base de Datos</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <h1>Gestión de Base de Datos</h1>
        <a href="index.php">Volver a la Página Principal</a>
    </header>
    <main>
        <!-- Formulario para agregar registros -->
        <form action="base_datos.php" method="post">
            <label for="nombre">Nombre:</label>
            <input type="text" name="nombre" id="nombre" required>
            <label for="descripcion">Descripción:</label>
            <textarea name="descripcion" id="descripcion" required></textarea>
            <button type="submit" name="agregar">Agregar</button>
        </form>

        <!-- Tabla de registros -->
        <h2>Registros Existentes</h2>
        <table>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Descripción</th>
                <th>Acciones</th>
            </tr>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $row['id']; ?></td>
                    <td><?php echo $row['nombre']; ?></td>
                    <td><?php echo $row['descripcion']; ?></td>
                    <td>
                        <a href="base_datos.php?editar=<?php echo $row['id']; ?>">Editar</a> |
                        <a href="base_datos.php?eliminar=<?php echo $row['id']; ?>" onclick="return confirm('¿Estás seguro de eliminar este registro?');">Eliminar</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </table>

        <!-- Formulario para editar registros -->
        <?php if (isset($_GET['editar'])): ?>
            <?php
            $id = $_GET['editar'];
            $registro = $conn->query("SELECT * FROM registros WHERE id = $id")->fetch_assoc();
            ?>
            <form action="base_datos.php" method="post">
                <input type="hidden" name="id" value="<?php echo $registro['id']; ?>">
                <label for="nombre">Nombre:</label>
                <input type="text" name="nombre" id="nombre" value="<?php echo $registro['nombre']; ?>" required>
                <label for="descripcion">Descripción:</label>
                <textarea name="descripcion" id="descripcion" required><?php echo $registro['descripcion']; ?></textarea>
                <button type="submit" name="actualizar">Actualizar</button>
                <a href="base_datos.php">Cancelar</a>
            </form>
        <?php endif; ?>
    </main>
</body>
</html>