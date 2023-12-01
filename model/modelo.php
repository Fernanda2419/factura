<?php

class Cliente {
    public $id_cliente;
    public $ruc_cliente;
    public $nombre_cliente;
    public $apellido_cliente;
}
class Cliente_CRUD {
    private $conexion;

    public function __construct($host, $usuario, $contrasena, $baseDatos) {
        $this->conexion = new mysqli($host, $usuario, $contrasena, $baseDatos);

        if ($this->conexion->connect_error) {
            die("Error de conexión: " . $this->conexion->connect_error);
        }
    }
    /* funciones crud */
    /* insertar cliente */

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
    
        if ($result) {
            return $result->fetch_all(MYSQLI_ASSOC);
        } else {
            return false;
        }
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
$baseDatos = new BaseDatos("localhost", "root", '', "ejemplo_orm");

// Insertar un nuevo producto
$baseDatos->insertarCliente("0605753375001", "Erika", "Perez");
$baseDatos->insertarCliente("0605753376001", "Karina", "Perez");
$baseDatos->insertarCliente("0605753374001", "Marlene", "Perez");
//eliminar cliente 
$baseDatos->eliminarCliente(1);
// Obtener un producto por su ID
$producto = $baseDatos->obtenerClientePorID(2);

// Imprimir los datos del producto obtenido por ID
echo "Datos del cliente por ID:<br>";
echo "ID: " . $cliente->id_cliente . "<br>";
echo "Ruc: " . $cliente->ruc_cliente . "<br>";
echo "Nombre: $" . $cliente->nombre_cliente . "<br>";
echo "Apellido: $" . $cliente->apellido_cliente . "<br>";

// Obtener todos los productos
$productos = $baseDatos->obtenerClientes();

// Imprimir todos los productos
echo "<br>Datos de todos los clientes:<br>";
foreach ($cliente as $cliente) {
    echo "ID: " . $cliente->id_cliente . "<br>";
    echo "Ruc: " . $cliente->ruc_cliente . "<br>";
    echo "Nombre: $" . $cliente->nombre_cliente . "<br>";
    echo "Apellido: $" . $cliente->apellido_cliente . "<br>";
}

class Factura {
    public $id_factura;
    public $num_factura;
    public $auto_sri;
    public $fecha_emision;
    public $guia_emision;
    public $iva;
    public $descuento;
    
    // Puedes agregar más métodos o lógica según tus necesidades
}
class Factura_CRUD {
    private $conexion;

    public function __construct($host, $usuario, $contrasena, $baseDatos) {
        $this->conexion = new mysqli($host, $usuario, $contrasena, $baseDatos);

        if ($this->conexion->connect_error) {
            die("Error de conexión: " . $this->conexion->connect_error);
        }
    }

    /* funciones CRUD para Cliente */

    // ...

    /* funciones CRUD para Factura */

    public function insertarFactura(Factura $factura) {
        $stmt = $this->conexion->prepare("INSERT INTO factura (num_factura, auto_sri, fecha_emision, guia_emision, iva, descuento) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("dssssd", $factura->num_factura, $factura->auto_sri, $factura->fecha_emision, $factura->guia_emision, $factura->iva, $factura->descuento);
        $stmt->execute();
        $stmt->close();
    }

    public function eliminarFactura($id_factura) {
        $stmt = $this->conexion->prepare("DELETE FROM factura WHERE id_factura = ?");
        $stmt->bind_param("i", $id_factura);
        $stmt->execute();
        $stmt->close();
    }

    public function actualizarFactura(Factura $factura) {
        $stmt = $this->conexion->prepare("UPDATE factura SET num_factura = ?, auto_sri = ?, fecha_emision = ?, guia_emision = ?, iva = ?, descuento = ? WHERE id_factura = ?");
        $stmt->bind_param("dssssdi", $factura->num_factura, $factura->auto_sri, $factura->fecha_emision, $factura->guia_emision, $factura->iva, $factura->descuento, $factura->id_factura);
        $stmt->execute();
        $stmt->close();
    }

    public function obtenerFacturas() {
        $result = $this->conexion->query("SELECT * FROM factura");
    
        if ($result) {
            return $result->fetch_all(MYSQLI_ASSOC);
        } else {
            return false;
        }
    }

    public function obtenerFacturaPorID($id_factura) {
        $stmt = $this->conexion->prepare("SELECT * FROM factura WHERE id_factura = ?");
        $stmt->bind_param("i", $id_factura);
        $stmt->execute();
    
        $result = $stmt->get_result();
    
        if ($result->num_rows > 0) {
            return $result->fetch_assoc();
        } else {
            return false;
        }
    }
}


$baseDatos = new Cliente_CRUD("localhost", "root", '', "ejemplo_orm");

// Insertar una nueva factura
$factura = new Factura();
$factura->num_factura = 12345;
$factura->auto_sri = 'ABC123';
$factura->fecha_emision = '2023-01-01';
$factura->guia_emision = 'XYZ789';
$factura->iva = 10.5;
$factura->descuento = 5.0;

$baseDatos->insertarFactura($factura);

// Eliminar una factura
$baseDatos->eliminarFactura(1);

// Obtener una factura por su ID
$facturaObtenida = $baseDatos->obtenerFacturaPorID(2);

// Imprimir los datos de la factura obtenida por ID
echo "Datos de la factura por ID:<br>";
echo "ID: " . $facturaObtenida['id_factura'] . "<br>";
echo "Número de Factura: " . $facturaObtenida['num_factura'] . "<br>";
echo "Auto SRI: " . $facturaObtenida['auto_sri'] . "<br>";
echo "Fecha de Emisión: " . $facturaObtenida['fecha_emision'] . "<br>";
echo "Guía de Emisión: " . $facturaObtenida['guia_emision'] . "<br>";
echo "IVA: $" . $facturaObtenida['iva'] . "<br>";
echo "Descuento: $" . $facturaObtenida['descuento'] . "<br>";

// Obtener todas las facturas
$facturas = $baseDatos->obtenerFacturas();

// Imprimir todas las facturas
echo "<br>Datos de todas las facturas:<br>";
foreach ($facturas as $factura) {
    echo "ID: " . $factura['id_factura'] . "<br>";
    echo "Número de Factura: " . $factura['num_factura'] . "<br>";
    echo "Auto SRI: " . $factura['auto_sri'] . "<br>";
    echo "Fecha de Emisión: " . $factura['fecha_emision'] . "<br>";
    echo "Guía de Emisión: " . $factura['guia_emision'] . "<br>";
    echo "IVA: $" . $factura['iva'] . "<br>";
    echo "Descuento: $" . $factura['descuento'] . "<br>";
}

?>