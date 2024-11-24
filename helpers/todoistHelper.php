<?php

function callTodoistApi($method, $endpoint, $apiKey, $data = null) {
    $url = "https://api.todoist.com/rest/v2/" . $endpoint;

    $ch = curl_init($url);

    $headers = [
        "Authorization: Bearer $apiKey",
        "Content-Type: application/json"
    ];

    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

    if ($data) {
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    }

    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $response = curl_exec($ch);
    curl_close($ch);

    return json_decode($response, true);
}

function getOrCreateTodoistProject($apiKey, $projectName = "ToDoBook") {
    $projects = callTodoistApi('GET', 'projects', $apiKey);

    // Verificar si el proyecto ya existe
    foreach ($projects as $project) {
        if ($project['name'] === $projectName) {
            return $project['id'];
        }
    }

    // Crear el proyecto si no existe
    $newProject = callTodoistApi('POST', 'projects', $apiKey, [
        'name' => $projectName
    ]);

    return $newProject['id'] ?? null;
}

?>