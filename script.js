const formulario = document.getElementById('formulario');
const productosDiv = document.getElementById('productos');

// Función para crear un producto
function crearProducto(event) {
    event.preventDefault();
    const nombre = document.getElementById('nombre').value;
    const descripcion = document.getElementById('descripcion').value;
    const precio = document.getElementById('precio').value;

    // Enviar datos a la base de datos
    fetch('crear_producto.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ nombre, descripcion, precio })
    })
    .then(response => response.json())
    .then(data => {
        console.log(data);
        mostrarProductos();
    })
    .catch(error => console.error(error));
}

// Función para mostrar los productos
function mostrarProductos() {
    fetch('leer_productos.php')
    .then(response => response.json())
    .then(data => {
        const productos = data.productos;
        let html = '';
        productos.forEach(producto => {
            html += `
                <div class="producto">
                    <h2>${producto.nombre}</h2>
                    <p>${producto.descripcion}</p>
                    <p>Precio: ${producto.precio}</p>
                    <button class="editar" data-id="${producto.id}">Editar</button>
                    <button class="eliminar" data-id="${producto.id}">Eliminar</button>
                </div>
            `;
        });
        productosDiv.innerHTML = html;
    })
    .catch(error => console.error(error));
}

// Función para editar un producto
function editarProducto(event) {
    const id = event.target.dataset.id;
    const nombre = document.getElementById(`nombre-${id}`).value;
    const descripcion = document.getElementById(`descripcion-${id}`).value;
    const precio = document.getElementById(`precio-${id}`).value;

    // Enviar datos a la base de datos
    fetch('editar_producto.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ id, nombre, descripcion, precio })
    })
    .then(response => response.json())
    .then(data => {
        console.log(data);
        mostrarProductos();
    })
    .catch(error => console.error(error));
}

// Función para eliminar un producto
function eliminarProducto(event) {
    const id = event.target.dataset.id;

    // Enviar datos a la base de datos
    fetch('eliminar_producto.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ id })
    })
    .then(response => response.json())
    .then(data => {
        console.log(data);
        mostrarProductos();
    })
    .catch(error => console.error(error));
}

// Agregar eventos a los botones
formulario.addEventListener('submit', crearProducto);
document.addEventListener('click', (event) => {
    if (event.target.classList.contains('editar')) {
        editarProducto(event);
    } else if (event.target.classList.contains('eliminar')) {
        eliminarProducto(event);
    }
});

// Mostrar productos al cargar la página
mostrarProductos();