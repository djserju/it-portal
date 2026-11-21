<?php
// Staff database class
// Staff database functions
class Staff
{
    private $db;

    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    public function all()
    {
        // Get every staff member
        // Return staff in database order
        $stmt = $this->db->prepare('SELECT * FROM staff ORDER BY id ASC');
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function find($id)
    {
        // Find one staff member by id
        // Find one staff member for viewing or deletion
        $stmt = $this->db->prepare('SELECT * FROM staff WHERE id = :id');
        $stmt->execute(['id' => (int) $id]);
        return $stmt->fetch();
    }

    public function create($data)
    {
        // Insert staff details and the photo file name
        // The uploaded photo name is saved in the staff table
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
        // Remove a staff record by id
        // Delete the staff row using the id
        $stmt = $this->db->prepare('DELETE FROM staff WHERE id = :id');
        return $stmt->execute(['id' => (int) $id]);
    }

    public function count()
    {
        // Count staff for the admin summary
        $stmt = $this->db->prepare('SELECT COUNT(*) FROM staff');
        $stmt->execute();
        return (int) $stmt->fetchColumn();
    }
}
