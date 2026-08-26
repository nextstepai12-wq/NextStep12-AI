# NextStep AI Service

AI microservice responsible for extracting study plans from PDF files.

## Requirements

- Docker Desktop


# Local Development

Go to ai-service folder:

cd ai-service


Build and run:

docker compose up --build


API Documentation:

http://localhost:8000/docs

AI_SERVICE_URL=http://localhost:8000


## API Endpoint

POST /extract-plan


Input:
PDF file


Output:
JSON response


# Production Deployment

On production server:

1. Clone repository

git clone <repository-url>


2. Go to AI service folder:

cd ai-service


3. Build image:

docker compose build


4. Run service:

docker compose up -d


The service will run as a container.


Environment:
AI Service URL:
https://ai.nextstep.com