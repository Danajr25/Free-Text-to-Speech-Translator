<?php

// Simple test for LibreTranslate API
$testText = "Hello world";
$sourceLang = "en";
$targetLang = "es";

$urls = [
    'https://libretranslate.de/',
    'https://translate.argosopentech.com/',
    'https://libretranslate.com/'
];

echo "Testing LibreTranslate APIs...\n";

foreach ($urls as $url) {
    echo "\nTesting: $url\n";
    
    $data = [
        'q' => $testText,
        'source' => $sourceLang,
        'target' => $targetLang,
        'format' => 'text'
    ];
    
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url . 'translate');
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Content-Type: application/json'
    ]);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 30);
    
    $result = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $error = curl_error($ch);
    curl_close($ch);
    
    if ($error) {
        echo "CURL Error: $error\n";
    } else {
        echo "HTTP Code: $httpCode\n";
        echo "Response: $result\n";
        
        if ($httpCode == 200) {
            $response = json_decode($result, true);
            if (isset($response['translatedText'])) {
                echo "SUCCESS: Translation = " . $response['translatedText'] . "\n";
            } else {
                echo "ERROR: No translatedText in response\n";
            }
        }
    }
}

?>