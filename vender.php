<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}
include 'header.php';

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "celrecycle";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

$user_id = $_SESSION['user_id'];

// Manejo de eliminación de venta
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete_id'])) {
    $delete_id = $conn->real_escape_string($_POST['delete_id']);
    $sql_delete = "DELETE FROM celulares WHERE id='$delete_id' AND user_id='$user_id'";
    
    if ($conn->query($sql_delete) === TRUE) {
        echo "Venta eliminada con éxito.";
    } else {
        echo "Error al eliminar la venta: " . $conn->error;
    }
}

// Procesar el formulario de venta
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['modelo']) && isset($_POST['precio']) && isset($_POST['descripcion']) && isset($_POST['imei'])) {
    $modelo = $conn->real_escape_string($_POST['modelo']);
    $precio = $conn->real_escape_string($_POST['precio']);
    $descripcion = $conn->real_escape_string($_POST['descripcion']);
    $imei = $conn->real_escape_string($_POST['imei']);
    
    // Manejo de subida de imagen
    $target_dir = "uploads/";
    
    // Verificar si la carpeta de subida existe
    if (!is_dir($target_dir)) {
        mkdir($target_dir, 0777, true);
    }

    $target_file = $target_dir . uniqid() . "_" . basename($_FILES["imagen"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Verificar si el archivo es una imagen real o un fake
    $check = getimagesize($_FILES["imagen"]["tmp_name"]);
    if($check !== false) {
        $uploadOk = 1;
    } else {
        echo "El archivo no es una imagen.";
        $uploadOk = 0;
    }

    // Verificar si el archivo ya existe
    if (file_exists($target_file)) {
        echo "Lo siento, el archivo ya existe.";
        $uploadOk = 0;
    }

    // Verificar el tamaño del archivo
    if ($_FILES["imagen"]["size"] > 500000) {
        echo "Lo siento, tu archivo es demasiado grande.";
        $uploadOk = 0;
    }

    // Limitar los formatos de archivo permitidos
    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
    && $imageFileType != "gif" ) {
        echo "Lo siento, solo se permiten archivos JPG, JPEG, PNG y GIF.";
        $uploadOk = 0;
    }

    // Verificar si $uploadOk está configurado a 0 por algún error
    if ($uploadOk == 0) {
        echo "Lo siento, tu archivo no fue subido.";
    // Si todo está bien, intenta subir el archivo
    } else {
        if (move_uploaded_file($_FILES["imagen"]["tmp_name"], $target_file)) {
            $imagen = $target_file;
            $sql = "INSERT INTO celulares (modelo, precio, descripcion, imei, imagen, user_id, valido) VALUES ('$modelo', '$precio', '$descripcion', '$imei', '$imagen', '$user_id', 0)";

            if ($conn->query($sql) === TRUE) {
                echo "Celular añadido con éxito.";
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
        } else {
            echo "Lo siento, hubo un error al subir tu archivo.";
        }
    }
}

// Obtener todos los celulares del usuario
$sql = "SELECT * FROM celulares WHERE user_id='$user_id'";
$result = $conn->query($sql);
?>



<section id="profile-section">
    <h2>Perfil del Usuario</h2>
    <!-- Aquí puede ir información adicional del perfil del usuario -->
</section>

<section id="sell-section">
    <h2>Vender Celulares</h2>
    <form action="vender.php" method="POST" enctype="multipart/form-data">
        <label for="modelo">Modelo del celular:</label>
        <input type="text" id="modelo" name="modelo" required><br>

        <label for="precio">Precio:</label>
        <input type="number" id="precio" name="precio" required><br>

        <label for="descripcion">Descripción:</label><br>
        <textarea id="descripcion" name="descripcion" rows="4" cols="50" required></textarea><br>

        <label for="imei">IMEI:</label>
        <input type="text" id="imei" name="imei" pattern="\d{15}" title="El IMEI debe ser un número de 15 dígitos" required><br>

        <label for="imagen">Subir imagen:</label>
        <input type="file" id="imagen" name="imagen" required><br>

        <button type="submit">Vender Celular</button>
    </form>
</section>

<section id="phones-section">
    <h2>Mis Celulares en Venta</h2>
    <?php
    if ($result->num_rows > 0) {
        echo '<table>';
        echo '<tr><th>Modelo</th><th>Precio</th><th>Descripción</th><th>IMEI</th><th>Imagen</th><th>Estado</th><th>Acciones</th></tr>';
        while($row = $result->fetch_assoc()) {
            echo '<tr>';
            echo '<td>' . htmlspecialchars($row['modelo']) . '</td>';
            echo '<td>' . htmlspecialchars($row['precio']) . '</td>';
            echo '<td>' . htmlspecialchars($row['descripcion']) . '</td>';
            echo '<td>' . htmlspecialchars($row['imei']) . '</td>';
            echo '<td><img src="' . htmlspecialchars($row['imagen']) . '"></td>';
            echo '<td>' . ($row['valido'] == 1 ? 'En venta' : 'En evaluación') . '</td>';
            echo '<td>
                    <form method="POST" action="vender.php">
                        <input type="hidden" name="delete_id" value="' . $row['id'] . '">
                        <button type="submit">Eliminar Venta</button>
                    </form>
                  </td>';
            echo '</tr>';
        }
        echo '</table>';
    } else {
        echo 'No tienes celulares en venta.';
    }
    $conn->close();
    ?>
</section>

<?php include 'footer.php'; ?>
