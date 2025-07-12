<?php

declare(strict_types=1);

namespace Config;

use mysqli;

class Database
{
    private string $hostname = 'localhost';
    private string $username = 'root';
    private string $password = '';
    private string $database = 'todolist_task';

    public mysqli $conn;

    public function __construct()
    {
        $this->conn = new mysqli($this->hostname, $this->username, $this->password, $this->database);

        if ($this->conn->connect_error) {
            die(json_encode(['error' => 'Database connection failed']));
        }
    }
}
