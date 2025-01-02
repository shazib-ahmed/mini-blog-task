<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog Posts</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1>Blog Posts</h1>
            <a href="/create" class="btn btn-primary">Create New Post</a>
        </div>
        
        <div class="row" id="posts-container">
            <!-- Posts will be loaded here -->
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="/js/errorHandler.js"></script>
    <script>
        // Load posts when the page loads
        document.addEventListener('DOMContentLoaded', loadPosts);

        async function loadPosts() {
            showLoading('Loading posts...');
            try {
                const response = await fetch('/api/posts');
                const result = await handleApiResponse(response);
                
                const postsContainer = document.getElementById('posts-container');
                postsContainer.innerHTML = '';

                if (result.data.length === 0) {
                    postsContainer.innerHTML = `
                        <div class="col-12">
                            <div class="alert alert-info">
                                No posts found. Create your first post!
                            </div>
                        </div>
                    `;
                    Swal.close();
                    return;
                }

                result.data.forEach(post => {
                    const postHtml = `
                        <div class="col-md-6 mb-4">
                            <div class="card h-100">
                                <div class="card-body">
                                    <a href="/view/${post.id}" class="text-decoration-none">
                                        <h5 class="card-title text-dark">${post.title}</h5>
                                        <p class="card-text text-dark">${post.content.length > 150 ? post.content.substring(0, 150) + '...' : post.content}</p>
                                    </a>
                                    <div class="d-flex justify-content-between align-items-center mt-3">
                                        <small class="text-muted">Created: ${post.created_at}</small>
                                        <div>
                                            <a href="/edit/${post.id}" class="btn btn-sm btn-warning">Edit</a>
                                            <button onclick="deletePost(${post.id})" class="btn btn-sm btn-danger">Delete</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    `;
                    postsContainer.innerHTML += postHtml;
                });
                Swal.close();
            } catch (error) {
                handleError(error);
            }
        }

        async function deletePost(id) {
            try {
                const result = await showDeleteConfirmation();
                if (result.isConfirmed) {
                    showLoading('Deleting post...');
                    const response = await fetch(`/api/posts/${id}`, {
                        method: 'DELETE'
                    });
                    await handleApiResponse(response);
                    await showSuccess('Post deleted successfully');
                    loadPosts();
                }
            } catch (error) {
                handleError(error);
            }
        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
