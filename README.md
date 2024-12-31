# Mini Blog Application

## Prerequisites
- Docker
- Docker Compose

## Setup Instructions
1. Clone the repository.
2. Run `docker-compose up --build` to build the containers and start the application.
3. Access the application at `http://localhost:8080`.

## Endpoints
- `GET /posts` - List all posts.
- `POST /posts` - Create a new post (JSON body required).
- `PUT /posts/{id}` - Update a post.
- `DELETE /posts/{id}` - Delete a post.

## CI/CD Setup and Deployment

### Continuous Integration and Deployment (CI/CD)

We have set up CI/CD pipelines for automated testing, building, and deploying the application. The CI/CD process is as follows:

1. **Continuous Integration (CI)**:
   - Whenever code is pushed to the repository (master branch or feature branches), the CI pipeline is triggered.
   - The CI pipeline will:
     - Run unit tests.
     - Build the Docker images.
     - Run any linting or static code analysis tools.

2. **Continuous Deployment (CD)**:
   - After successful CI pipeline execution, the CD pipeline will:
     - Deploy the application to a staging or production environment.
     - Ensure the application is running by performing health checks.

### Deployment

For deploying the application to a production environment, follow these steps:

1. **Set up Docker and Docker Compose on the server**:
   - Install Docker and Docker Compose on the production server.
   
2. **Clone the repository on the production server**:
   ```bash
   git clone https://github.com/shazib-ahmed/mini-blog-task.git
   cd mini-blog-task
