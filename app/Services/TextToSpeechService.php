<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class TextToSpeechService
{
    /**
     * Generate audio from text using Google TTS
     */
    public function generateAudio($text, $language = 'en', $voice = 'female')
    {
        try {
            Log::info("TTS request", [
                'text' => $text,
                'language' => $language,
                'voice' => $voice
            ]);

            // Use Google Translate TTS API (free)
            $url = 'https://translate.google.com/translate_tts';
            
            $params = [
                'ie' => 'UTF-8',
                'q' => $text,
                'tl' => $this->getLanguageCode($language),
                'client' => 'tw-ob',
                'textlen' => strlen($text),
                'ttsspeed' => '1'
            ];
            
            $response = Http::timeout(30)
                ->withHeaders([
                    'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36'
                ])
                ->get($url, $params);
            
            Log::info("TTS API Response", [
                'status' => $response->status(),
                'size' => strlen($response->body())
            ]);
            
            if ($response->successful() && strlen($response->body()) > 1000) {
                return $this->saveAudioFile($response->body(), 'mp3');
            }
            
            // Fallback to alternative TTS service
            return $this->generateWithVoiceRSS($text, $language);
            
        } catch (\Exception $e) {
            Log::error("TTS service error", [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return [
                'success' => false,
                'message' => 'Text-to-speech service error: ' . $e->getMessage()
            ];
        }
    }
    
    /**
     * Alternative TTS using VoiceRSS (backup)
     */
    private function generateWithVoiceRSS($text, $language)
    {
        try {
            // VoiceRSS free API (no key needed for basic usage)
            $url = 'http://api.voicerss.org/';
            
            $response = Http::get($url, [
                'key' => 'demo', // Demo key for testing
                'hl' => $this->getLanguageCode($language),
                'src' => $text,
                'r' => '0',
                'c' => 'mp3',
                'f' => '44khz_16bit_stereo'
            ]);
            
            if ($response->successful() && strlen($response->body()) > 100) {
                return $this->saveAudioFile($response->body(), 'mp3');
            }
            
            return [
                'success' => false,
                'message' => 'All TTS services unavailable'
            ];
            
        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => 'TTS service error: ' . $e->getMessage()
            ];
        }
    }
    
    /**
     * Convert language codes
     */
    private function getLanguageCode($language)
    {
        $codes = [
            'en' => 'en',
            'es' => 'es',
            'fr' => 'fr',
            'de' => 'de',
            'it' => 'it',
            'pt' => 'pt',
            'ru' => 'ru',
            'ja' => 'ja',
            'zh' => 'zh-cn',
            'hi' => 'hi',
            'ko' => 'ko',
            'ar' => 'ar'
        ];
        
        return $codes[$language] ?? 'en';
    }

    /**
     * Save audio data to file and return URL info
     */
    private function saveAudioFile($audioData, $extension)
    {
        try {
            // Generate unique filename
            $filename = 'audio_' . time() . '_' . uniqid() . '.' . $extension;
            
            // Save to public storage
            $path = 'audio/' . $filename;
            Storage::disk('public')->put($path, $audioData);
            
            // Return the expected format
            return [
                'success' => true,
                'audio_url' => '/storage/' . $path,
                'filename' => $filename
            ];
            
        } catch (\Exception $e) {
            Log::error("Error saving audio file", [
                'message' => $e->getMessage()
            ]);
            
            return [
                'success' => false,
                'message' => 'Failed to save audio file: ' . $e->getMessage()
            ];
        }
    }
}