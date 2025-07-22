<?php
header('Content-Type: application/json');

// ضع مفتاح Gemini API الخاص بك هنا
$apiKey = 'AIzaSyAneoOLVqwiYL981BC32Q6liVTbxZBYFWE';

// قراءة الـ prompt المُرسل من الطلب
$input = json_decode(file_get_contents('php://input'), true);

if (!isset($input['prompt'])) {
    http_response_code(400);
    echo json_encode(['error' => 'Missing prompt']);
    exit;
}

$prompt = $input['prompt'];

// إعداد البيانات المطلوبة من Google Gemini
$postData = [
    'contents' => [
        ['parts' => [['text' => $prompt]]]
    ]
];

// إرسال الطلب إلى واجهة Gemini API
$ch = curl_init('https://generativelanguage.googleapis.com/v1/models/gemini-pro:generateContent?key=' . $apiKey);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($postData));
curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);

$response = curl_exec($ch);
curl_close($ch);

// إرجاع النتيجة
echo $response;
?>
