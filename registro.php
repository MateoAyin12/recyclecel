<?php include 'header.php'; ?>

<section id="registro_section">
    <h2 class="registro_title">Registro de Clientes</h2>
    <form action="procesar_registro.php" method="POST" class="registro_form">
        <label for="nombre" class="registro_label">Nombre:</label>
        <input type="text" id="nombre" name="nombre" class="registro_input" required><br>

        <label for="email" class="registro_label">Email:</label>
        <input type="email" id="email" name="email" class="registro_input" required><br>

        <label for="password" class="registro_label">Contraseña:</label>
        <input type="password" id="password" name="password" class="registro_input" required><br>

        <div class="registro_button_div">
            <button type="submit" class="registro_button">Registrarse</button>
        </div>
    </form>
</section>

<?php include 'footer.php'; ?>
