<?php
# Message class handles storing and retrieving HOD contact form submissions in the messages table using PDO statements.
class Message {
    # Private property holding the active PDO database connection
    private PDO $db;
    
    # Constructor injects the PDO connection when a message object is created
    public function __construct(PDO $pdo) {
        $this->db = $pdo;
    }
    
    # Inserts a new message submitted from the public contact in the HOD form
    public function create(array $data): bool {
        $sql = "INSERT INTO messages (name, email, subject, message)
                VALUES (:name, :email, :subject, :message)";
        $stmt = $this->db->prepare($sql);
        
        return $stmt->execute([
            ':name' => trim($data['name']),
            ':email' => trim($data['email']),
            ':subject' => trim($data['subject']),
            ':message' => trim($data['message']),
        ]);
    }
    
    # Retrieves all submitted messages ordered from newest to oldest
    public function all(): array {
        $stmt = $this->db->query("SELECT * FROM messages ORDER BY created_at DESC");
        return $stmt->fetchAll();
    }
}