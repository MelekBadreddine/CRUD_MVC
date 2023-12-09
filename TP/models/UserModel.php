<?php

class UserModel {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function getUserById($id) {
        $query = "SELECT * FROM `user` WHERE `id` = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    public function addUser($username, $password, $nom, $prenom) {
        $query = "INSERT INTO `user` (`username`, `password`, `nom`, `prenom`) VALUES (?, ?, ?, ?)";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("ssss", $username, $password, $nom, $prenom);
        return $stmt->execute();
    }

    public function updateUser($id, $username, $password, $nom, $prenom) {
        $query = "UPDATE `user` SET `username` = ?, `password` = ?, `nom` = ?, `prenom` = ? WHERE `id` = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("ssssi", $username, $password, $nom, $prenom, $id);
        return $stmt->execute();
    }

    public function deleteUser($id) {
        $query = "DELETE FROM `user` WHERE `id` = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }

    // Other methods related to users

}
?>
