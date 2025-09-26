<?php

// Test multiple LibreTranslate instances
$urls = [
    'https://libretranslate.de/',
    'https://translate.terraprint.co/',
    'https://libretranslate.pussthecat.org/',
    'https://lt.vern.cc/',
    'https://translate.mentality.rip/',
    'https://translate.astian.org/'
];

$data = [
    'q' => 'Hello world',
    'source' => 'en',
    'target' => 'es',
    'format' => 'text'
];

echo "Testing LibreTranslate APIs...\n\n";

foreach ($urls as $url) {
    echo "Testing: " . $url . "\n";
    
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url . 'translate');
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Content-Type: application/json'
    ]);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 30);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
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
        }
    }
    
    echo "\n" . str_repeat("-", 50) . "\n";
}

?>