<?php

class TaskManager
{
    private $database;

    public function __construct(Database $database)
    {
        $this->database = $database;
    }

    public function createTask($title, $description)
    {
        $conn = $this->database->connect();
        $sql = "INSERT INTO tasks (title, description) VALUES (:title, :description)";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(":title", $title);
        $stmt->bindParam(":description", $description);
        $stmt->execute();
    }

    public function getTasks()
    {
        $conn = $this->database->connect();
        $sql = "SELECT * FROM tasks";
        $stmt = $conn->query($sql);
        $tasks = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $tasks[] = new Task($row['id'], $row['title'], $row['description']);
        }
        return $tasks;
    }

    public function updateTask($id, $title, $description)
    {
        $conn = $this->database->connect();
        $sql = "UPDATE tasks SET title = :title, description = :description WHERE id = :id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(":id", $id);
        $stmt->bindParam(":title", $title);
        $stmt->bindParam(":description", $description);
        $stmt->execute();
    }

    public function deleteTask($id)
    {
        $conn = $this->database->connect();
        $sql = "DELETE FROM tasks WHERE id = :id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(":id", $id);
        $stmt->execute();
    }
}
