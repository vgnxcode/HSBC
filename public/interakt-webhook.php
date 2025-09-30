<?php

// Replace these with your actual API keys
$interaktApiKey = 'bU9ZQm5iM3ltRnZhOXA0YnEtZm9rMU9qS2dFN0FQaVdEZW94aXlzVllUczo=';
$sellDoApiKey = '75ac75e3697a17b19897af83c07e1c21'; // Your Sell.do API Key

// Log incoming webhook data for debugging (optional)
file_put_contents('webhook_log.txt', print_r($_POST, true), FILE_APPEND);

// Retrieve data from the request
$name = $_POST['name'] ?? null;
$phone = $_POST['phone'] ?? null;
$email = $_POST['email'] ?? null;
$project = $_POST['project'] ?? null;

// Define the mapping for projects to SRD values
$srdValues = [
    "VGN Kensington" => "67120dde735dafc6830b4f2d",
    "VGN Brixton" => "67120e492f31c629bf129fe6",
    "VGN Marble Arch" => "67120e8a58f1e7475dcadabb",
];

// Check if data is valid
if ($name && $phone && $email && isset($srdValues[$project])) {
    // Send the data to Sell.do
    sendToSellDo($name, $phone, $email, $project, $srdValues[$project]);
    http_response_code(200); // Send a 200 response
    echo json_encode(['message' => 'Lead processed successfully']);
} else {
    http_response_code(400); // Invalid data
    echo json_encode(['error' => 'Invalid data']);
}

function sendToSellDo($name, $phone, $email, $project, $srd) {
    global $sellDoApiKey;

    $sellDoEndpoint = 'https://app.sell.do/api/leads/create';

    $data = [
        'sell_do[form][lead][name]' => $name,
        'sell_do[form][lead][email]' => $email,
        'sell_do[form][lead][phone]' => $phone,
        'sell_do[campaign][srd]' => $srd,
        'sell_do[form][content][note]' => 'Lead from WhatsApp',
    ];

    // Send data to Sell.do
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $sellDoEndpoint . '?api_key=' . $sellDoApiKey);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $response = curl_exec($ch);
    curl_close($ch);

    // Log the response from Sell.do for debugging (optional)
    file_put_contents('sell_do_response_log.txt', $response, FILE_APPEND);
}
?>
