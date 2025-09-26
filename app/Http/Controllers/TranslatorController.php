<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\TranslationHistory;
use App\Services\TranslationService;
use Illuminate\Http\Request;

class TranslatorController extends Controller
{
    protected $translationService;
    
    /**
     * Create a new controller instance.
     *
     * @param TranslationService $translationService
     * @return void
     */
    public function __construct(TranslationService $translationService)
    {
        $this->translationService = $translationService;
    }
    
    /**
     * Display the translator form.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Try to fetch languages from the API
        $languagesResponse = $this->translationService->getAvailableLanguages();
        
        if ($languagesResponse['success']) {
            $languages = $languagesResponse['languages'];
        } else {
            // Fallback to hardcoded languages if API fails
            $languages = [
                'en' => 'English',
                'es' => 'Spanish',
                'fr' => 'French',
                'de' => 'German',
                'it' => 'Italian',
                'pt' => 'Portuguese',
                'ru' => 'Russian',
                'zh' => 'Chinese',
                'ja' => 'Japanese',
                'ko' => 'Korean',
                'ar' => 'Arabic'
            ];
        }
        
        return view('translator_new', compact('languages'));
    }
    
    /**
     * Translate text and generate speech.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function translate(Request $request)
    {
        // Validate the request
        $request->validate([
            'text' => 'required|string',
            'source_language' => 'required|string',
            'target_language' => 'required|string', // Now in format "en-male" or "es-female"
            'voice_speed' => 'nullable|numeric|between:0.5,2.0',
        ]);
        
        try {
            // Parse the target language format (e.g., "en-male" -> language: "en", gender: "male")
            $targetLangValue = $request->target_language;
            $parts = explode('-', $targetLangValue);
            $targetLanguageCode = $parts[0];
            $voiceGender = isset($parts[1]) ? $parts[1] : 'female';
            
            // Check if source and target languages are the same
            if ($request->source_language === $targetLanguageCode) {
                // No translation needed, just use the original text
                $translatedText = $request->text;
            } else {
                // Get the translation from the service
                $result = $this->translationService->translate(
                    $request->text,
                    $request->source_language,
                    $targetLanguageCode
                );
                
                if (!$result['success']) {
                    return response()->json([
                        'success' => false,
                        'message' => $result['message'],
                        'debug' => $result['debug'] ?? null
                    ], 500);
                }
                
                $translatedText = $result['translated_text'];
            }
            
            // Store in history
            $history = TranslationHistory::create([
                'source_text' => $request->text,
                'translated_text' => $translatedText,
                'source_language' => $request->source_language,
                'target_language' => $targetLanguageCode,
                'voice_settings' => json_encode([
                    'gender' => $voiceGender,
                    'speed' => $request->voice_speed ?? 1.0,
                ]),
            ]);
            
            // Return the translated text with voice settings
            return response()->json([
                'success' => true,
                'translation' => $translatedText,
                'history_id' => $history->id,
                'source_language' => $request->source_language,
                'target_language' => $targetLanguageCode,
                'voice_gender' => $voiceGender,
                'voice_speed' => $request->voice_speed ?? 1.0
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred: ' . $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Show translation history
     *
     * @return \Illuminate\View\View
     */
    public function history()
    {
        $history = TranslationHistory::orderBy('created_at', 'desc')->paginate(10);
        return view('history', compact('history'));
    }
}
