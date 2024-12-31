<?php
class Post
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function all()
    {
        $query = $this->db->query("SELECT * FROM posts");
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    public function create($title, $content)
    {
        $stmt = $this->db->prepare("INSERT INTO posts (title, content) VALUES (:title, :content)");
        $stmt->execute(['title' => $title, 'content' => $content]);
    }

    public function update($id, $title, $content)
    {
        $stmt = $this->db->prepare("UPDATE posts SET title = :title, content = :content WHERE id = :id");
        $stmt->execute(['id' => $id, 'title' => $title, 'content' => $content]);
    }

    public function delete($id)
    {
        $stmt = $this->db->prepare("DELETE FROM posts WHERE id = :id");
        $stmt->execute(['id' => $id]);
    }
}
