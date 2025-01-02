# PHP Blog Application

A mini blog application built with PHP, featuring a RESTful API and a user-friendly frontend. The application uses Docker for easy development and deployment.

## Features

- RESTful API for blog post management
- Responsive frontend using Bootstrap 5
- SweetAlert2 for beautiful notifications
- Docker containerization
- MySQL database
- MVC architecture

## Prerequisites

- Docker and Docker Compose
- PHP 8.x
- MySQL 8.x

## Installation

1. Clone the repository
```bash
git clone https://github.com/shazib-ahmed/mini-blog-task.git
cd mini-blog-task
```

2. Create .env file
```bash
cp .env.example .env
```

3. Start Docker containers
```bash
docker-compose up -d
```

4. Access the application at `http://localhost:8080`

## Routes

### Frontend Routes

| Route | Description |
|-------|-------------|
| `/` | Home page - Lists all blog posts |
| `/create` | Display form to create a new post |
| `/edit/{id}` | Display form to edit an existing post |
| `/view/{id}` | View a single post in detail |

### API Routes

| Method | Route | Description | Request Body | Response |
|--------|-------|-------------|--------------|----------|
| GET | `/api/posts` | Get all posts | - | `{"status": "success", "data": [posts]}` |
| GET | `/api/posts/{id}` | Get single post | - | `{"status": "success", "data": post}` |
| POST | `/api/posts` | Create new post | `{"title": "string", "content": "string"}` | `{"status": "success", "message": "Post created"}` |
| PUT | `/api/posts/{id}` | Update post | `{"title": "string", "content": "string"}` | `{"status": "success", "message": "Post updated"}` |
| DELETE | `/api/posts/{id}` | Delete post | - | `{"status": "success", "message": "Post deleted"}` |

## API Examples

### Get All Posts
```bash
curl -X GET http://localhost:8080/api/posts
```

### Get Single Post
```bash
curl -X GET http://localhost:8080/api/posts/1
```

### Create Post
```bash
curl -X POST http://localhost:8080/api/posts \
  -H "Content-Type: application/json" \
  -d '{"title":"My Post","content":"Post content"}'
```

### Update Post
```bash
curl -X PUT http://localhost:8080/api/posts/1 \
  -H "Content-Type: application/json" \
  -d '{"title":"Updated Title","content":"Updated content"}'
```

### Delete Post
```bash
curl -X DELETE http://localhost:8080/api/posts/1
```

## API Response Format

### Success Response
```json
{
    "status": "success",
    "data": {
        "id": 1,
        "title": "Post Title",
        "content": "Post content",
        "created_at": "2025-01-02 14:24:10"
    }
}
```

### Error Response
```json
{
    "status": "error",
    "message": "Error message"
}
```

## Frontend Features

1. **Home Page**
   - List of all posts in a responsive grid
   - Clickable post cards to view full content
   - Quick edit and delete options
   - Create new post button

2. **Create/Edit Forms**
   - Input validation
   - Loading states
   - Success/error notifications
   - Automatic redirection after success

3. **View Post**
   - Full post content display
   - Creation date
   - Edit and delete options
   - Back to posts navigation

4. **User Interface**
   - Bootstrap 5 for responsive design
   - SweetAlert2 for notifications
   - Loading states for better UX
   - Error handling with user-friendly messages

## Project Structure
```
php-blog/
├── app/
│   ├── config/          # Configuration files
│   ├── controllers/     # Controllers
│   └── models/         # Database models
├── public/
│   ├── views/          # Frontend views
│   └── index.php       # Entry point
├── migrations/         # Database migrations
└── docker/            # Docker configuration
```

## CI/CD Setup and Deployment

### Continuous Integration and Deployment (CI/CD)

The application uses GitHub Actions for automated testing, building, and deployment. Here's how our CI/CD pipeline works:

1. **Continuous Integration (CI)**:
   When code is pushed to the repository, the CI pipeline:
   - Validates PHP syntax and coding standards
   - Runs PHPUnit tests for backend
   - Checks JavaScript linting
   - Validates Docker configuration
   - Builds Docker images
   - Runs security scans

2. **Continuous Deployment (CD)**:
   After successful CI, the CD pipeline:
   - Deploys to staging for feature branches
   - Deploys to production for main branch
   - Runs database migrations
   - Performs health checks
   - Monitors application metrics

### Deployment Guide

#### Prerequisites
- Docker Engine 20.10+
- Docker Compose 2.0+
- Git
- 2GB RAM minimum
- 20GB disk space

#### Production Deployment Steps

1. **Server Setup**:
   ```bash
   # Update system packages
   sudo apt-get update && sudo apt-get upgrade -y

   # Install Docker
   curl -fsSL https://get.docker.com -o get-docker.sh
   sudo sh get-docker.sh

   # Install Docker Compose
   sudo curl -L "https://github.com/docker/compose/releases/download/v2.23.0/docker-compose-$(uname -s)-$(uname -m)" -o /usr/local/bin/docker-compose
   sudo chmod +x /usr/local/bin/docker-compose
   ```

2. **Application Deployment**:
   ```bash
   # Clone repository
   git clone https://github.com/shazib-ahmed/mini-blog-task.git
   cd mini-blog-task

   # Set up environment variables
   cp .env.example .env
   # Edit .env with production values
   nano .env

   # Build and start containers
   docker-compose -f docker-compose.prod.yml up -d --build

   # Run database migrations
   docker-compose -f docker-compose.prod.yml exec app php migrations/migrate.php
   ```

3. **SSL Setup** (Optional but recommended):
   ```bash
   # Install Certbot
   sudo apt-get install certbot python3-certbot-apache

   # Get SSL certificate
   sudo certbot --apache -d yourdomain.com
   ```

4. **Security Checklist**:
   - [ ] Update all system packages
   - [ ] Configure firewall (allow ports 80, 443)
   - [ ] Set secure environment variables
   - [ ] Enable HTTPS
   - [ ] Set up database backups
   - [ ] Configure logging

5. **Monitoring Setup**:
   - Set up health check endpoint monitoring
   - Configure error logging
   - Set up performance monitoring
   - Enable security scanning

### Rolling Updates

To perform zero-downtime updates:

```bash
# Pull latest changes
git pull origin main

# Build new images
docker-compose -f docker-compose.prod.yml build

# Update containers
docker-compose -f docker-compose.prod.yml up -d --no-deps --build app

# Run migrations if needed
docker-compose -f docker-compose.prod.yml exec app php migrations/migrate.php
```

### Backup and Restore

1. **Database Backup**:
   ```bash
   # Backup
   docker-compose exec db mysqldump -u root -p mini_blog > backup.sql

   # Restore
   docker-compose exec -T db mysql -u root -p mini_blog < backup.sql
   ```

2. **Application Backup**:
   ```bash
   # Backup uploaded files
   tar -czf uploads_backup.tar.gz ./public/uploads

   # Backup environment files
   cp .env env_backup
   ```

### Troubleshooting

1. **Container Issues**:
   ```bash
   # Check container logs
   docker-compose logs app
   docker-compose logs db

   # Restart services
   docker-compose restart
   ```

2. **Database Issues**:
   ```bash
   # Check database connection
   docker-compose exec app php -r "new PDO('mysql:host=db;dbname=mini_blog', 'root', 'secret');"
   ```

3. **Permission Issues**:
   ```bash
   # Fix storage permissions
   docker-compose exec app chown -R www-data:www-data /var/www/html/storage
   ```

### Monitoring and Logging

1. **Application Logs**:
   - PHP error logs: `/var/log/apache2/error.log`
   - Access logs: `/var/log/apache2/access.log`
   - MySQL logs: `/var/log/mysql/error.log`

2. **Performance Monitoring**:
   - Set up New Relic or similar APM tool
   - Monitor server resources
   - Track response times
   - Monitor error rates

### Scaling

For horizontal scaling:
1. Set up load balancer
2. Configure session handling
3. Use centralized caching
4. Set up database replication

### Security Best Practices

1. **Server Security**:
   - Regular security updates
   - Firewall configuration
   - Intrusion detection
   - DDoS protection

2. **Application Security**:
   - Input validation
   - SQL injection prevention
   - XSS protection
   - CSRF protection

3. **Database Security**:
   - Regular backups
   - Secure credentials
   - Access control
   - Data encryption
