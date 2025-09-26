<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class TranslationService
{
    /**
     * Translate text using MyMemory API (free translation service)
     *
     * @param string $text
     * @param string $source
     * @param string $target
     * @return array
     */
    public function translate($text, $source = 'en', $target)
    {
        try {
            Log::info("Translation request", [
                'text' => $text,
                'source' => $source,
                'target' => $target
            ]);

            // Use MyMemory API - completely free and reliable
            $url = 'https://api.mymemory.translated.net/get';
            
            $params = [
                'q' => $text,
                'langpair' => $source . '|' . $target
            ];
            
            $response = Http::timeout(30)
                ->retry(2, 100)
                ->get($url, $params);
            
            Log::info("MyMemory API Response", [
                'status' => $response->status(),
                'body' => $response->body()
            ]);
            
            if ($response->successful()) {
                $data = $response->json();
                
                if (isset($data['responseData']['translatedText'])) {
                    return [
                        'success' => true,
                        'translated_text' => $data['responseData']['translatedText'],
                        'api' => 'MyMemory'
                    ];
                } else {
                    Log::error("No translatedText in MyMemory response", ['response' => $data]);
                    return [
                        'success' => false,
                        'message' => 'Invalid response format from translation service',
                        'debug' => $data
                    ];
                }
            } else {
                Log::error("MyMemory API request failed", [
                    'status' => $response->status(),
                    'body' => $response->body()
                ]);
                
                return [
                    'success' => false,
                    'message' => 'Translation service unavailable. Status: ' . $response->status(),
                    'status_code' => $response->status()
                ];
            }
        } catch (\Exception $e) {
            Log::error("Translation service error", [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return [
                'success' => false,
                'message' => 'Translation service error: ' . $e->getMessage()
            ];
        }
    }
    
    /**
     * Get available languages - Top 10 most commonly used languages
     * 
     * @return array List of available languages
     */
    public function getAvailableLanguages()
    {
        // Top 10 most commonly used languages worldwide
        $languages = [
            'en' => 'English',
            'es' => 'Spanish',
            'fr' => 'French',
            'de' => 'German',
            'it' => 'Italian',
            'pt' => 'Portuguese',
            'ru' => 'Russian',
            'ja' => 'Japanese',
            'zh' => 'Chinese',
            'hi' => 'Hindi'
        ];
        
        return [
            'success' => true,
            'languages' => $languages
        ];
    }
}