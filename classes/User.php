<?php
// User database class
// User database functions
class User
{
    private $db;

    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    public function findByEmail($email)
    {
        // Find one login account by email
        // The login page uses this to find a user
        $stmt = $this->db->prepare('SELECT * FROM users WHERE email = :email LIMIT 1');
        $stmt->execute(['email' => trim($email)]);
        return $stmt->fetch();
    }
}
