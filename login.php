<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if (isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
}
include 'header.php'; // Incluir el header aunque no muestre navegación
?>

<section id="login_section">
    <h1 class="login_title_bienvenido">Bienvenido a Shop LegalPHONE</h1>
    <div class="imagen_parpadeante"></div>
    <h2 class="login_title">Inicio de Sesión</h2>
    <form action="procesar_login.php" method="POST">
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required><br>

        <label for="password">Contraseña:</label>
        <input type="password" id="password" name="password" required><br>
        <div class="login_button_div">
            <button class="login_button" type="submit">Iniciar Sesión</button>
        </div>
    </form>
    <br>
    <form action="registro.php" method="get">
        <div class="register_button_div">
            <button class="register_button" type="submit">Registrar</button>
        </div>
    </form>
</section>

<?php include 'footer.php'; ?>

