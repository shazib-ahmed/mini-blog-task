<?php
require_once(__DIR__ . '/../models/Post.php');

class PostController
{
    private $post;

    public function __construct($db)
    {
        $this->post = new Post($db);
    }

    public function index()
    {
        echo json_encode($this->post->all());
    }

    public function show($id)
    {
        echo json_encode($this->post->find($id));
    }

    public function store($data)
    {
        if (strlen($data['title']) > 50) {
            http_response_code(400);
            echo json_encode(['error' => 'Title must be less than 50 characters.']);
            return;
        }
        $this->post->create($data['title'], $data['content']);
        echo json_encode(['message' => 'Post created successfully']);
    }

    public function update($id, $data)
    {
        if (strlen($data['title']) > 50) {
            http_response_code(400);
            echo json_encode(['error' => 'Title must be less than 50 characters.']);
            return;
        }
        $this->post->update($id, $data['title'], $data['content']);
        echo json_encode(['message' => 'Post updated successfully']);
    }

    public function destroy($id)
    {
        $this->post->delete($id);
        echo json_encode(['message' => 'Post deleted successfully']);
    }
}