<?php
header('Content-Type: application/json');
$apiKey = 'AIzaSyDLIC0oKZSf-ZrrEfcmQ75HeiwZ_6n-MTg';
$input = json_decode(file_get_contents('php://input'), true);
if (!isset($input['prompt'])) {
    http_response_code(400);
    echo json_encode(['error' => 'Missing prompt']);
    exit;
}
$prompt = $input['prompt'];
$postData = [
    'contents' => [
        ['parts' => [['text' => $prompt]]]
    ]
];
$ch = curl_init('https://generativelanguage.googleapis.com/v1beta/models/gemini-pro:generateContent?key=' . $apiKey);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($postData));
curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
$response = curl_exec($ch);
curl_close($ch);
echo $response;
?>