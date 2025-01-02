<?php
require_once(__DIR__ . '/../models/Post.php');

/**
 * Controller class for handling blog post operations
 * 
 * This class manages all CRUD operations for blog posts including
 * creating, reading, updating, and deleting posts.
 */
class PostController
{
    /** @var PDO Database connection instance */
    private $db;
    
    /** @var Post Post model instance */
    private $post;

    /**
     * Constructor for PostController
     * 
     * @param PDO $database Database connection instance
     */
    public function __construct($database)
    {
        $this->db = $database;
        $this->post = new Post($this->db);
    }

    /**
     * Validates post data
     * 
     * @param array $data Post data to validate
     * @return array Array with validation status and message
     */
    private function validatePostData($data)
    {
        if (!isset($data['title']) || !isset($data['content'])) {
            return ['valid' => false, 'message' => 'Title and content are required'];
        }

        $title = trim($data['title']);
        $content = trim($data['content']);

        if (empty($title) || empty($content)) {
            return ['valid' => false, 'message' => 'Title and content cannot be empty'];
        }

        if (strlen($title) > 50) {
            return ['valid' => false, 'message' => 'Title cannot be longer than 50 characters'];
        }

        return ['valid' => true, 'data' => ['title' => $title, 'content' => $content]];
    }

    /**
     * Sends a JSON response to the client
     * 
     * @param string $status Status of the response ('success' or 'error')
     * @param mixed|null $data Data to be sent in the response
     * @param string|null $message Optional message to be included
     * @param int $code HTTP status code
     */
    private function sendResponse($status, $data = null, $message = null, $code = 200)
    {
        http_response_code($code);
        echo json_encode([
            'status' => $status,
            'data' => $data,
            'message' => $message
        ]);
        exit;
    }

    /**
     * Sends an error response to the client
     * 
     * @param string $message Error message
     * @param int $code HTTP status code
     */
    private function sendError($message, $code = 400)
    {
        $this->sendResponse('error', null, $message, $code);
    }

    /**
     * Retrieves all blog posts
     * 
     * @return void Outputs JSON response
     */
    public function index()
    {
        try {
            $posts = $this->post->all();
            $this->sendResponse('success', $posts);
        } catch (PDOException $e) {
            $this->sendError('Failed to fetch posts: ' . $e->getMessage(), 500);
        }
    }

    /**
     * Retrieves a specific blog post
     * 
     * @param int $id Post ID
     * @return void Outputs JSON response
     */
    public function show($id)
    {
        try {
            $post = $this->post->find($id);

            if (!$post) {
                $this->sendError('Post not found', 404);
            }

            $this->sendResponse('success', $post);
        } catch (PDOException $e) {
            $this->sendError('Failed to fetch post: ' . $e->getMessage(), 500);
        }
    }

    /**
     * Creates a new blog post
     * 
     * @return void Outputs JSON response
     */
    public function store()
    {
        try {
            $data = json_decode(file_get_contents('php://input'), true);
            
            // Validate post data
            $validation = $this->validatePostData($data);
            if (!$validation['valid']) {
                $this->sendError($validation['message']);
            }

            $validatedData = $validation['data'];
            $id = $this->post->create($validatedData['title'], $validatedData['content']);
            $newPost = $this->post->find($id);
            $this->sendResponse('success', $newPost, 'Post created successfully', 201);
        } catch (PDOException $e) {
            $this->sendError('Failed to create post: ' . $e->getMessage(), 500);
        }
    }

    /**
     * Updates an existing blog post
     * 
     * @param int $id Post ID
     * @return void Outputs JSON response
     */
    public function update($id)
    {
        try {
            $post = $this->post->find($id);
            if (!$post) {
                $this->sendError('Post not found', 404);
            }

            $data = json_decode(file_get_contents('php://input'), true);
            
            // Validate post data
            $validation = $this->validatePostData($data);
            if (!$validation['valid']) {
                $this->sendError($validation['message']);
            }

            $validatedData = $validation['data'];
            $this->post->update($id, $validatedData['title'], $validatedData['content']);
            $updatedPost = $this->post->find($id);
            $this->sendResponse('success', $updatedPost, 'Post updated successfully');
        } catch (PDOException $e) {
            $this->sendError('Failed to update post: ' . $e->getMessage(), 500);
        }
    }

    /**
     * Deletes a blog post
     * 
     * @param int $id Post ID
     * @return void Outputs JSON response
     */
    public function delete($id)
    {
        try {
            $post = $this->post->find($id);
            if (!$post) {
                $this->sendError('Post not found', 404);
            }

            $this->post->delete($id);
            $this->sendResponse('success', null, 'Post deleted successfully');
        } catch (PDOException $e) {
            $this->sendError('Failed to delete post: ' . $e->getMessage(), 500);
        }
    }
}