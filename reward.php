<?php
header('Content-Type: application/json');

if (!isset($_GET['token']) || empty($_GET['token'])) {
    http_response_code(400);
    echo json_encode(['error' => 'Token ausente']);
    exit;
}

$token = $_GET['token'];
$payload = json_encode(['token' => $token]);

$ch = curl_init('https://vivbe.zerod.mobi/zrd/user/reward');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);

$response = curl_exec($ch);
$http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
$error = curl_error($ch);
curl_close($ch);

if ($response === false) {
    http_response_code(500);
    echo json_encode(['error' => 'Erro na requisição', 'detalhes' => $error]);
    exit;
}

http_response_code($http_code);
echo $response;
