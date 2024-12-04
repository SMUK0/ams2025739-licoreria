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

// Obtener los productos del carrito
$sql = "SELECT * FROM carrito";
$result = $conn->query($sql);

// Crear la tabla del carrito
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carrito de Compras</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <h1>Licorería La Copa</h1>
    </header>

    <div class="container">
        <h2>Carrito de Compras</h2>
        <table>
            <thead>
                <tr>
                    <th>Nombre del Producto</th>
                    <th>Cantidad</th>
                    <th>Precio Unitario</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()) { ?>
                <tr>
                    <td><?php echo $row['nombre']; ?></td>
                    <td><?php echo $row['cantidad']; ?></td>
                    <td>$<?php echo $row['precio']; ?></td>
                    <td>$<?php echo $row['subtotal']; ?></td>
                </tr>
                <?php } ?>
            </tbody>
        </table>

        <button onclick="window.location.href='SQA-PROYECTO/factura.php'">Ver Factura</button>
    </div>
</body>
</html>

<?php
$conn->close();
?>