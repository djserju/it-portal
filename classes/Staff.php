<?php

// Handles staff database operations
class Staff
{
    private $db;

    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    public function all()
    {
        $stmt = $this->db->prepare('SELECT * FROM staff ORDER BY id ASC');
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function find($id)
    {
        $stmt = $this->db->prepare('SELECT * FROM staff WHERE id = :id');
        $stmt->execute(['id' => (int) $id]);
        return $stmt->fetch();
    }

    public function create($data)
    {
        $sql = 'INSERT INTO staff (name, position, phone, email, photo)
                VALUES (:name, :position, :phone, :email, :photo)';
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            'name' => trim($data['name']),
            'position' => trim($data['position']),
            'phone' => trim($data['phone']),
            'email' => trim($data['email']),
            'photo' => $data['photo']
        ]);
    }

    public function delete($id)
    {
        $stmt = $this->db->prepare('DELETE FROM staff WHERE id = :id');
        return $stmt->execute(['id' => (int) $id]);
    }

    public function count()
    {
        $stmt = $this->db->prepare('SELECT COUNT(*) FROM staff');
        $stmt->execute();
        return (int) $stmt->fetchColumn();
    }
}
