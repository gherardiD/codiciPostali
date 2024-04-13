<?php

require 'connessione.php';

// Elabora l'header
$metodo = $_SERVER["REQUEST_METHOD"];

// Legge il tipo di contenuto inviato dal client
$ct = $_SERVER["CONTENT_TYPE"];
$type = explode("/", $ct);

// Legge il tipo di contenuto di ritorno richiesto dal client
$retct = $_SERVER["HTTP_ACCEPT"];
$ret = explode("/", $retct);

// Risposta di default
$response = array();

if ($metodo == "GET"){
    $query = "SELECT * FROM cap";
    $result = $connessione->query($query);
    $rows = array();
    while($row = $result->fetch_assoc()) {
        $rows[] = $row;
    }
    $response = $rows;
}
elseif ($metodo == "POST"){
    // Recupera i dati dall'header
    $body = file_get_contents('php://input');
    
    // Converte in array associativo
    if ($type[1] == "json"){
        $data = json_decode($body, true);
    }
    elseif ($type[1] == "xml"){
        $xml = simplexml_load_string($body);
        $json = json_encode($xml);
        $data = json_decode($json, true);
    }
    
    // Elabora i dati o interagisce con il database
    $data["valore"] += 2000;
    
    $response = $data;
}
elseif ($metodo == "PUT"){
    // Recupera l'ID dall'URL
    $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    $uri = explode('/', $uri);
    $id = $uri[count($uri) - 1];

    // Recupera i dati dall'header
    $body = file_get_contents('php://input');
    
    // Converte in array associativo
    if ($type[1] == "json"){
        $data = json_decode($body, true);
    }
    elseif ($type[1] == "xml"){
        $xml = simplexml_load_string($body);
        $json = json_encode($xml);
        $data = json_decode($json, true);
    }
    
    // Elabora i dati o interagisce con il database per l'aggiornamento
    // Supponiamo che $data contenga i nuovi dati per l'aggiornamento
    
    // Aggiornamento dei dati nel database (sostituisci questo con la tua logica)
    $response = array(
        'id' => $id,
        'updated_data' => $data
    );
}
elseif ($metodo == "DELETE"){
    // Recupera l'ID dall'URL
    $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    $uri = explode('/', $uri);
    $id = $uri[count($uri) - 1];

    // Elabora i dati o interagisce con il database per l'eliminazione
    // Supponiamo che tu abbia una funzione per eliminare i dati dal database
    // Esempio:
    // deleteDataFromDatabase($id);
    
    // Codice di risposta
    http_response_code(204); // Nessun contenuto
    exit();
}

// Settaggio dei campi dell'header
header("Content-Type: ".$retct);    

// Restituisce i dati convertiti nel formato richiesto
if ($ret[1] == "json"){
    echo json_encode($response);
}
elseif ($ret[1] == "xml"){
    $xml = new SimpleXMLElement('<root/>');
    array_walk_recursive($response, array ($xml, 'addChild'));    
    echo $xml->asXML();
}
