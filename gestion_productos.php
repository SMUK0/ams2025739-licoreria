<?php
// Conexión a la base de datos
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "licoreria_db";

$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Procesar el formulario para agregar un nuevo producto
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $precio = $_POST['precio'];
    $cantidad = $_POST['cantidad'];
    $imagen_url = $_POST['imagen_url'];

    $sql = "INSERT INTO productos (nombre, descripcion, precio, cantidad, imagen_url) VALUES ('$nombre', '$descripcion', '$precio', '$cantidad', '$imagen_url')";

    if ($conn->query($sql) === TRUE) {
        echo "Nuevo producto añadido exitosamente";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Obtener los productos de la base de datos
$sql = "SELECT nombre, descripcion, precio, imagen_url FROM productos";
$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Productos - Licorería La Copa</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <h1>Gestión de Productos - Licorería La Copa</h1>
    </header>

    <nav>
        <a href="login.php">Iniciar Sesión</a>
        <a href="Compras.html">Compras</a>
        <a href="register.php">Registrarse</a>
        <a href="gestion_productos.php">Gestión De Productos</a>
    </nav>

    <div class="container">
        <h2>Añadir Nuevo Producto</h2>
        <form action="gestion_productos.php" method="post">
            <label for="nombre">Nombre del Producto</label>
            <input type="text" id="nombre" name="nombre" required>

            <label for="descripcion">Descripción</label>
            <textarea id="descripcion" name="descripcion" required></textarea>

            <label for="precio">Precio</label>
            <input type="number" id="precio" name="precio" required>

            <label for="cantidad">Cantidad</label>
            <input type="number" id="cantidad" name="cantidad" required>

            <label for="imagen_url">URL de la Imagen</label>
            <input type="text" id="imagen_url" name="imagen_url" required>

            <button type="submit">Añadir Producto</button>
        </form>

        <h2>Productos Existentes</h2>
        <div class="product-gallery">
            <?php
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo "<div class='product'>";
                    echo "<img src='" . $row["imagen_url"] . "' alt='Producto'>";
                    echo "<h3>" . $row["nombre"] . "</h3>";
                    echo "<p>" . $row["descripcion"] . "</p>";
                    echo "<p>Precio: $" . $row["precio"] . "</p>";
                    echo "<button>Añadir al Carrito</button>";
                    echo "</div>";
                }
            } else {
                echo "No hay productos disponibles.";
            }
            ?>
        </div>
    </div>

</body>
</html>

<?php
$conn->close();
?>
