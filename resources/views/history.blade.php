<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Translation History - SpeechTranslator</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-color: #667eea;
            --primary-dark: #5a6fd8;
            --secondary-color: #764ba2;
            --bg-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            --text-dark: #2d3748;
            --text-light: #718096;
            --white: #ffffff;
            --light-gray: #f7fafc;
            --border-color: #e2e8f0;
            --shadow-sm: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
            --shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
            --border-radius: 12px;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: var(--bg-gradient);
            min-height: 100vh;
            color: var(--text-dark);
        }

        .navbar {
            background: rgba(255, 255, 255, 0.95) !important;
            backdrop-filter: blur(10px);
            border-bottom: 1px solid var(--border-color);
            box-shadow: var(--shadow-sm);
            padding: 1rem 0;
        }

        .navbar-brand {
            color: var(--primary-color) !important;
            font-weight: 700;
            font-size: 1.5rem;
            display: flex;
            align-items: center;
        }

        .navbar-brand i {
            margin-right: 0.5rem;
            font-size: 1.8rem;
        }

        .nav-link {
            color: var(--text-dark) !important;
            font-weight: 500;
            padding: 0.5rem 1rem !important;
            border-radius: 8px;
            transition: all 0.2s ease;
        }

        .nav-link:hover {
            color: var(--primary-color) !important;
        }

        .nav-link.active {
            color: var(--primary-color) !important;
            background: rgba(102, 126, 234, 0.1);
        }

        .translator-card {
            background: var(--white);
            border-radius: var(--border-radius);
            box-shadow: var(--shadow-lg);
            padding: 2.5rem;
            margin-bottom: 2rem;
            max-width: 900px;
            margin-left: auto;
            margin-right: auto;
        }

        .history-row {
            transition: background-color 0.2s ease;
        }

        .history-row:hover {
            background-color: var(--light-gray);
        }

        .badge {
            font-size: 0.75rem;
            padding: 0.4rem 0.8rem;
            border-radius: 20px;
        }

        .btn-primary {
            background: var(--bg-gradient);
            border: none;
            border-radius: 8px;
            font-weight: 500;
            padding: 0.5rem 1rem;
            transition: all 0.2s ease;
        }

        .btn-primary:hover {
            background: var(--bg-gradient);
            opacity: 0.9;
        }

        .table th {
            border: none;
            padding: 1rem 0.75rem;
            font-size: 0.875rem;
        }

        .table td {
            border: none;
            padding: 0.75rem;
            vertical-align: middle;
        }

        .table .border-bottom {
            border-bottom: 2px solid var(--border-color) !important;
        }

        /* Pagination Styling */
        .pagination {
            justify-content: center;
            margin-top: 1.5rem;
        }

        .pagination .page-link {
            color: var(--primary-color);
            border: 1px solid var(--border-color);
            border-radius: 8px;
            margin: 0 0.25rem;
            padding: 0.5rem 0.75rem;
            font-weight: 500;
            text-decoration: none;
            background: white;
            transition: all 0.2s ease;
        }

        .pagination .page-link:hover {
            background: var(--primary-color);
            color: white;
            border-color: var(--primary-color);
        }

        .pagination .page-item.active .page-link {
            background: var(--primary-color);
            border-color: var(--primary-color);
            color: white;
        }

        .pagination .page-item.disabled .page-link {
            color: var(--text-light);
            background: var(--light-gray);
            border-color: var(--border-color);
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg">
        <div class="container">
            <a class="navbar-brand" href="{{ route('translator.index') }}">
                <i class="fas fa-language"></i>
                SpeechTranslator
            </a>
            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('translator.index') }}">Translator</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="{{ route('translator.history') }}">History</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-12 col-lg-10">
                <div class="text-center mb-5">
                    <h1 class="display-5 fw-bold text-white mb-3">
                        Translation History
                    </h1>
                    <p class="text-white-50">
                        View your previous translations
                    </p>
                </div>

                <div class="translator-card">
                    @if(count($history) > 0)
                        <div class="table-responsive">
                            <table class="table table-borderless">
                                <thead>
                                    <tr class="border-bottom">
                                        <th class="text-muted fw-semibold">Date</th>
                                        <th class="text-muted fw-semibold">Original Text</th>
                                        <th class="text-muted fw-semibold">Translation</th>
                                        <th class="text-muted fw-semibold">Languages</th>
                                        <th class="text-muted fw-semibold text-center">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($history as $item)
                                        <tr class="history-row">
                                            <td class="py-3">
                                                <small class="text-muted">{{ $item->created_at->format('M d, Y') }}</small><br>
                                                <small class="text-muted">{{ $item->created_at->format('H:i') }}</small>
                                            </td>
                                            <td class="py-3">
                                                <span class="text-dark">{{ Str::limit($item->source_text, 40) }}</span>
                                            </td>
                                            <td class="py-3">
                                                <span class="text-dark">{{ Str::limit($item->translated_text, 40) }}</span>
                                            </td>
                                            <td class="py-3">
                                                <span class="badge bg-primary">{{ strtoupper($item->source_language) }}</span>
                                                <i class="fas fa-arrow-right mx-2 text-muted"></i>
                                                <span class="badge bg-secondary">{{ strtoupper($item->target_language) }}</span>
                                            </td>
                                            <td class="py-3 text-center">
                                                @if($item->audio_path)
                                                    <button class="btn btn-sm btn-primary play-audio me-2" data-audio="{{ $item->audio_path }}">
                                                        <i class="fas fa-play"></i>
                                                    </button>
                                                @else
                                                    <span class="text-muted small">No audio</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        
                        @if($history->hasPages())
                            <div class="mt-4">
                                <nav aria-label="Translation History Pagination">
                                    <ul class="pagination">
                                        {{-- Previous Page Link --}}
                                        @if ($history->onFirstPage())
                                            <li class="page-item disabled"><span class="page-link">← Previous</span></li>
                                        @else
                                            <li class="page-item"><a class="page-link" href="{{ $history->previousPageUrl() }}">← Previous</a></li>
                                        @endif

                                        {{-- Pagination Elements --}}
                                        @foreach ($history->getUrlRange(1, $history->lastPage()) as $page => $url)
                                            @if ($page == $history->currentPage())
                                                <li class="page-item active"><span class="page-link">{{ $page }}</span></li>
                                            @else
                                                <li class="page-item"><a class="page-link" href="{{ $url }}">{{ $page }}</a></li>
                                            @endif
                                        @endforeach

                                        {{-- Next Page Link --}}
                                        @if ($history->hasMorePages())
                                            <li class="page-item"><a class="page-link" href="{{ $history->nextPageUrl() }}">Next →</a></li>
                                        @else
                                            <li class="page-item disabled"><span class="page-link">Next →</span></li>
                                        @endif
                                    </ul>
                                </nav>
                                
                                <p class="text-center text-muted small mt-3">
                                    Showing {{ $history->firstItem() }} to {{ $history->lastItem() }} of {{ $history->total() }} results
                                </p>
                            </div>
                        @endif
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-history text-muted mb-3" style="font-size: 3rem; opacity: 0.3;"></i>
                            <h5 class="text-muted">No translation history yet</h5>
                            <p class="text-muted">Start translating to see your history here</p>
                            <a href="{{ route('translator.index') }}" class="btn btn-primary">
                                <i class="fas fa-language me-2"></i>Start Translating
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <!-- Audio Player Modal -->
    <div class="modal fade" id="audioPlayerModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="fas fa-volume-up me-2"></i>Audio Playback
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body text-center">
                    <audio id="historyAudioPlayer" controls class="w-100"></audio>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.play-audio').click(function() {
                const audioUrl = $(this).data('audio');
                if(audioUrl) {
                    $('#historyAudioPlayer').attr('src', audioUrl);
                    $('#audioPlayerModal').modal('show');
                    setTimeout(() => {
                        $('#historyAudioPlayer')[0].play();
                    }, 300);
                }
            });
            
            $('#audioPlayerModal').on('hidden.bs.modal', function () {
                const audioPlayer = $('#historyAudioPlayer')[0];
                audioPlayer.pause();
                audioPlayer.currentTime = 0;
            });
        });
    </script>
</body>
</html>