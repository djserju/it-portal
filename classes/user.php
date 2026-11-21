<?php
# User class handles querying admin user records from the users table for authentication during login.
class User {
    # Private property holding the active PDO database connection
    private PDO $db;
    
    # Constructor injects the PDO connection when a user object is created
    public function __construct(PDO $pdo) {
        $this->db = $pdo;
    }
    
    # Looks up an admin user by their email address using a prepared statement.
    # Returns the user's record as an array or null if not found.
    public function findByEmail(string $email): ?array {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE email = :email LIMIT 1");
        $stmt->execute([':email' => trim($email)]);
        $user = $stmt->fetch();
        return $user ?: null;
    }
}