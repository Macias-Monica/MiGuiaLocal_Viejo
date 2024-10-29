<?php
require_once 'conexionSQL.php';

// headers to tell that result is JSON
header('Content-Type: application/json; charset=utf-8');

$datos = json_decode(file_get_contents("php://input"), true);
$opc = $datos["tipo"];
$fechaActual = date('Y-m-d');
//var_dump($datos);
switch ($opc) {
    case 'buscar':
        try {
            // Consulta SQL a los Negocios existentes
            $sqlNegocios = "SELECT id, categoria, nombreNegocio, servicioDomicilio, domicilio, telefono, ubicacionMaps, rutaImagenNegocio FROM mglNegocios";
            $stmt = $conn->prepare($sqlNegocios);
            $stmt->execute();
            $negocios = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // Consulta SQL a las categorías existentes
            $sqlCategorias = "SELECT id, categoria,icono FROM mglCategorias";
            $stmt2 = $conn->prepare($sqlCategorias);
            $stmt2->execute();
            $categorias = $stmt2->fetchAll(PDO::FETCH_ASSOC);

            // Enviar la respuesta en formato JSON
            echo json_encode([
                "status" => "OK",
                "negocios" => $negocios,
                "categorias" => $categorias
            ]);
        } catch (PDOException $e) {
            echo json_encode([
                "status" => "ERROR",
                "message" => $e->getMessage()
            ]);
        }
        break;
    case 'registraUsuario': // Insert a la BD para guardar al usuario registrado
        // Extraer datos del JSON
        $info = $datos['info'];
        try {
            // Preparar la consulta SQL
            $sql = "INSERT INTO mglUsuarios (nombre, usuario, contrasena, correo, telefono, fechaRegistro) 
                    VALUES (:nombreCompleto, :usuario, :contrasena, :correo, :telefono, :fechaRegistro)";
            $stmt = $conn->prepare($sql);

            // Vincular los parámetros
            $stmt->bindParam(':nombreCompleto', $info['nombreCompleto']);
            $stmt->bindParam(':usuario', $info['usuario']);
            $stmt->bindParam(':contrasena', $info['contrasena']); // Considera usar password_hash aquí
            $stmt->bindParam(':correo', $info['correo']);
            $stmt->bindParam(':telefono', $info['telefono']);
            $stmt->bindParam(':fechaRegistro', $fechaActual);

            // Ejecutar la consulta
            if ($stmt->execute()) {
                echo json_encode(["status" => "OK", "message" => "Usuario registrado correctamente."]);
            } else {
                echo json_encode(["status" => "error", "message" => "Error al registrar usuario, Intente mas tarde."]);
            }
        } catch (PDOException $e) {
            echo json_encode(["status" => "error", "message" => "Error de conexión: " . $e->getMessage()]);
        }
        break;
    case 'registraNegocio': // Insert a la BD para guardar al usuario registrado
        // Extraer datos del JSON
        $info = $datos['info'];
        try {
            // Preparar la consulta SQL
            $sql = "INSERT INTO mglUsuariosNegocios (nombreDueno, nombreNegocio, categoria, usuario, contrasena,correo,telefono, fechaRegistro) 
                    VALUES (:nombreCompleto,:nombreNegocio, :categoria,:usuario, :contrasena, :correo, :telefono, :fechaRegistro)";
            $stmt = $conn->prepare($sql);
            // Vincular los parámetros
            $stmt->bindParam(':nombreCompleto', $info['nombreCompleto']);
            $stmt->bindParam(':nombreNegocio', $info['nombreNegocio']);
            $stmt->bindParam(':categoria', $info['categoria']);
            $stmt->bindParam(':usuario', $info['usuario']);
            $stmt->bindParam(':contrasena', $info['contrasena']); // Considera usar password_hash aquí
            $stmt->bindParam(':correo', $info['correo']);
            $stmt->bindParam(':telefono', $info['telefono']);
            $stmt->bindParam(':fechaRegistro', $fechaActual);

            // Ejecutar la consulta
            if ($stmt->execute()) {
                echo json_encode(["status" => "OK", "message" => "Negocio registrado correctamente."]);
            } else {
                echo json_encode(["status" => "error", "message" => "Error al registrar su negocio, Intente mas tarde."]);
            }
        } catch (PDOException $e) {
            echo json_encode(["status" => "error", "message" => "Error de conexión: " . $e->getMessage()]);
        }
        break;
};
