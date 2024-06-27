<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}
include 'header.php';

// Conexión a la base de datos
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "celrecycle";

$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Obtener ejemplos de celulares
$sql = "SELECT modelo, precio, descripcion, imagen FROM celulares WHERE valido = 1 LIMIT 5";
$result = $conn->query($sql);
?>

<section class="centered">
        <h2 class="titulo-bienvenido">Bienvenido, <?php echo htmlspecialchars($_SESSION['user_name']); ?>!</h2>
        <ul class="celular-list">
            <div class="celulares_ventas">
                <?php
                $counter = 1;
                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {

                        echo "<li class='celular-item'>"; 
                        echo "<div class='celular-info'>";
                            echo "<div class='modelo-precio'>";
                                echo "<h1 class='titulo_numero'  <strong> Dispositivo N°" . $counter++ . "</strong></h1>";
                                echo "<div class='modelo'><strong>Modelo:</strong> " . htmlspecialchars($row["modelo"]) . "</div>";
                                echo "<div class='precio'><strong>Precio:</strong> $" . htmlspecialchars($row["precio"]) . "</div>";
                                echo "<div class='descripcion'><strong>Descripción:</strong> " . htmlspecialchars($row["descripcion"]) . "</div>";
                            echo "</div>";
                            echo "<div class='imagen-div'>";
                                if (!empty($row["imagen"])) {
                                    echo "<div class='imagen'><img class='img-imagen' src='" . htmlspecialchars($row["imagen"]) . "' alt='Imagen del celular'></div>";
                                }
                            echo "</div>";
                        echo "</div>";   
                        echo "<hr style='border: 2px solid black;'>";
                        echo "</li>";
                    }
                } else {
                    echo "<p>No hay celulares en venta.</p>";
                }
                ?>
            </div>
        </ul>
    </section>


<?php
$conn->close();
include 'footer.php';
?>