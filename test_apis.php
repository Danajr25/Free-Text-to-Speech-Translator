<?php

// Test the main LibreTranslate.com API with proper endpoint
$urls = [
    'https://libretranslate.com/translate',
    'https://translate.argosopentech.com/translate',
    'https://libretranslate.de/translate',
];

$data = [
    'q' => 'Hello world',
    'source' => 'en',
    'target' => 'es',
    'format' => 'text',
    'api_key' => ''  // Let's try without API key first
];

echo "Testing LibreTranslate API endpoints directly...\n\n";

foreach ($urls as $url) {
    echo "Testing: " . $url . "\n";
    
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Content-Type: application/json',
        'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36'
    ]);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 30);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $error = curl_error($ch);
    curl_close($ch);
    
    if ($error) {
        echo "CURL Error: " . $error . "\n";
    } else {
        echo "HTTP Code: " . $httpCode . "\n";
        echo "Response: " . $response . "\n";
        
        // Try to decode JSON response
        $decoded = json_decode($response, true);
        if ($decoded && isset($decoded['translatedText'])) {
            echo "SUCCESS: Translation = " . $decoded['translatedText'] . "\n";
            break; // Found working API, stop testing
        }
    }
    
    echo "\n" . str_repeat("-", 50) . "\n";
}

// Let's try a completely free alternative - MyMemory API
echo "Testing MyMemory API (alternative)...\n";
$myMemoryUrl = "https://api.mymemory.translated.net/get?q=" . urlencode("Hello world") . "&langpair=en|es";

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $myMemoryUrl);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_TIMEOUT, 30);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);

$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
$error = curl_error($ch);
curl_close($ch);

if ($error) {
    echo "CURL Error: " . $error . "\n";
} else {
    echo "HTTP Code: " . $httpCode . "\n";
    echo "Response: " . $response . "\n";
    
    $decoded = json_decode($response, true);
    if ($decoded && isset($decoded['responseData']['translatedText'])) {
        echo "SUCCESS: MyMemory Translation = " . $decoded['responseData']['translatedText'] . "\n";
    }
}

?>