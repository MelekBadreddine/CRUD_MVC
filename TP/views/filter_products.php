<?php
$server = "localhost";
$username = "root"; 
$password = ""; 
$database = "magasin";

$conn = new mysqli($server, $username, $password, $database);

if ($conn->connect_error) {
    die("Échec de la connexion : " . $conn->connect_error);
}

$searchTerm = $_POST['search'] ?? '';

$sql = "SELECT p.*, c.nom AS categorie_nom FROM produit p
        INNER JOIN categorie c ON p.code_categorie = c.code
        WHERE p.designation LIKE '%$searchTerm%'";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
?>
    <tr>
        <td><?php echo $row["code"]; ?></td>
        <td>
            <a href="#">
                <img src="inc/images/<?php echo $row["image"]; ?>" style="width: 40px; height: 40px;" alt="Avatar">
                <?php echo $row["designation"]; ?>
            </a>
        </td>
        <td><?php echo $row["categorie_nom"]; ?></td>
        <td><?php echo $row["prix"]; ?></td>
        <td><?php echo $row["Qte"]; ?></td>
        <td>
        </td>
    </tr>
<?php
    }
} else {
    echo "Aucun résultat trouvé.";
}

$conn->close();
?>
