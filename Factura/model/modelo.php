<?php
class Producto {
    public $id;
    public $nombre;
    public $precio;
    public $stock;
}

class Empresa {
    public $id_empresa;
    public $nombre_empresa;
    public $ruc_empresa;
    public $direccion;
}

class FormaPago {
    public $id_pago;
    public $tipo_pago;
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

    public function eliminarProducto($id) {
        $stmt = $this->conexion->prepare("DELETE FROM producto WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $stmt->close();
    }

    // Método para editar un producto por ID
    public function editarProducto($id, $nombre, $cantidad, $precio) {
        $stmt = $this->conexion->prepare("UPDATE producto SET nombre = ?, cantidad = ?, precio = ? WHERE id = ?");
        $stmt->bind_param("sdi", $nombre, $cantidad, $precio, $id);
        $stmt->execute();
        $stmt->close();
    }

     // Método para crear una nueva empresa
     public function insertarEmpresa($id_empresa, $nombre_empresa, $ruc_empresa, $direccion) {
        $stmt = $this->conexion->prepare("INSERT INTO empresa (nombre, ruc, direccion) VALUES (?, ?, ?)");
        $stmt->bind_param("sdi", $nombre_empresa, $ruc_empresa, $direccion);
        $stmt->execute();
        $stmt->close();
    }

    // Método para crear una nueva empresa
    public function obtenerDatosEmpresas() {
        $empresas = array();

        $result = $this->conexion->query("SELECT * FROM empresa");
        while ($row = $result->fetch_object("Empresa")) {
            $empresas[] = $row;
        }

        return $empresas;
    }   
    
}

// Crear una instancia de la clase BaseDatos
$baseDatos = new BaseDatos("localhost", "root", '', "generacion_factura");

/* ---------------------------------------- */

// Insertar un nuevo producto
$baseDatos->insertarProducto("camiseta", 10, 5);

// Obtener todos los productos
$productos = $baseDatos->obtenerTodosLosProductos();

// Ejemplo de eliminar un producto por ID (cambia el ID según tus necesidades)
$baseDatos->eliminarProducto(2);

// Ejemplo de editar un producto por ID (cambia los valores según tus necesidades)
$baseDatos->editarProducto(2, "nuevo_nombre", 15, 8);

// Imprimir todos los productos
echo "<br>Datos de todos los productos:<br>";
foreach ($productos as $producto) {
    echo "ID: " . $producto->id . "<br>";
    echo "Nombre: " . $producto->nombre . "<br>";
    echo "Precio: $" . $producto->cantidad . "<br>";
    echo "Stock: " . $producto->precio . "<br>";
    echo "<br>";
}

// Insertar una nueva empresa
$baseDatos->insertarEmpresa("La Favorita", "1415765476655", "Canonigo");

// Obtener todas las empresas
$empresas = $baseDatos->obtenerDatosEmpresas();

// Imprimir todos los empresa
echo "<br>Datos de todos los empresas:<br>";
foreach ($empresas as $empresa) {
    echo "ID: " . $empresa->id_empresa . "<br>";
    echo "Nombre Empresa: " . $empresa->nombre_empresa . "<br>";
    echo "RUC Empresa: $" . $empresa->ruc_empresa . "<br>";
    echo "Direccion: " . $empresa->direccion . "<br>";
    echo "<br>";
}

?>