<?php
# Staff class handles all database operations for the staff table using PDO prepared statements.
class Staff {
    #Private property holding the active PDO database connection
    private PDO $db;
    
    # Constructor injects the PDO connection when a staff object is created
    public function __construct(PDO $pdo) {
        $this->db = $pdo;
    }
    
    # Retrieves all staff members ordered by ID 
    public function all(): array {
        $stmt = $this->db->query("SELECT * FROM staff ORDER BY id ASC");
        return $stmt->fetchAll();
    }
    
    # Finds and returns a single staff member by ID or null if not found
    public function find(int $id): ?array {
        $stmt = $this->db->prepare("SELECT * FROM staff WHERE id = :id");
        $stmt->execute([':id' => $id]);
        $member = $stmt->fetch();
        return $member ?: null;
    }
    
    # Inserts a new staff member record into the database using a prepared statement
    public function create(array $data): bool {
        $sql = "INSERT INTO staff (name, position, phone, email, photo)
                VALUES (:name, :position, :phone, :email, :photo)";
        $stmt = $this->db->prepare($sql);
        
        return $stmt->execute([
            ':name' => trim($data['name']),
            ':position' => trim($data['position']),
            ':phone' => trim($data['phone']),
            ':email' => trim($data['email']),
            ':photo' => $data['photo'], # Unique filename generated during upload
        ]);
    }
    
    # Deletes a staff member record from the database by its ID
    public function delete(int $id): bool {
        $stmt = $this->db->prepare("DELETE FROM staff WHERE id = :id");
        return $stmt->execute([':id' => $id]);
    }
}