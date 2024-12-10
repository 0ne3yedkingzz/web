<?php

session_start();
// Conectar a la base de datos
$conn = new mysqli("localhost", "root", "", "mi_pagina_web");


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titulo = $_POST['titulo'];
    $imagen = addslashes(file_get_contents($_FILES['imagen']['tmp_name']));
    $sql = "INSERT INTO galeria (titulo, imagen) VALUES ('$titulo', '$imagen')";
    $conn->query($sql);
    echo "Imagen subida exitosamente.";
}


$result = $conn->query("SELECT * FROM galeria");
?>

<!DOCTYPE html>
<html lang="es">
<a href="logout.php">Cerrar Sesión</a>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Galería de Fotos</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <h1>Galería de Fotos</h1>
        <a href="index.php">Volver a la Página Principal</a>
    </header>
    <main>
        <form action="galeria.php" method="post" enctype="multipart/form-data">
            <label for="titulo">Título de la imagen:</label>
            <input type="text" name="titulo" id="titulo" required>
            <label for="imagen">Subir imagen:</label>
            <input type="file" name="imagen" id="imagen" accept="image/*" required>
            <button type="submit">Subir</button>
        </form>

        <h2>Imágenes en la Galería</h2>
        <div class="galeria">
            <?php while ($row = $result->fetch_assoc()): ?>
                <div class="imagen">
                    <h3><?php echo $row['titulo']; ?></h3>
                    <img src="data:image/jpeg;base64,<?php echo base64_encode($row['imagen']); ?>" alt="<?php echo $row['titulo']; ?>">
                </div>
            <?php endwhile; ?>
        </div>
    </main>
</body>
</html>