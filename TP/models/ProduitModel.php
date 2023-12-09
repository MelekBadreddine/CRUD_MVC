<?php

class ProduitModel {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function getProduitById($id) {
      $query = "SELECT * FROM `produit` WHERE `code` = ?";
      $stmt = $this->db->prepare($query);
      $stmt->bind_param("i", $id);
      $stmt->execute();
      $result = $stmt->get_result();
      return $result->fetch_assoc();
    }

    public function addProduit($designation, $prix, $qte, $image, $code_categorie) {
      $query = "INSERT INTO `produit` (`designation`, `prix`, `Qte`, `image`, `code_categorie`) VALUES (?, ?, ?, ?, ?)";
      $stmt = $this->db->prepare($query);
      $stmt->bind_param("sdisi", $designation, $prix, $qte, $image, $code_categorie);
      return $stmt->execute();
    }
  
    public function updateProduct($code, $designation, $prix, $qte) {
        $query = "UPDATE `produit` SET `designation` = ?, `prix` = ?, `Qte` = ? WHERE `code` = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("sidi", $designation, $prix, $qte, $code);
        return $stmt->execute();
    }

    public function deleteProduct($code) {
        $query = "DELETE FROM `produit` WHERE `code` = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("i", $code);
        return $stmt->execute();
    }

    // ... Autres méthodes existantes ...

}
?>
