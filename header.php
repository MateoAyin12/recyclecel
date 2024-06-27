<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shop LegalPHONE</title>
    <link rel="stylesheet" href="estilos13.css"> <!-- Agregando el enlace al archivo CSS -->
    <link rel="icon" href="imagenes/logo.png" type="image/x-icon">
</head>
<body>
    <?php if (isset($_SESSION['user_id'])): ?>
        <header>
            <h1>Shop LegalPHONE</h1>
            <nav>
                <ul>
                    <li><a href="index.php">Inicio</a></li>
                    <li><a href="vender.php">Vender Celulares</a></li>
                    <li><a href="logout.php">Cerrar Sesión</a></li>
                </ul>
            </nav>
        </header>
        <main>
    <?php endif; ?>
