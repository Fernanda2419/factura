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

class Cliente {
    public $id_cliente;
    public $ruc_cliente;
    public $nombre_cliente;
    public $apellido_cliente;
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
    
    //insertar cliente
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

//insertar cliente
$baseDatos->insertarCliente("0605753375001", "Erika", "Perez");
$baseDatos->insertarCliente("0605753376001", "Karina", "Perez");
$baseDatos->insertarCliente("0605753374001", "Marlene", "Perez");

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