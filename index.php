<?php
session_start();
// Conectar a la base de datos
$conn = new mysqli("localhost", "root", "", "mi_pagina_web");

// Verificar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Obtener imágenes recientes de la galería
$result = $conn->query("SELECT * FROM galeria ORDER BY id DESC LIMIT 3");
?>
<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <h1>Bienvenido, <?php echo htmlspecialchars($_SESSION['usuario']); ?></h1>
        <nav>
            <ul>
                <li><a href="galeria.php">Galería</a></li>
                <?php if ($_SESSION['rol'] === 'admin'): ?>
                    <li><a href="base_datos.php">Gestión de Datos</a></li>
                <?php endif; ?>
                <li><a href="logout.php">Cerrar Sesión</a></li>
            </ul>
        </nav>
    </header>
    <main>
        <h2>¡Bienvenido a nuestro sitio!</h2>
        <p>Selecciona una opción del menú para continuar.</p>
    </main>
</body>
</html>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio - Subir y Compartir Imágenes</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <h1>Bienvenido a <span style="color: #FFD700;">ImagenUp</span></h1>
        <nav>
            <ul>
                <li><a href="galeria.php">Galería</a></li>
                <li><a href="base_datos.php">Gestión de Datos</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <!-- Hero Section -->
        <section class="hero">
            <h2>Sube, comparte y explora imágenes increíbles</h2>
            <p>En ImagenUp puedes subir tus mejores fotos, almacenarlas y compartirlas con el mundo.</p>
            <div class="cta-buttons">
                <a href="galeria.php" class="btn">Explorar Galería</a>
                <a href="galeria.php" class="btn">Subir Imágenes</a>
            </div>
        </section>

        <!-- Sección Dinámica: Imágenes Recientes -->
        <section class="imagenes-recientes">
            <h2>Imágenes Recientes</h2>
            <div class="galeria">
                <?php while ($row = $result->fetch_assoc()): ?>
                    <div class="imagen">
                        <h3><?php echo $row['titulo']; ?></h3>
                        <img src="data:image/jpeg;base64,<?php echo base64_encode($row['imagen']); ?>" alt="<?php echo $row['titulo']; ?>">
                    </div>
                <?php endwhile; ?>
            </div>
            <p><a href="galeria.php">Ver todas las imágenes</a></p>
        </section>

        <!-- Características -->
        <section class="features">
            <h2>¿Por qué usar ImagenUp?</h2>
            <div class="features-container">
                <div class="feature">
                    <h3>Almacenamiento Seguro</h3>
                    <p>Tu contenido está protegido y puedes acceder a él en cualquier momento.</p>
                </div>
                <div class="feature">
                    <h3>Fácil de Usar</h3>
                    <p>Sube imágenes de manera sencilla y organiza tu galería personal.</p>
                </div>
                <div class="feature">
                    <h3>Accesible desde cualquier lugar</h3>
                    <p>Comparte tus imágenes con amigos desde cualquier dispositivo.</p>
                </div>
            </div>
        </section>
    </main>

    <footer>
        <p>&copy; 2024 ImagenUp | Tu plataforma para compartir imágenes</p>
    </footer>
</body>
</html>
<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <h1>Bienvenido, <?php echo htmlspecialchars($_SESSION['usuario']); ?></h1>
        <nav>
            <ul>
                <li><a href="galeria.php">Galería</a></li>
                <?php if ($_SESSION['rol'] === 'admin'): ?>
                    <li><a href="base_datos.php">Gestión de Datos</a></li>
                <?php endif; ?>
                <li><a href="logout.php">Cerrar Sesión</a></li>
            </ul>
        </nav>
    </header>
    <main>
        <h2>¡Bienvenido a nuestro sitio!</h2>
        <p>Selecciona una opción del menú para continuar.</p>
    </main>
</body>
</html>

4. Página de Cerrar Sesión (logout.php)

Este archivo elimina la sesión y las cookies.

<?php
session_start();
if (isset($_COOKIE['login_token'])) {
    setcookie("login_token", "", time() - 3600, "/");
}
session_destroy();
header("Location: login.php");
exit();
?>