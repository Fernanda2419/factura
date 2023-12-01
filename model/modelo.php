<?php
class Cliente {
    public $id_cliente;
    public $ruc_cliente;
    public $nombre_cliente;
    public $apellido_cliente;
}
class BaseDatos {

    // Constructor: Establecer conexión a la base de datos
    public function __construct($host, $usuario, $contrasena, $baseDatos) {
        $this->conexion = new mysqli($host, $usuario, $contrasena, $baseDatos);

        if ($this->conexion->connect_error) {
            die("Error de conexión: " . $this->conexion->connect_error);
        }
    }


    // Método para crear un nuevo cliente
    public function insertarCliente($ruc_cliente, $nombre_cliente, $apellido_cliente) {
        $stmt = $this->conexion->prepare("INSERT INTO cliente (ruc, nombre, apellido) VALUES (?, ?, ?)");
        $stmt->bind_param("sdi", $ruc_cliente, $nombre_cliente, $apellido_cliente);
        $stmt->execute();
        $stmt->close();
    }

    /* eliminar cliente*/
    public function eliminarCliente($id_cliente) {
        $stmt = $this->conexion->prepare("DELETE FROM cliente WHERE id = ?");
        $stmt->bind_param("i", $id_cliente);
        $stmt->execute();
        $stmt->close();
    }
    /* actualizar cliente*/
    public function actualizarCliente($id_cliente, $nuevo_ruc, $nuevo_nombre) {
        $stmt = $this->conexion->prepare("UPDATE cliente SET ruc = ?, nombre = ? WHERE id = ?");
        $stmt->bind_param("ssi", $nuevo_ruc, $nuevo_nombre, $id_cliente);
        $stmt->execute();
        $stmt->close();
    }
    /* obtener todos los clientes*/

    public function obtenerClientes() {
        $result = $this->conexion->query("SELECT * FROM cliente");
    
        while ($row = $result->fetch_object("Clientes")) {
            $cliente[] = $row;
        }

        return $cliente;
    }
   
    /* obtener cliente*/
    public function obtenerClientePorID($id_cliente) {
        $stmt = $this->conexion->prepare("SELECT * FROM cliente WHERE id = ?");
        $stmt->bind_param("i", $id_cliente);
        $stmt->execute();
    
        $result = $stmt->get_result();
    
        if ($result->num_rows > 0) {
            return $result->fetch_assoc();
        } else {
            return false;
        }
    }   
    
}

// Crear una instancia de la clase BaseDatos
$baseDatos = new BaseDatos("localhost", "root", '', "generacion_factura");

/* ---------------------------------------- */

// Insertar un nuevo producto
$baseDatos->insertarCliente("0605753375001", "Erika", "Perez");
$baseDatos->insertarCliente("0605753376001", "Karina", "Perez");
$baseDatos->insertarCliente("0605753374001", "Marlene", "Perez");

// Obtener todos los productos
//$productos = $baseDatos->obtenerTodosLosProductos();

// Imprimir todos los productos
/*echo "<br>Datos de todos los productos:<br>";
foreach ($productos as $producto) {
    echo "ID: " . $producto->id . "<br>";
    echo "Nombre: " . $producto->nombre . "<br>";
    echo "Precio: $" . $producto->cantidad . "<br>";
    echo "Stock: " . $producto->precio . "<br>";
    echo "<br>";
}*/

?>