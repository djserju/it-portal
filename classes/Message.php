<?php

class Message
{
    private $db;

    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    public function all()
    {
        $stmt = $this->db->prepare('SELECT * FROM messages ORDER BY created_at DESC');
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function create($data)
    {
        $sql = 'INSERT INTO messages (name, email, subject, message)
                VALUES (:name, :email, :subject, :message)';
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            'name' => trim($data['name']),
            'email' => trim($data['email']),
            'subject' => trim($data['subject']),
            'message' => trim($data['message'])
        ]);
    }

    public function count()
    {
        $stmt = $this->db->prepare('SELECT COUNT(*) FROM messages');
        $stmt->execute();
        return (int) $stmt->fetchColumn();
    }
}
