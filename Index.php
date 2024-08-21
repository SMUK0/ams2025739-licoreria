<?php
// Conexión a la base de datos
$servername = "localhost";
$username = "root";
$password = "";
$database = "licoreria_db";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Agregar producto al carrito
if (isset($_POST['add_to_cart'])) {
    $producto_id = $_POST['producto_id'];
    $cantidad = $_POST['cantidad'];

    // Obtener precio del producto
    $sql = "SELECT precio FROM productos WHERE id = $producto_id";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    $subtotal = $row['precio'] * $cantidad;

    // Insertar en la tabla carrito
    $sql = "INSERT INTO carrito (producto_id, cantidad, subtotal) 
            VALUES ($producto_id, $cantidad, $subtotal)";
    $conn->query($sql);
}

$sql = "SELECT * FROM productos";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Licorería La Copa</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <h1>Licorería La Copa</h1>
    </header>

    <nav>
        <a href="login.php">Iniciar sesión</a>
        <a href="register.php">Registrarse</a>
        <a href="gestion_productos.php">Gestión de Productos</a>
        <a href="carrito.php">Carrito</a>
    </nav>

    <div class="container">
        <section id="products" class="product-gallery">
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<div class='product'>";
                    echo "<img src='" . $row['imagen_url'] . "' alt='Producto'>";
                    echo "<h3>" . $row['nombre'] . "</h3>";
                    echo "<p>Precio: $" . $row['precio'] . "</p>";
                    echo "<form method='post'>";
                    echo "<input type='hidden' name='producto_id' value='" . $row['id'] . "'>";
                    echo "<label for='cantidad'>Cantidad:</label>";
                    echo "<input type='number' name='cantidad' value='1' min='1'>";
                    echo "<button type='submit' name='add_to_cart'>Añadir al carrito</button>";
                    echo "</form>";
                    echo "</div>";
                }
            } else {
                echo "<p>No hay productos disponibles.</p>";
            }
            ?>
        </section>
    </div>
</body>
</html>

<?php
$conn->close();
?>
