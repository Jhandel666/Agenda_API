<?php

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

$result = $conn->query("SELECT * FROM tareas");

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

$sql = "INSERT INTO tareas(materia,tarea,descripcion)
VALUES('$materia','$tarea','$descripcion')";

if($conn->query($sql)){
    echo json_encode(["mensaje"=>"Tarea guardada correctamente"]);
}else{
    echo json_encode(["error"=>"No se pudo guardar"]);
}

break;

}

$conn->close();

?>
