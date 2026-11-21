<?php

// Handles course database operations
class Course
{
    private $db;

    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    public function all()
    {
        $stmt = $this->db->prepare('SELECT * FROM courses ORDER BY code ASC');
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function find($id)
    {
        $stmt = $this->db->prepare('SELECT * FROM courses WHERE id = :id');
        $stmt->execute(['id' => (int) $id]);
        return $stmt->fetch();
    }

    public function codeExists($code, $excludeId = null)
    {
        if ($excludeId) {
            $stmt = $this->db->prepare('SELECT id FROM courses WHERE code = :code AND id != :id');
            $stmt->execute(['code' => $code, 'id' => (int) $excludeId]);
        } else {
            $stmt = $this->db->prepare('SELECT id FROM courses WHERE code = :code');
            $stmt->execute(['code' => $code]);
        }
        return $stmt->fetch() !== false;
    }

    public function create($data)
    {
        $sql = 'INSERT INTO courses (code, name, credits, prerequisites, description)
                VALUES (:code, :name, :credits, :prerequisites, :description)';
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            'code' => trim($data['code']),
            'name' => trim($data['name']),
            'credits' => (int) $data['credits'],
            'prerequisites' => $data['prerequisites'] === '' ? null : trim($data['prerequisites']),
            'description' => trim($data['description'])
        ]);
    }

    public function update($id, $data)
    {
        $sql = 'UPDATE courses SET code = :code, name = :name, credits = :credits,
                prerequisites = :prerequisites, description = :description WHERE id = :id';
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            'code' => trim($data['code']),
            'name' => trim($data['name']),
            'credits' => (int) $data['credits'],
            'prerequisites' => $data['prerequisites'] === '' ? null : trim($data['prerequisites']),
            'description' => trim($data['description']),
            'id' => (int) $id
        ]);
    }

    public function delete($id)
    {
        $stmt = $this->db->prepare('DELETE FROM courses WHERE id = :id');
        return $stmt->execute(['id' => (int) $id]);
    }

    public function count()
    {
        $stmt = $this->db->prepare('SELECT COUNT(*) FROM courses');
        $stmt->execute();
        return (int) $stmt->fetchColumn();
    }
}
