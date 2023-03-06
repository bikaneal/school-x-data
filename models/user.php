<?php

class User
{
    private ?PDO $conn;
    private string $table_name = "user";

    public int $id;
    public string $name;
    public string $username;
    public int $city_id;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    function get(): bool|PDOStatement
    {

        $query = "SELECT * FROM " . $this->table_name . " ORDER BY id DESC";

        $stmt = $this->conn->prepare($query);

        $stmt->execute();

        return $stmt;
    }

    function create(): bool
    {

        $query = "INSERT INTO " . $this->table_name . " SET name=:name, city_id=:city_id, username=:username";

        $stmt = $this->conn->prepare($query);


        $this->name = htmlspecialchars(strip_tags($this->name));
        $this->city_id = htmlspecialchars(strip_tags($this->city_id));
        $this->username = htmlspecialchars(strip_tags($this->username));


        $stmt->bindParam(":name", $this->name);
        $stmt->bindParam(":city_id", $this->city_id);
        $stmt->bindParam(":username", $this->username);

        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

    public function update(){

        $query = "UPDATE " . $this->table_name . " SET name=:name, city_id=:city_id, username=:username
        WHERE id = :id";

    
        $stmt = $this->conn->prepare($query);
    
        $this->name=htmlspecialchars(strip_tags($this->name));
        $this->city_id=htmlspecialchars(strip_tags($this->city_id));
        $this->username=htmlspecialchars(strip_tags($this->username));
        $this->id=htmlspecialchars(strip_tags($this->id));

    
        $stmt->bindParam(":name", $this->name);
        $stmt->bindParam(":city_id", $this->city_id);
        $stmt->bindParam(":username", $this->username);
        $stmt->bindParam(":id", $this->id);
    
        if($stmt->execute()){
           return true;
        }

        return false;
    }

    function delete(){

        $query = "DELETE FROM " . $this->table_name . " WHERE id = ?";
        $stmt = $this->conn->prepare($query);
    
        $this->id=htmlspecialchars(strip_tags($this->id));
    
        $stmt->bindParam(1, $this->id);
    
        if($stmt->execute()){
            return true;
        }
        return false;
    }

}