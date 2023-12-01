<?php

class ProductoDAO {
    private $servername = "localhost";
    private $username = "root";
    private $password = "";
    private $dbname = "generacion_factura";
    private $conn;

    // Constructor: Establecer conexión a la base de datos
    public function __construct() {
        $this->conn = new mysqli($this->servername, $this->username, $this->password, $this->dbname);

        if ($this->conn->connect_error) {
            die("Conexión fallida: " . $this->conn->connect_error);
        }
    }

    // Cerrar conexión a la base de datos
    public function __destruct() {
        $this->conn->close();
    }

    // Método para crear un nuevo producto
    public function crearProducto($descripcion, $cantidad, $precio) {
        $sql = "INSERT INTO productos (descripcion, cantidad, precio) VALUES ('$descripcion', $cantidad, $precio)";

        if ($this->conn->query($sql) === TRUE) {
            return true;
        } else {
            return false;
        }
    }

    // Método para leer información de un producto por su ID
    public function obtenerProducto($id) {
        $sql = "SELECT * FROM productos WHERE id = $id";
        $result = $this->conn->query($sql);

        if ($result->num_rows > 0) {
            return $result->fetch_assoc();
        } else {
            return null;
        }
    }

    // Método para actualizar la información de un producto
    public function actualizarProducto($id, $nombre, $cantidad, $precio) {
        $sql = "UPDATE productos SET nombre='$nombre', cantidad=$cantidad, precio=$precio WHERE id = $id";

        if ($this->conn->query($sql) === TRUE) {
            return true;
        } else {
            return false;
        }
    }

    // Método para eliminar un producto por su ID
    public function eliminarProducto($id) {
        $sql = "DELETE FROM productos WHERE id = $id";

        if ($this->conn->query($sql) === TRUE) {
            return true;
        } else {
            return false;
        }
    }
}

class EmpresaDAO {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function crearEmpresa($ruc, $nombreComercial, $razonSocial, $direccion) {
        $stmt = $this->pdo->prepare("INSERT INTO empresa (ruc, nombre_comercial, razon_social, direccion) VALUES (?, ?, ?, ?)");
        $stmt->execute([$ruc, $nombreComercial, $razonSocial, $direccion]);
    }

    public function obtenerEmpresas() {
        $stmt = $this->pdo->query("SELECT * FROM empresa");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function actualizarEmpresa($id, $ruc, $nombreComercial, $razonSocial, $direccion) {
        $stmt = $this->pdo->prepare("UPDATE empresa SET ruc = ?, nombre_comercial = ?, razon_social = ?, direccion = ? WHERE id = ?");
        $stmt->execute([$ruc, $nombreComercial, $razonSocial, $direccion, $id]);
    }

    public function eliminarEmpresa($id) {
        $stmt = $this->pdo->prepare("DELETE FROM empresa WHERE id = ?");
        $stmt->execute([$id]);
    }
}


class FormaPagoDAO {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function crearFormaPago($nombre) {
        $stmt = $this->pdo->prepare("INSERT INTO forma_pago (nombre) VALUES (?)");
        $stmt->execute([$nombre]);
    }

    public function obtenerFormasPago() {
        $stmt = $this->pdo->query("SELECT * FROM forma_pago");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function actualizarEmpresa($id, $ruc, $nombreComercial, $razonSocial, $direccion) {
        $stmt = $this->pdo->prepare("UPDATE empresa SET ruc = ?, nombre_comercial = ?, razon_social = ?, direccion = ? WHERE id = ?");
        $stmt->execute([$ruc, $nombreComercial, $razonSocial, $direccion, $id]);
    }

    public function eliminarEmpresa($id) {
        $stmt = $this->pdo->prepare("DELETE FROM empresa WHERE id = ?");
        $stmt->execute([$id]);
    }
}
?>
