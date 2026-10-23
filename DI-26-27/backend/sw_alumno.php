<?php
require_once 'model/conectionBD.php';
require_once 'model/Alumno.php';

// Indicar que la respuesta es un JSON
header('Content-Type: application/json; charset=UTF-8');

// Obtenemos la conexión a la BD a través del Singleton.
// Siempre devuelve la misma instancia, así que solo se conecta una vez.
$pdo = Conection::getInstance()->getPDO();

// Obtener el contenido del cuerpo de la petición POST
$contenidoJSON = file_get_contents('php://input');

// Decodificar el JSON a un array u objeto de PHP
// Usa 'true' como segundo parámetro para convertirlo en un array asociativo
$request = json_decode($contenidoJSON, true);

$success = true;
$msg = "";
$data = [];

switch($request["action"]){
    case "insert":
        try {
            $nuevoAlumno = new Alumno(
                $request["data"]["dni"],
                $request["data"]["nombre"], 
                $request["data"]["apellido_1"], 
                $request["data"]["localidad"]
            );

            // insertar() devuelve true o false, así que comprobamos el resultado
            if ($nuevoAlumno->insertar($pdo)) {
                $msg = "Alumno insertado correctamente";
                $data = $request["data"];
            } else {
                $success = false;
                $msg = "No se ha podido insertar el alumno (¿DNI repetido?)";
            }

        } catch (PDOException $e) {
            $success = false;
            $msg = "Error al insertar en la base de datos: " . $e->getMessage();
        }
        break;
    
    case "get" :
        $alumnoObtener["dni"]= $request["data"]["dni"];
        try{
            $obtener = new Alumno ($alumnoObtener["dni"], "", "", "");
            $resultadoObtener = $obtener->obtener($pdo);
            
            if ($resultadoObtener) {
                $data = $resultadoObtener;
                $msg = "Alumno Obtenido";
            } else {
                $success = false;
                $msg = "No existe ningún alumno con el DNI introducido";
            }

        } catch (PDOException $e){
            $success = false;
            $msg = "Error conexión base de datos";
        }
        break;

    case "delete":
        $alumnoEliminar["dni"] = $request["data"]["dni"];
        try {
            $eliminar = new Alumno($alumnoEliminar["dni"], "", "", "");
            $resultadoEliminar = $eliminar->eliminar($pdo);

            if ($resultadoEliminar) {
                $msg = "Alumno eliminado correctamente";
                $data = $request["data"];
            } else {
                $success = false;
                $msg = "No existe ningún alumno con el DNI introducido";
            }

        } catch (PDOException $e) {
            $success = false;
            $msg = "Error conexión base de datos";
        }
        break;

    case "update":
        try {
            $alumnoActualizar = new Alumno(
                $request["data"]["dni"],
                $request["data"]["nombre"],
                $request["data"]["apellido_1"],
                $request["data"]["localidad"]
            );
            $resultadoActualizar = $alumnoActualizar->actualizar($pdo);

            if ($resultadoActualizar) {
                $msg = "Alumno actualizado correctamente";
                $data = $request["data"];
            } else {
                $success = false;
                $msg = "No existe ningún alumno con el DNI introducido";
            }

        } catch (PDOException $e) {
            $success = false;
            $msg = "Error al actualizar en la base de datos: " . $e->getMessage();
        }
        break;

    default:
        $success = false;
        $msg = "Acción no soportada";
}

// Devuelve la respuesta en JSON
$arrSalida = [
    "success" => $success,
    "data" => $data,
    "msg" => $msg
];

echo json_encode($arrSalida);

















































































/*
Así es con el method, pero lo estamos haciendo sin él.

<?php
// Indicar que la respuesta es un JSON
header('Content-Type: application/json; charset=UTF-8');

// Obtener el método HTTP (GET o POST) para saber qué botón se ha pulsado
$metodo = $_SERVER['REQUEST_METHOD'];

if ($metodo === 'GET') {
    // Si la petición es GET (botón Obtener)
    $arrSalida["nombre"]="Juan";
    $arrSalida["apellido1"]="Sin Miedo";
    $arrSalida["localidad"]="Arneva";

    // echo json_encode($arrSalida);
    echo json_encode($arrSalida);

} elseif ($metodo === 'POST') {
    // Si la petición es POST (botón Insertar)
    // Obtener el contenido del cuerpo de la petición POST
    $contenidoJSON = file_get_contents('php://input');

    // Decodificar el JSON a un array u objeto de PHP
    // Usa 'true' como segundo parámetro para convertirlo en un array asociativo
    $alumno = json_decode($contenidoJSON, true);

    // echo json_encode($arrSalida);
    echo json_encode($alumno);
}
?>

*/