const API_URL = 'http://localhost:8080/posts';

async function fetchPosts() {
    const response = await fetch(API_URL);
    const posts = await response.json();
    const postsDiv = document.getElementById('posts');
    postsDiv.innerHTML = '';
    posts.forEach(post => {
        const postHtml = `
            <div>
                <h3>${post.title}</h3>
                <p>${post.content}</p>
                <button onclick="editPost(${post.id})">Edit</button>
                <button onclick="deletePost(${post.id})">Delete</button>
            </div>
        `;
        postsDiv.innerHTML += postHtml;
    });
}

async function createPost(event) {
    event.preventDefault();
    const title = document.getElementById('title').value;
    const content = document.getElementById('content').value;

    await fetch(API_URL, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({ title, content }),
    });

    window.location.href = 'index.html';
}

async function editPost(id) {
    // Redirect to edit page with the post ID (implement edit.html logic accordingly)
    window.location.href = `edit.html?id=${id}`;
}

async function deletePost(id) {
    await fetch(`${API_URL}/${id}`, { method: 'DELETE' });
    fetchPosts();
}
