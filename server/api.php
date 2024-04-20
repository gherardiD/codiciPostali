<?php
require 'connessione.php';

$metodo = $_SERVER["REQUEST_METHOD"];

if ($metodo === "POST") {
    $data = json_decode(file_get_contents("php://input"), true);
    
    $name = $data["name"];
    $cap = $data["cap"];

    $query = "INSERT INTO cap (paese, cap) VALUES ('$name', '$cap')";
    $result = $connessione->query($query);

    $response = array(
        "message" => "Nuovi dati creati",
        "data" => $data
    );

    header("Content-Type: application/json");

    echo json_encode($response);
} 
elseif ($metodo === "DELETE") {
    $id = $_SERVER['REQUEST_URI'];

    $query = "DELETE FROM cap WHERE id = '$id'";
    $result = $connessione->query($query);

    $response = array(
        "message" => "Dati eliminati",
        "id" => $id
    );

    header("Content-Type: application/json");

    echo json_encode($response);
} else if ($metodo === "GET") {
    $query = "SELECT * FROM cap;";
    $result = $connessione->query($query);
    
    $data = array();
    while($row = $result->fetch_assoc()) {
        $data[] = $row;
    }

    $response = array(
        "message" => "Dati recuperati",
        "data" => $data 
    );

    header("Content-Type: application/json");

    echo json_encode($response);
} elseif ($metodo === "PUT") {
    $id = $_SERVER['REQUEST_URI'];

    $data = json_decode(file_get_contents("php://input"), true);
    

    
    $name = $data["name"];
    $cap = $data["cap"];

    $query = "UPDATE cap SET paese = '$name', cap = '$cap' WHERE id = '$id'";
    $result = $connessione->query($query);

    $response = array(
        "message" => "Dati aggiornati",
        "data" => $data
    );

    header("Content-Type: application/json");

    echo json_encode($response);
} 
else {
    $response = array(
        "error" => "Metodo non supportato"
    );

    header("Content-Type: application/json");

    http_response_code(405);
    echo json_encode($response);
}

?>