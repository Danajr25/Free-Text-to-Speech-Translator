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
        // Log the incoming request for debugging
        \Log::info('Translation request received', [
            'data' => $request->all(),
            'headers' => $request->headers->all()
        ]);
        
        try {
            // Validate the request
            $request->validate([
                'text' => 'required|string',
                'source_language' => 'required|string',
                'target_language' => 'required|string', // Now in format "en-male" or "es-female"
                'voice_speed' => 'nullable|numeric|between:0.5,2.0',
            ]);
            
            \Log::info('Validation passed');
            
        } catch (\Illuminate\Validation\ValidationException $e) {
            \Log::error('Validation failed', ['errors' => $e->errors()]);
            return response()->json([
                'success' => false,
                'message' => 'Validation failed: ' . implode(', ', collect($e->errors())->flatten()->toArray()),
                'errors' => $e->errors()
            ], 422);
        }
        
        try {
            // Parse the target language format (e.g., "en-male" -> language: "en", gender: "male")
            $targetLangValue = $request->target_language;
            $parts = explode('-', $targetLangValue);
            $targetLanguageCode = $parts[0];
            $voiceGender = isset($parts[1]) ? $parts[1] : 'female';
            
            \Log::info('Parsed language data', [
                'target_lang_value' => $targetLangValue,
                'target_code' => $targetLanguageCode,
                'voice_gender' => $voiceGender
            ]);
            
            // Check if source and target languages are the same
            if ($request->source_language === $targetLanguageCode) {
                // No translation needed, just use the original text
                $translatedText = $request->text;
                \Log::info('Same language, no translation needed');
            } else {
                \Log::info('Different languages, calling translation service');
                
                // Get the translation from the service
                $result = $this->translationService->translate(
                    $request->text,
                    $request->source_language,
                    $targetLanguageCode
                );
                
                \Log::info('Translation service result', ['result' => $result]);
                
                if (!$result['success']) {
                    \Log::error('Translation service failed', ['result' => $result]);
                    return response()->json([
                        'success' => false,
                        'message' => 'Translation service error: ' . ($result['message'] ?? 'Unknown error'),
                        'debug' => $result
                    ], 500);
                }
                
                $translatedText = $result['translated_text'];
            }
            
            \Log::info('About to save to database');
            
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
            
            \Log::info('Successfully saved to database', ['history_id' => $history->id]);
            
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
            \Log::error('Translation controller exception', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Translation error: ' . $e->getMessage(),
                'debug' => [
                    'file' => $e->getFile(),
                    'line' => $e->getLine(),
                    'message' => $e->getMessage()
                ]
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
