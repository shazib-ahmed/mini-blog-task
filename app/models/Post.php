<?php
/**
 * Post Model Class
 * 
 * Handles database operations for blog posts including
 * creating, reading, updating, and deleting posts.
 */
class Post
{
    /** @var PDO Database connection instance */
    private $db;

    /**
     * Constructor for Post model
     * 
     * @param PDO $db Database connection instance
     */
    public function __construct($db)
    {
        $this->db = $db;
    }

    /**
     * Retrieves all posts from the database
     * 
     * @return array Array of posts ordered by creation date
     */
    public function all()
    {
        $query = $this->db->query("SELECT * FROM posts ORDER BY created_at DESC");
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Finds a specific post by ID
     * 
     * @param int $id Post ID to find
     * @return array|false Post data or false if not found
     */
    public function find($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM posts WHERE id = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Creates a new post in the database
     * 
     * @param string $title Post title
     * @param string $content Post content
     * @return string The ID of the newly created post
     */
    public function create($title, $content)
    {
        $stmt = $this->db->prepare("INSERT INTO posts (title, content) VALUES (:title, :content)");
        $stmt->execute(['title' => $title, 'content' => $content]);
        return $this->db->lastInsertId();
    }

    /**
     * Updates an existing post
     * 
     * @param int $id Post ID to update
     * @param string $title New post title
     * @param string $content New post content
     * @return bool True if update was successful
     */
    public function update($id, $title, $content)
    {
        $stmt = $this->db->prepare("UPDATE posts SET title = :title, content = :content WHERE id = :id");
        return $stmt->execute(['id' => $id, 'title' => $title, 'content' => $content]);
    }

    /**
     * Deletes a post from the database
     * 
     * @param int $id Post ID to delete
     * @return bool True if deletion was successful
     */
    public function delete($id)
    {
        $stmt = $this->db->prepare("DELETE FROM posts WHERE id = :id");
        return $stmt->execute(['id' => $id]);
    }
}
