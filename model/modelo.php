<?php
class Producto {
    public $id;
    public $nombre;
    public $precio;
    public $stock;
}


class BaseDatos {

    // Constructor: Establecer conexión a la base de datos
    public function __construct($host, $usuario, $contrasena, $baseDatos) {
        $this->conexion = new mysqli($host, $usuario, $contrasena, $baseDatos);

        if ($this->conexion->connect_error) {
            die("Error de conexión: " . $this->conexion->connect_error);
        }
    }


    // Método para crear un nuevo producto
    public function insertarProducto($nombre, $cantidad, $precio) {
        $stmt = $this->conexion->prepare("INSERT INTO producto (nombre, cantidad, precio) VALUES (?, ?, ?)");
        $stmt->bind_param("sdi", $nombre, $cantidad, $precio);
        $stmt->execute();
        $stmt->close();
    }

    // Método para crear un nuevo producto
    public function obtenerTodosLosProductos() {
        $productos = array();

        $result = $this->conexion->query("SELECT * FROM producto");
        while ($row = $result->fetch_object("Producto")) {
            $productos[] = $row;
        }

        return $productos;
    }

    
}

// Crear una instancia de la clase BaseDatos
$baseDatos = new BaseDatos("localhost", "root", '', "generacion_factura");

/* ---------------------------------------- */

// Insertar un nuevo producto
$baseDatos->insertarProducto("camiseta", 10, 5);

// Obtener todos los productos
$productos = $baseDatos->obtenerTodosLosProductos();

// Imprimir todos los productos
echo "<br>Datos de todos los productos:<br>";
foreach ($productos as $producto) {
    echo "ID: " . $producto->id . "<br>";
    echo "Nombre: " . $producto->nombre . "<br>";
    echo "Precio: $" . $producto->cantidad . "<br>";
    echo "Stock: " . $producto->precio . "<br>";
    echo "<br>";
}


/* ---------------------------------------- */
?>