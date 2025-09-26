<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SpeechTranslator - Free Text-to-Speech Translation</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        :root {
            --primary-color: #6366f1;
            --primary-hover: #5856eb;
            --secondary-color: #f8fafc;
            --text-color: #1e293b;
            --text-muted: #64748b;
            --border-color: #e2e8f0;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            margin: 0;
            color: var(--text-color);
        }

        .main-container {
            background: white;
            min-height: 100vh;
            margin: 0;
        }

        .header {
            padding: 1.5rem 0;
            background: white;
            border-bottom: 1px solid var(--border-color);
        }

        .logo {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--primary-color);
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .nav-links {
            display: flex;
            gap: 2rem;
            align-items: center;
            margin: 0;
            list-style: none;
        }

        .nav-links a {
            color: var(--text-muted);
            text-decoration: none;
            font-weight: 500;
            transition: color 0.2s;
            padding: 0.5rem 1rem;
            border-radius: 8px;
        }

        .nav-links a:hover {
            color: var(--primary-color);
            background: rgba(102, 126, 234, 0.1);
        }

        .hero-section {
            padding: 4rem 0;
            text-align: center;
            background: var(--secondary-color);
        }

        .hero-title {
            font-size: 3rem;
            font-weight: 700;
            margin-bottom: 1rem;
            color: var(--text-color);
            line-height: 1.2;
        }

        .hero-subtitle {
            font-size: 1.25rem;
            color: var(--text-muted);
            margin-bottom: 2rem;
            max-width: 600px;
            margin-left: auto;
            margin-right: auto;
            line-height: 1.6;
        }

        .feature-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            background: #fef3c7;
            color: #d97706;
            padding: 0.5rem 1rem;
            border-radius: 2rem;
            font-size: 0.875rem;
            font-weight: 500;
            margin-bottom: 2rem;
        }

        .translator-section {
            padding: 3rem 0;
            background: white;
        }

        .translator-card {
            background: white;
            border: 1px solid var(--border-color);
            border-radius: 1rem;
            padding: 2.5rem;
            box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1);
            max-width: 900px;
            margin: 0 auto;
        }

        .form-label {
            font-weight: 600;
            color: var(--text-color);
            margin-bottom: 0.5rem;
        }

        .form-control, .form-select {
            border: 2px solid var(--border-color);
            border-radius: 0.75rem;
            padding: 0.875rem 1rem;
            font-size: 1rem;
            transition: all 0.2s;
        }

        .form-control:focus, .form-select:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.2rem rgb(99 102 241 / 0.1);
        }

        .text-input {
            min-height: 400px;
            resize: vertical;
            font-size: 1.1rem;
            line-height: 1.6;
        }

        .btn-primary {
            background: var(--primary-color);
            border: none;
            border-radius: 0.75rem;
            padding: 1rem 2rem;
            font-size: 1rem;
            font-weight: 600;
            transition: all 0.2s;
        }

        .btn-primary:hover {
            background: var(--primary-hover);
            transform: translateY(-1px);
        }

        .btn-danger {
            background: #ef4444;
            border: none;
            border-radius: 0.5rem;
            padding: 0.75rem 1.5rem;
            font-weight: 600;
        }

        .btn-danger:hover {
            background: #dc2626;
        }

        .translation-result {
            background: var(--white);
            border: 1px solid var(--border-color);
            border-radius: var(--border-radius);
            box-shadow: var(--shadow-md);
            padding: 2rem;
            margin-top: 2rem;
        }

        .translation-result h5 {
            color: var(--text-dark);
            font-weight: 600;
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .translation-result h5 i {
            color: var(--primary-color);
        }

        .translation-text {
            font-size: 1.1rem;
            line-height: 1.6;
            color: var(--text-dark);
            background: var(--light-gray);
            padding: 1.5rem;
            border-radius: 8px;
            margin-bottom: 1.5rem;
            border-left: 4px solid var(--primary-color);
        }

        .audio-section h6 {
            color: var(--text-dark);
            font-weight: 600;
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 1rem;
        }

        .audio-section h6 i {
            color: var(--primary-color);
        }

        .audio-controls {
            display: flex !important;
            gap: 1rem;
            align-items: center;
            flex-wrap: wrap;
        }

        .audio-controls button {
            display: inline-flex !important;
            visibility: visible !important;
        }

        .btn-success {
            background: var(--bg-gradient) !important;
            border: none !important;
            border-radius: 8px;
            font-weight: 500;
            padding: 0.6rem 1.2rem;
            transition: all 0.2s ease;
            color: white !important;
            display: inline-flex !important;
            align-items: center;
            text-decoration: none;
        }

        #playPauseBtn {
            background: var(--bg-gradient) !important;
            border: none !important;
            color: white !important;
            display: inline-flex !important;
            visibility: visible !important;
            opacity: 1 !important;
            position: relative !important;
            z-index: 1000 !important;
        }

        .btn-success:hover {
            background: var(--bg-gradient) !important;
            opacity: 0.9;
            color: white !important;
        }

        .btn-success:focus {
            background: var(--bg-gradient) !important;
            color: white !important;
            box-shadow: none;
        }

        .btn-outline-primary {
            color: var(--primary-color);
            border: 1px solid var(--primary-color);
            border-radius: 8px;
            font-weight: 500;
            padding: 0.6rem 1.2rem;
            background: transparent;
            transition: all 0.2s ease;
        }

        .btn-outline-primary:hover {
            background: var(--primary-color);
            border-color: var(--primary-color);
            color: white;
        }

        .status-text {
            color: var(--text-muted);
            font-weight: 500;
        }

        .loader {
            display: none;
            text-align: center;
            padding: 2rem;
        }

        .spinner {
            border: 3px solid var(--border-color);
            border-top: 3px solid var(--primary-color);
            border-radius: 50%;
            width: 40px;
            height: 40px;
            animation: spin 1s linear infinite;
            margin: 0 auto;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        .speed-control {
            margin-top: 1rem;
        }

        .form-range {
            accent-color: var(--primary-color);
        }

        @media (max-width: 768px) {
            .hero-title {
                font-size: 2rem;
            }
            
            .translator-card {
                margin: 1rem;
                padding: 1.5rem;
            }
            
            .audio-controls {
                justify-content: center;
            }
        }
    </style>
</head>
<body>
    <div class="main-container">
        <!-- Header -->
        <div class="header">
            <div class="container">
                <div class="d-flex justify-content-between align-items-center">
                    <a href="/" class="logo">
                        <i class="fas fa-language"></i>
                        SpeechTranslator
                    </a>
                    <ul class="nav-links">
                        <li><a href="#translator">Translator</a></li>
                        <li><a href="{{ route('translator.history') }}">History</a></li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Hero Section -->
        <div class="hero-section">
            <div class="container">
                <div class="feature-badge">
                    <i class="fas fa-star"></i>
                    Free translation with over 10 languages
                </div>
                <h1 class="hero-title">
                    Free Text-to-Speech<br>
                    <span style="color: var(--primary-color);">Translation</span>
                </h1>
                <p class="hero-subtitle">
                    SpeechTranslator is a free online text-to-speech translation tool that turns your text into natural-sounding speech. Simply input your text, choose a language, and listen to it directly.
                </p>
            </div>
        </div>

        <!-- Translator Section -->
        <div class="translator-section" id="translator">
            <div class="container">
                <div class="translator-card">
                    <form id="translationForm" action="{{ route('translator.translate') }}" method="POST">
                        @csrf
                        
                        <!-- Text Input -->
                        <div class="mb-5">
                            <label for="text" class="form-label">Enter your text here</label>
                            <textarea 
                                class="form-control text-input" 
                                id="text" 
                                name="text" 
                                placeholder="Type or paste your text here..."
                                required
                            ></textarea>
                        </div>

                        <!-- Language Selection -->
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="source_language" class="form-label">From Language</label>
                                    <select class="form-select" id="source_language" name="source_language" required>
                                        <option value="en" selected>English</option>
                                        @php
                                            $languages = [
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
                                        @endphp
                                        @foreach($languages as $code => $name)
                                            <option value="{{ $code }}">{{ $name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="target_language" class="form-label">To Language</label>
                                    <select class="form-select" id="target_language" name="target_language" required>
                                        <option value="" selected disabled>Select language</option>
                                        <option value="en-female">English (Female)</option>
                                        <option value="en-male">English (Male)</option>
                                        <option value="es-female">Spanish (Female)</option>
                                        <option value="es-male">Spanish (Male)</option>
                                        <option value="fr-female">French (Female)</option>
                                        <option value="de-female">German (Female)</option>
                                        <option value="it-female">Italian (Female)</option>
                                        <option value="pt-female">Portuguese (Female)</option>
                                        <option value="ru-female">Russian (Female)</option>
                                        <option value="ja-female">Japanese (Female)</option>
                                        <option value="zh-female">Chinese (Female)</option>
                                        <option value="hi-female">Hindi (Female)</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- Voice Speed Control -->
                        <div class="speed-control mb-4">
                            <label for="voice_speed" class="form-label">Voice Speed: <span id="speedValue">1.0</span></label>
                            <input type="range" class="form-range" id="voice_speed" name="voice_speed" min="0.5" max="2" step="0.1" value="1.0">
                        </div>

                        <!-- Submit Button -->
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-magic"></i> Generate Translation
                            </button>
                        </div>
                    </form>

                    <!-- Loading -->
                    <div id="loader" class="loader">
                        <div class="spinner"></div>
                        <p class="mt-3 status-text">Translating your text...</p>
                    </div>

                    <!-- Translation Result -->
                    <div id="translationResult" class="translation-result d-none">
                        <h5><i class="fas fa-language"></i> Translation</h5>
                        <div class="translation-text" id="translatedText"></div>
                        
                        <div class="audio-section">
                            <h6><i class="fas fa-volume-up"></i> Audio Playback</h6>
                            <div class="audio-controls">
                                <button id="playPauseBtn" class="btn" style="background: #667eea !important; color: white !important; border: none !important; padding: 10px 20px !important; border-radius: 8px !important; display: inline-block !important; margin-right: 10px !important;">
                                    <i class="fas fa-play me-2"></i>Play Audio
                                </button>
                                <button id="downloadBtn" class="btn btn-outline-primary" style="display: none;">
                                    <i class="fas fa-download me-2"></i>Download
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            // Check if speech synthesis is supported
            const isSpeechSynthesisSupported = 'speechSynthesis' in window;
            
            // Translation state
            let currentUtterance = null;
            let currentTranslation = '';
            let currentLanguage = '';
            let currentVoiceSettings = {};
            
            if (!isSpeechSynthesisSupported) {
                alert("Your browser doesn't support speech synthesis. Please try a different browser like Chrome, Edge, or Safari.");
            }

            // Update speed value display
            $('#voice_speed').on('input', function() {
                $('#speedValue').text($(this).val());
            });

            // Handle form submission
            $('#translationForm').submit(function(e) {
                e.preventDefault();
                const formData = $(this).serialize();
                
                // Show loader
                $('#loader').show();
                $('#translationResult').addClass('d-none');
                $('#playPauseBtn').prop('disabled', false).html('<i class="fas fa-play me-2"></i>Play Audio');
                $('#downloadBtn').hide();
                
                // Stop any current speech
                if (currentUtterance) {
                    speechSynthesis.cancel();
                    currentUtterance = null;
                }
                
                $.ajax({
                    url: $(this).attr('action'),
                    type: 'POST',
                    data: formData,
                    dataType: 'json',
                    success: function(response) {
                        if(response.success) {
                            $('#translatedText').text(response.translation);
                            
                            // Parse the target language format (e.g., "en-male" -> language: "en", gender: "male")
                            const targetLangValue = $('#target_language').val();
                            const [targetLang, gender] = targetLangValue.split('-');
                            
                            // Store current translation data
                            currentTranslation = response.translation;
                            currentLanguage = targetLang;
                            currentVoiceSettings = {
                                gender: gender,
                                speed: parseFloat($('#voice_speed').val())
                            };
                            
                            console.log("Translation data:", {
                                language: currentLanguage,
                                gender: gender,
                                speed: currentVoiceSettings.speed
                            });
                            
                            // Show the result container and download button
                            $('#translationResult').removeClass('d-none');
                            $('#downloadBtn').show();
                        } else {
                            alert('Translation failed: ' + (response.message || 'Unknown error'));
                            console.error('Translation error:', response);
                        }
                    },
                    error: function(xhr) {
                        const response = xhr.responseJSON || {};
                        alert('Translation failed: ' + (response.message || 'Server error'));
                        console.error('AJAX error:', xhr);
                    },
                    complete: function() {
                        $('#loader').hide();
                    }
                });
            });

            // Play/Pause button click handler
            $('#playPauseBtn').click(function() {
                console.log('Button clicked. Speech state:', {
                    speaking: speechSynthesis.speaking,
                    paused: speechSynthesis.paused,
                    pending: speechSynthesis.pending
                });
                
                if (currentTranslation && currentLanguage) {
                    if (speechSynthesis.speaking && !speechSynthesis.paused) {
                        // Currently playing, so pause
                        console.log('Pausing speech');
                        speechSynthesis.pause();
                        $('#playPauseBtn').html('<i class="fas fa-play me-2"></i>Resume Audio');
                    } else if (speechSynthesis.paused && speechSynthesis.speaking) {
                        // Currently paused, so resume
                        console.log('Resuming speech');
                        speechSynthesis.resume();
                        $('#playPauseBtn').html('<i class="fas fa-pause me-2"></i>Pause Audio');
                    } else {
                        // Not playing or finished, start new playback
                        console.log('Starting new speech');
                        playTranslation(currentTranslation, currentLanguage, currentVoiceSettings);
                    }
                }
            });

            // Download button click handler
            $('#downloadBtn').click(function() {
                if (currentTranslation) {
                    // Create a text file with the translation
                    const blob = new Blob([currentTranslation], { type: 'text/plain' });
                    const url = window.URL.createObjectURL(blob);
                    const a = document.createElement('a');
                    a.href = url;
                    a.download = 'translation.txt';
                    document.body.appendChild(a);
                    a.click();
                    document.body.removeChild(a);
                    window.URL.revokeObjectURL(url);
                }
            });

            function playTranslation(text, language, voiceSettings) {
                if (!isSpeechSynthesisSupported) {
                    alert("Your browser doesn't support speech synthesis.");
                    return;
                }

                // Cancel any ongoing speech
                speechSynthesis.cancel();
                
                // Create new utterance
                currentUtterance = new SpeechSynthesisUtterance(text);
                currentUtterance.rate = voiceSettings.speed || 1.0;
                currentUtterance.pitch = 1.0;
                
                // Try to find a voice that matches the language and gender preference
                const voices = speechSynthesis.getVoices();
                console.log("Available voices:", voices.map(v => `${v.name} (${v.lang})`));
                
                // Find voices for the target language only
                const targetVoices = voices.filter(voice => 
                    voice.lang.startsWith(language) || voice.lang.startsWith(getLanguageCode(language))
                );
                
                console.log("Target voices for", language, ":", targetVoices.map(v => v.name));
                
                if (targetVoices.length > 0) {
                    let selectedVoice = targetVoices[0]; // Default to first match
                    
                    if (voiceSettings.gender && targetVoices.length > 1) {
                        console.log("Looking for gender:", voiceSettings.gender, "in available voices");
                        
                        // Try to find gender-specific voice in the target language
                        const genderMatch = targetVoices.find(voice => {
                            const voiceName = voice.name.toLowerCase();
                            console.log("Checking voice:", voiceName);
                            
                            if (voiceSettings.gender === 'male') {
                                // Look for male voice indicators
                                return voiceName.includes('male') || 
                                       voiceName.includes('man') || 
                                       voiceName.includes('david') || 
                                       voiceName.includes('mark') || 
                                       voiceName.includes('alex') || 
                                       voiceName.includes('tom') || 
                                       voiceName.includes('james') || 
                                       voiceName.includes('daniel') ||
                                       voiceName.includes('fred') ||
                                       voiceName.includes('george') ||
                                       voiceName.includes('ryan') ||
                                       voiceName.includes('hombre') || // Spanish
                                       voiceName.includes('homme') ||  // French
                                       voiceName.includes('uomo');     // Italian
                            } else if (voiceSettings.gender === 'female') {
                                // Look for female voice indicators  
                                return voiceName.includes('female') || 
                                       voiceName.includes('woman') || 
                                       voiceName.includes('zira') || 
                                       voiceName.includes('anna') || 
                                       voiceName.includes('susan') || 
                                       voiceName.includes('samantha') || 
                                       voiceName.includes('emma') || 
                                       voiceName.includes('karen') ||
                                       voiceName.includes('siri') ||
                                       voiceName.includes('hazel') ||
                                       voiceName.includes('maria') ||  // Spanish
                                       voiceName.includes('marie') ||  // French
                                       voiceName.includes('elena') ||  // Various languages
                                       voiceName.includes('sofia');    // Various languages
                            }
                            return false;
                        });
                        
                        if (genderMatch) {
                            selectedVoice = genderMatch;
                            console.log("Selected voice based on gender:", selectedVoice.name);
                        } else {
                            // If no specific gender match, try to pick a better default
                            // For male preference, avoid obviously female names
                            if (voiceSettings.gender === 'male') {
                                const nonFemaleVoice = targetVoices.find(voice => {
                                    const voiceName = voice.name.toLowerCase();
                                    return !voiceName.includes('female') && 
                                           !voiceName.includes('woman') && 
                                           !voiceName.includes('zira') && 
                                           !voiceName.includes('anna') && 
                                           !voiceName.includes('maria') &&
                                           !voiceName.includes('marie') &&
                                           !voiceName.includes('elena') &&
                                           !voiceName.includes('sofia');
                                });
                                if (nonFemaleVoice) selectedVoice = nonFemaleVoice;
                            }
                            console.log("No exact gender match, using:", selectedVoice.name);
                        }
                    }
                    
                    currentUtterance.voice = selectedVoice;
                    console.log("Final selected voice:", selectedVoice.name, "for language:", selectedVoice.lang);
                } else {
                    console.log("No voices available for target language:", language);
                }

                // Set up event listeners
                currentUtterance.onstart = function() {
                    $('#playPauseBtn').prop('disabled', false).html('<i class="fas fa-pause me-2"></i>Pause Audio');
                };

                currentUtterance.onend = function() {
                    $('#playPauseBtn').prop('disabled', false).html('<i class="fas fa-play me-2"></i>Play Audio');
                    currentUtterance = null;
                };

                currentUtterance.onerror = function(event) {
                    $('#playPauseBtn').prop('disabled', false).html('<i class="fas fa-play me-2"></i>Play Audio');
                    currentUtterance = null;
                };

                currentUtterance.onpause = function() {
                    $('#playPauseBtn').html('<i class="fas fa-play me-2"></i>Resume Audio');
                };

                currentUtterance.onresume = function() {
                    $('#playPauseBtn').html('<i class="fas fa-pause me-2"></i>Pause Audio');
                };

                // Play the speech
                speechSynthesis.speak(currentUtterance);
            }

            // Language code mapping helper
            function getLanguageCode(lang) {
                const langMap = {
                    'en': 'en',
                    'es': 'es',
                    'fr': 'fr',
                    'de': 'de',
                    'it': 'it',
                    'pt': 'pt',
                    'ru': 'ru',
                    'ja': 'ja',
                    'zh': 'zh',
                    'hi': 'hi'
                };
                return langMap[lang] || lang;
            }

            // Initialize voices when they're available
            function initVoices() {
                if (speechSynthesis.onvoiceschanged !== undefined) {
                    speechSynthesis.onvoiceschanged = function() {
                        console.log("Voices loaded:", speechSynthesis.getVoices().length);
                    };
                }
            }

            initVoices();
        });
    </script>
</body>
</html>