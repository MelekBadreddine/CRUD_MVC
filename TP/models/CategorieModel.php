<?php

class CategorieModel {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function getCategorieById($id) {
        $query = "SELECT * FROM `categorie` WHERE `code` = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    public function addCategorie($nom) {
        $query = "INSERT INTO `categorie` (`nom`) VALUES (?)";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("s", $nom);
        return $stmt->execute();
    }

    public function updateCategorie($code, $nom) {
        $query = "UPDATE `categorie` SET `nom` = ? WHERE `code` = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("si", $nom, $code);
        return $stmt->execute();
    }

    public function deleteCategorie($code) {
        $query = "DELETE FROM `categorie` WHERE `code` = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("i", $code);
        return $stmt->execute();
    }

    // Other methods related to categories

}
?>
