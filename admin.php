<?php
include 'header.php';

$servername = "celrecycle-sev.database.windows.net
";
$username = "Mateo";
$password = "Vivaelapra2021@";
$dbname = "celrecycle-db";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Validación de celulares pendientes
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['validate_id'])) {
    $validate_id = $conn->real_escape_string($_POST['validate_id']);
    $sql_validate = "UPDATE celulares SET valido=1 WHERE id='$validate_id'";
    
    if ($conn->query($sql_validate) === TRUE) {
        echo "Celular validado correctamente.";
    } else {
        echo "Error al validar el celular: " . $conn->error;
    }
}

// Obtener todos los celulares no validados
$sql = "SELECT * FROM celulares WHERE valido=0";
$result = $conn->query($sql);
?>

<section id="admin-section">
    <h2>Administración de Celulares Pendientes de Validación</h2>
    <?php
    if ($result->num_rows > 0) {
        echo '<table>';
        echo '<tr><th>Usuario</th><th>Modelo</th><th>Precio</th><th>Descripción</th><th>IMEI</th><th>Imagen</th><th>Acciones</th></tr>';
        while($row = $result->fetch_assoc()) {
            echo '<tr>';
            echo '<td>' . htmlspecialchars($row['user_id']) . '</td>'; // Mostrar el usuario asociado al celular
            echo '<td>' . htmlspecialchars($row['modelo']) . '</td>';
            echo '<td>' . htmlspecialchars($row['precio']) . '</td>';
            echo '<td>' . htmlspecialchars($row['descripcion']) . '</td>';
            echo '<td>' . htmlspecialchars($row['imei']) . '</td>';
            echo '<td><img src="' . htmlspecialchars($row['imagen']) . '"></td>';
            echo '<td>
                    <form method="POST" action="admin.php">
                        <input type="hidden" name="validate_id" value="' . $row['id'] . '">
                        <button type="submit">Validar Celular</button>
                    </form>
                  </td>';
            echo '</tr>';
        }
        echo '</table>';
    } else {
        echo 'No hay celulares pendientes de validación.';
    }
    $conn->close();
    ?>
</section>

<?php include 'footer.php'; ?>
