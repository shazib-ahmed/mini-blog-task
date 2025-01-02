<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Post</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h2 class="mb-0">Edit Post</h2>
                        <a href="/" class="btn btn-secondary">Back to Posts</a>
                    </div>
                    <div class="card-body">
                        <form id="editForm" onsubmit="updatePost(event)">
                            <div class="mb-3">
                                <label for="title" class="form-label">Title</label>
                                <input type="text" class="form-control" id="title" name="title" required>
                            </div>
                            <div class="mb-3">
                                <label for="content" class="form-label">Content</label>
                                <textarea class="form-control" id="content" name="content" rows="5" required></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary">Update Post</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="/js/errorHandler.js"></script>
    <script>
        // Load post data when page loads
        document.addEventListener('DOMContentLoaded', async () => {
            const postId = window.location.pathname.split('/').pop();
            try {
                showLoading('Loading post...');
                const response = await fetch(`/api/posts/${postId}`);
                const result = await response.json();
                
                if (response.ok) {
                    document.getElementById('title').value = result.data.title;
                    document.getElementById('content').value = result.data.content;
                } else {
                    await Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: result.message || 'Failed to load post'
                    });
                    setTimeout(() => {
                        window.location.href = '/';
                    }, 2000);
                }
            } catch (error) {
                await Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'An unexpected error occurred'
                });
                setTimeout(() => {
                    window.location.href = '/';
                }, 2000);
            } finally {
                Swal.close();
            }
        });

        async function updatePost(event) {
            event.preventDefault();
            
            const postId = window.location.pathname.split('/').pop();
            const title = document.getElementById('title').value;
            const content = document.getElementById('content').value;

            try {
                showLoading('Updating post...');
                
                const response = await fetch(`/api/posts/${postId}`, {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({ title, content })
                });

                const result = await response.json();
                
                if (response.ok) {
                    await showSuccess('Post updated successfully');
                    window.location.href = '/';
                } else {
                    await Swal.fire({
                        icon: 'error',
                        title: 'Validation Error',
                        text: result.message || 'Failed to update post'
                    });
                }
            } catch (error) {
                await Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'An unexpected error occurred'
                });
            } finally {
                Swal.close();
            }
        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
