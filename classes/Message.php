<?php
// Message database class
// Message database functions
class Message
{
    private $db;

    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    public function all()
    {
        // Get messages in newest-first order
        // Newest messages come first
        $stmt = $this->db->prepare('SELECT * FROM messages ORDER BY created_at DESC');
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function create($data)
    {
        // Insert one contact form message
        // Save one contact form submission with prepared values
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
        // Count messages for the admin summary
        // Count messages for the dashboard
        $stmt = $this->db->prepare('SELECT COUNT(*) FROM messages');
        $stmt->execute();
        return (int) $stmt->fetchColumn();
    }
}
