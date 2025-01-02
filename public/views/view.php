<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Post</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h2 class="mb-0" id="post-title">Loading...</h2>
                        <a href="/" class="btn btn-secondary">Back to Posts</a>
                    </div>
                    <div class="card-body">
                        <div class="mb-4">
                            <p class="text-muted" id="post-date">Loading...</p>
                            <div class="post-content" id="post-content">
                                Loading...
                            </div>
                        </div>
                        <div class="d-flex justify-content-end gap-2">
                            <a id="edit-button" class="btn btn-warning">Edit</a>
                            <button onclick="deletePost()" class="btn btn-danger">Delete</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="/js/errorHandler.js"></script>
    <script>
        // Get post ID from URL
        const pathParts = window.location.pathname.split('/');
        const postId = pathParts[pathParts.length - 1];

        // Load post data when page loads
        document.addEventListener('DOMContentLoaded', loadPost);

        async function loadPost() {
            showLoading('Loading post...');
            try {
                const response = await fetch(`/api/posts/${postId}`);
                const result = await handleApiResponse(response);
                
                document.getElementById('post-title').textContent = result.data.title;
                document.getElementById('post-content').textContent = result.data.content;
                document.getElementById('post-date').textContent = `Posted on: ${result.data.created_at}`;
                document.getElementById('edit-button').href = `/edit/${result.data.id}`;
                Swal.close();
            } catch (error) {
                handleError(error);
                setTimeout(() => {
                    window.location.href = '/';
                }, 2000);
            }
        }

        async function deletePost() {
            try {
                const result = await showDeleteConfirmation();
                if (result.isConfirmed) {
                    showLoading('Deleting post...');
                    const response = await fetch(`/api/posts/${postId}`, {
                        method: 'DELETE'
                    });
                    await handleApiResponse(response);
                    await showSuccess('Post deleted successfully');
                    window.location.href = '/';
                }
            } catch (error) {
                handleError(error);
            }
        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
