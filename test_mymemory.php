<?php

require_once 'vendor/autoload.php';

// Simple test of our new MyMemory API implementation
$url = 'https://api.mymemory.translated.net/get';

$testCases = [
    ['Hello world', 'en', 'es'],
    ['How are you?', 'en', 'fr'],
    ['Good morning', 'en', 'de'],
    ['Thank you', 'en', 'it'],
];

echo "Testing MyMemory API for our Laravel app...\n\n";

foreach ($testCases as $test) {
    list($text, $source, $target) = $test;
    
    echo "Testing: '$text' ($source -> $target)\n";
    
    $params = [
        'q' => $text,
        'langpair' => $source . '|' . $target
    ];
    
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url . '?' . http_build_query($params));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 30);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    
    if ($httpCode == 200) {
        $data = json_decode($response, true);
        if (isset($data['responseData']['translatedText'])) {
            echo "✅ SUCCESS: " . $data['responseData']['translatedText'] . "\n";
        } else {
            echo "❌ ERROR: No translation found\n";
        }
    } else {
        echo "❌ ERROR: HTTP $httpCode\n";
    }
    
    echo "\n";
}

echo "MyMemory API test completed!\n";

?>