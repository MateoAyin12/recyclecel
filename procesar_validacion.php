<?php
// Verificar si se ha enviado el formulario desde admin.php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recibir datos del formulario
    $modelo = $_POST['modelo'];
    $precio = $_POST['precio'];
    $descripcion = $_POST['descripcion'];
    // Aquí podrías incluir la validación del IMEI si es necesario
    // $imei = $_POST['imei'];

    // Procesar la validación en la base de datos
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

    // Preparar consulta SQL para actualizar el estado de validación
    $sql = "UPDATE celulares SET valido = 1 WHERE modelo = '$modelo' AND precio = '$precio' AND descripcion = '$descripcion'";

    if ($conn->query($sql) === TRUE) {
        echo "Celular validado correctamente.";
    } else {
        echo "Error al validar celular: " . $conn->error;
    }

    $conn->close();
}
?>
