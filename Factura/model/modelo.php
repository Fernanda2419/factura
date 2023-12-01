<?php

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

// Insertar una nueva empresa
$baseDatos->insertarEmpresa("La Favorita", 1415765476655, Canonigo);

// Obtener todas las empresas
$empresas = $baseDatos->obtenerDatosEmpresas();

// Imprimir todos los empresa
echo "<br>Datos de todos los empresas:<br>";
foreach ($empresas as $empresa) {
    echo "ID: " . $empresa->id . "<br>";
    echo "Nombre Empresa: " . $empresa->nombre_empresa . "<br>";
    echo "RUC Empresa: $" . $empresa->cruc_empresa . "<br>";
    echo "Direccion: " . $empresa->precio . "<br>";
    echo "<br>";
}

/* ---------------------------------------- */
?>
