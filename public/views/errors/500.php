<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>500 - Server Error</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            min-height: 100vh;
            display: flex;
            align-items: center;
        }
        .error-page {
            text-align: center;
            padding: 40px 0;
        }
        .error-code {
            font-size: 120px;
            font-weight: bold;
            color: #dc3545;
            margin-bottom: 0;
            line-height: 1;
        }
        .error-message {
            font-size: 24px;
            color: #6c757d;
            margin: 20px 0;
        }
        .error-description {
            color: #6c757d;
            margin-bottom: 30px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="error-page">
                    <h1 class="error-code">500</h1>
                    <h2 class="error-message">Internal Server Error</h2>
                    <p class="error-description">
                        Oops! Something went wrong on our end.<br>
                        Our team has been notified and we're working to fix the issue.
                    </p>
                    <a href="/" class="btn btn-primary">Back to Home</a>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
