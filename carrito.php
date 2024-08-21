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

// Función para mostrar productos en el carrito
function mostrarCarrito($conn) {
    $sql = "SELECT carrito.id, productos.nombre, carrito.cantidad, carrito.subtotal 
            FROM carrito 
            JOIN productos ON carrito.producto_id = productos.id";
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
        $total = 0;
        while ($row = $result->fetch_assoc()) {
            echo "<div class='product'>";
            echo "<h3>" . $row['nombre'] . "</h3>";
            echo "<p>Cantidad: " . $row['cantidad'] . "</p>";
            echo "<p>Subtotal: $" . $row['subtotal'] . "</p>";
            echo "</div>";
            $total += $row['subtotal'];
        }
        echo "<h3>Total: $" . $total . "</h3>";
        echo "<form method='post'>";
        echo "<button type='submit' name='comprar'>Comprar</button>";
        echo "</form>";
    } else {
        echo "<p>No hay productos en el carrito.</p>";
    }
}

// Procesar la compra
if (isset($_POST['comprar'])) {
    $sql = "SELECT carrito.producto_id, carrito.cantidad, productos.cantidad AS stock 
            FROM carrito 
            JOIN productos ON carrito.producto_id = productos.id";
    $result = $conn->query($sql);

    while ($row = $result->fetch_assoc()) {
        if ($row['cantidad'] > $row['stock']) {
            echo "<p>No hay suficiente stock para " . $row['producto_id'] . ".</p>";
            exit;
        } else {
            $nuevoStock = $row['stock'] - $row['cantidad'];
            $updateStock = "UPDATE productos SET cantidad = $nuevoStock WHERE id = " . $row['producto_id'];
            $conn->query($updateStock);
        }
    }

    $conn->query("TRUNCATE TABLE carrito"); // Vaciar el carrito después de la compra
    echo "<script>alert('Compra exitosa. ¡Gracias por su compra!');</script>";
    echo '<a href="factura.php">Ver Factura</a>'; // Redirigir a factura.php
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carrito - Licorería La Copa</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <h1>Carrito de Compras</h1>
    </header>

    <div class="container">
        <?php mostrarCarrito($conn); ?>
    </div>
    <nav>
        <a href="Index.php">Pagina principal</a>
    </nav>
</body>
</html>

<?php
$conn->close();
?>