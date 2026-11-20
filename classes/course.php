<?php
#Course class handles all CRUD database operations
class Course {
    # Private property holding the active PDO database connection
    private PDO $db;
    
    # Constructor injects the PDO connection when a Course object is created
    public function __construct(PDO $pdo) {
        $this->db = $pdo;
    }
    
    # Retrieves all courses ordered alphabetically by course code
    public function all(): array {
        $stmt = $this->db->query("SELECT * FROM courses ORDER BY code ASC");
        return $stmt->fetchAll();
    }
    
    # Finds and returns a single course by its primary key ID or null if not found
    public function find(int $id): ?array {
        $stmt = $this->db->prepare("SELECT * FROM courses WHERE id = :id");
        $stmt->execute([':id' => $id]);
        $course = $stmt->fetch();
        return $course ?: null;
    }
    
    # Checks if a course code already exists in the database
    public function codeExists(string $code, ?int $excludeId = null): bool {
        if ($excludeId !== null) {
            $stmt = $this->db->prepare("SELECT COUNT(*) FROM courses WHERE code = :code AND id != :id");
            $stmt->execute([':code' => $code, ':id' => $excludeId]);
        } else {
            $stmt = $this->db->prepare("SELECT COUNT(*) FROM courses WHERE code = :code");
            $stmt->execute([':code' => $code]);
        }
        return (int)$stmt->fetchColumn() > 0;
    }
    
    # Inserts a new course record into the database using a prepared statement
    public function create(array $data): bool {
        $sql = "INSERT INTO courses (code, name, credits, prerequisites, description)
                VALUES (:code, :name, :credits, :prerequisites, :description)";
        $stmt = $this->db->prepare($sql);
        
        return $stmt->execute([
            ':code' => strtoupper(trim($data['code'])),
            ':name' => trim($data['name']),
            ':credits' => (int)$data['credits'],
            #Stores NULL in the database if prerequisites are left blank
            ':prerequisites' => !empty(trim($data['prerequisites'])) ? trim($data['prerequisites']) : null,
            ':description' => trim($data['description']),
        ]);
    }
    
    # Updates an existing course record identified by $id
    public function update(int $id, array $data): bool {
        $sql = "UPDATE courses
                SET code = :code, name = :name, credits = :credits,
                    prerequisites = :prerequisites, description = :description
                WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        
        return $stmt->execute([
            ':code' => strtoupper(trim($data['code'])),
            ':name' => trim($data['name']),
            ':credits' => (int)$data['credits'],
            ':prerequisites' => !empty(trim($data['prerequisites'])) ? trim($data['prerequisites']) : null,
            ':description' => trim($data['description']),
            ':id' => $id,
        ]);
    }
    
    #Deletes a course record from the database by its ID
    public function delete(int $id): bool {
        $stmt = $this->db->prepare("DELETE FROM courses WHERE id = :id");
        return $stmt->execute([':id' => $id]);
    }
}