<?php

header("Content-Type: application/json");

$host = $_ENV['MYSQLHOST'];
$user = $_ENV['MYSQLUSER'];
$password = $_ENV['MYSQLPASSWORD'];
$database = $_ENV['MYSQLDATABASE'];
$port = $_ENV['MYSQLPORT'];

$conn = new mysqli($host,$user,$password,$database,$port);

if ($conn->connect_error) {
    die(json_encode(["error"=>"Error de conexión a la base de datos"]));
}

$method = $_SERVER['REQUEST_METHOD'];

switch($method){

case 'GET':

$result = $conn->query("SELECT * FROM tareas ORDER BY id DESC");

$tareas = array();

while($row = $result->fetch_assoc()){
    $tareas[] = $row;
}

echo json_encode($tareas);

break;


case 'POST':

$data = json_decode(file_get_contents("php://input"), true);

$materia = $data['materia'];
$tarea = $data['tarea'];
$descripcion = $data['descripcion'];
$fecha = $data['fecha'];

$sql = "INSERT INTO tareas(materia,tarea,descripcion,fecha_creacion)
VALUES('$materia','$tarea','$descripcion','$fecha')";

if($conn->query($sql)){
    echo json_encode(["mensaje"=>"Tarea guardada"]);
}else{
    echo json_encode(["error"=>$conn->error]);
}

break;

}

$conn->close();

?>