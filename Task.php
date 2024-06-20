<?php

class Task
{
    private $id;
    private $title;
    private $description;

    public function __construct($id, $title, $description)
    {
        $this->id = $id;
        $this->title = $title;
        $this->description = $description;
    }

    // Getters and Setters (optional)

    public function getId()
    {
        return $this->id;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function setTitle($title)
    {
        // You can add validation or logic here before setting the title
        $this->title = $title;
    }

    public function setDescription($description)
    {
        // You can add validation or logic here before setting the description
        $this->description = $description;
    }
}
