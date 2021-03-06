<?php
require 'Connection.php';
class Functions extends Connection
{
    public $stmt;
    public $row;

    public function create($name, $email, $message)
    {
        Connection::openConnection();
        $sql = "INSERT INTO contacts (name, email, message) VALUES (:name, :email, :message)";
        $this->stmt = Connection::$conn->prepare($sql);
        $this->stmt->bindParam(':name', $name);
        $this->stmt->bindParam(':email', $email);
        $this->stmt->bindParam(':message', $message);
        $this->stmt->execute();
        return true;
    }

    public function read()
    {
        Connection::openConnection();
        $sql = 'SELECT * FROM contacts';
        $this->stmt = Connection::$conn->prepare($sql);
        $this->stmt->execute();
    }

    public function update()
    {
        Connection::openConnection();
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            $sql = " SELECT * FROM contacts WHERE id= :id ";
            $this->stmt = Connection::$conn->prepare($sql);
            $this->stmt->bindParam(':id', $id);
            $this->stmt->execute();
            $this->row = $this->stmt->fetch(PDO::FETCH_ASSOC);
        }
        if (isset($_POST['name']) && isset($_POST['email']) && isset($_POST['message'])) {
            $id = $_POST['id'];
            $name = $_POST['name'];
            $email = $_POST['email'];
            $message = $_POST['message'];
            $sql = "UPDATE contacts SET name = :name, email= :email, message = :message WHERE id= :id";
            $this->stmt = Connection::$conn->prepare($sql);
            $this->stmt->bindParam(':name', $name);
            $this->stmt->bindParam(':email', $email);
            $this->stmt->bindParam(':message', $message);
            $this->stmt->bindParam(':id', $id);
            $this->stmt->execute();
            header("location: read.php");
        }
    }

    public function delete()
    {
        Connection::openConnection();
        if (isset($_GET['del'])) {
            $id = $_GET['del'];
            $sql = "DELETE FROM contacts WHERE id= :id";
            $this->stmt = Connection::$conn->prepare($sql);
            $this->stmt->bindParam(':id', $id);
            $this->stmt->execute();
            header("location: read.php");
        }
        if (isset($_GET['all'])) {
            $sql = "DELETE FROM contacts";
            $this->stmt = Connection::$conn->prepare($sql);
            $this->stmt->execute();
            header("location: read.php");
        }
    }
}
