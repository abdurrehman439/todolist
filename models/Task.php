<?php

declare(strict_types=1);

namespace Models;

use mysqli;

class Task
{
    private mysqli $db;

    public function __construct(mysqli $db)
    {
        $this->db = $db;
    }

    
    public function getAll(): array
    {
        $sql    = "SELECT * FROM tasks";
        $result = $this->db->query($sql);

        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getById(int $id): array|null
    {
        $id     = (int)$this->db->real_escape_string((string)$id);

        $sql    = "SELECT * FROM tasks WHERE id = '$id'";
        $result = $this->db->query($sql);

        if ($result && $result->num_rows > 0) 
        {
            return $result->fetch_assoc();
        }

        return null;
    }

    public function create(array $data): bool
    {
        $title       = $this->db->real_escape_string($data['title']);
        $description = isset($data['description']) ? $this->db->real_escape_string($data['description']) : '';

        $sql = "INSERT INTO tasks (title, description) VALUES ('$title', '$description')";
        return $this->db->query($sql);
    }

    public function update(int $id, array $data): bool
    {
        $id         = (int)$id;
        $title      = $this->db->real_escape_string($data['title']);
        $description = isset($data['description']) ? $this->db->real_escape_string($data['description']) : '';

        $sql = "UPDATE tasks SET title = '$title', description = '$description' WHERE id = '$id'";
        return $this->db->query($sql);
    }

    public function delete(int $id): bool
    {
        $id         = (int)$this->db->real_escape_string((string)$id);
        
        $sql        = "DELETE FROM tasks WHERE id = '$id'";
        return $this->db->query($sql);
    }

    public function markStatus(int $id,string $status): bool
    {
        $id         = (int)$this->db->real_escape_string((string)$id);
        $status     = (int)$this->db->real_escape_string((string)$status);

        $sql        = "UPDATE tasks SET status = '$status' WHERE id = '$id'";
        return $this->db->query($sql);
    }
}
