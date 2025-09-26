# Text-to-Speech Translation Web Application

A Laravel-based web application that allows users to translate English text into multiple languages and generate speech from the translated text.

## Features

- Text translation from English to multiple languages
- Text-to-speech generation for translated content
- Customizable voice settings (gender, speed)
- Translation history tracking
- Modern, responsive interface with Bootstrap
- Error handling for API failures

## Technologies Used

- **Laravel**: PHP web framework
- **MySQL**: Database for storing translation history
- **LibreTranslate API**: Free and open-source translation service
- **Web Speech API**: Browser-based text-to-speech conversion
- **Bootstrap 5**: Frontend styling and layout
- **jQuery**: JavaScript library for AJAX requests and DOM manipulation

## Prerequisites

- PHP 8.0+
- Composer
- MySQL 5.7+
- Web browser with Web Speech API support (Chrome, Edge, Firefox, Safari)

## Installation

1. Clone the repository
   ```
   git clone https://github.com/yourusername/speech-translator.git
   cd speech-translator
   ```

2. Install dependencies
   ```
   composer install
   ```

3. Create and configure environment file
   ```
   cp .env.example .env
   php artisan key:generate
   ```

4. Configure database connection in `.env`
   ```
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=speech_translator
   DB_USERNAME=root
   DB_PASSWORD=
   ```

5. Run migrations
   ```
   php artisan migrate
   ```

6. Start the development server
   ```
   php artisan serve
   ```

7. Access the application at `http://localhost:8000`

## Usage

1. Enter English text in the input field
2. Select a target language
3. Customize voice settings (optional)
4. Click "Translate & Generate Speech"
5. View the translation and listen to the audio
6. Browse translation history in the History page

## Limitations

- Web Speech API requires an internet connection
- Web Speech API may not support all languages with equal quality
- The free LibreTranslate API has rate limits
- Audio downloads are not directly supported by Web Speech API

## Deployment

See the [DEPLOYMENT.md](DEPLOYMENT.md) file for detailed deployment instructions.

## License

[MIT](https://choosealicense.com/licenses/mit/)

## Acknowledgements

- [Laravel](https://laravel.com)
- [LibreTranslate](https://libretranslate.com)
- [Web Speech API](https://developer.mozilla.org/en-US/docs/Web/API/Web_Speech_API)
- [Bootstrap](https://getbootstrap.com)
