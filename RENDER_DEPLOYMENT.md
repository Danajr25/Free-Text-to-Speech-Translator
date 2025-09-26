# Deploying Speech Translator to Render with Docker

This guide will walk you through deploying your Speech Translator application to Render using Docker.

## Prerequisites

- A GitHub account with your repository pushed to GitHub
- A Render account (sign up at https://render.com if you don't have one)
- Docker installed locally for testing (optional)

## Local Testing (Optional)

Before deploying to Render, you can test your Docker setup locally:

1. Open a terminal in your project root
2. Run `docker-compose build` to build your Docker image
3. Run `docker-compose up` to start the containers
4. Visit http://localhost:8000 to ensure everything works
5. Use Ctrl+C to stop the containers when done

## Deployment Steps

### 1. Push Your Code to GitHub

Ensure all files are committed and pushed to your GitHub repository:
- Dockerfile
- docker/nginx/nginx.conf
- .dockerignore
- docker-compose.yml
- render.yaml
- .env.example

### 2. Create a New Service on Render

1. Log in to your Render account
2. Click on the "New +" button and select "Blueprint" 
3. Connect your GitHub repository
4. Select the repository containing your Speech Translator application
5. Render will detect the render.yaml file and configure the services automatically
6. Click "Apply" to start the deployment process

### 3. Configure Environment Variables

Render will create both the web service and the database based on your render.yaml file.
You need to set the following environment variables in the Render dashboard:

- `APP_KEY`: Generate one using `php artisan key:generate --show` locally
- Any API keys or other secrets not included in the render.yaml file

### 4. Monitor the Deployment

1. Render will build your Docker container and deploy your application
2. Monitor the build logs in the Render dashboard
3. Once deployment is complete, Render will provide you with a URL to access your application

### 5. Post-Deployment Steps

After the first deployment:

1. Set up the database tables by running migrations:
   - Go to the "Shell" tab in your service dashboard
   - Run `php artisan migrate --force`

2. Optimize the application:
   - Run `php artisan config:cache`
   - Run `php artisan route:cache`

### Troubleshooting

- Check the Render logs for any build or runtime errors
- If the application crashes, check the Laravel logs in the Render shell with:
  `tail -f storage/logs/laravel.log`
- For database connection issues, verify your database credentials in the environment variables

### Maintenance and Updates

To update your application:

1. Push changes to your GitHub repository
2. Render will automatically detect changes and rebuild/deploy your application

## Additional Resources

- Render Documentation: https://render.com/docs
- Docker Documentation: https://docs.docker.com
- Laravel Deployment Best Practices: https://laravel.com/docs/10.x/deployment