<?php
session_start();
error_reporting(E_ERROR | E_PARSE);

$server = "localhost";
$username = "root";
$password = "";
$database = "magasin";

include("inc/header.php");

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['code_produit'])) {
    $code_produit = $_POST['code_produit'];
    $designation = $_POST['designation'] ?? '';
    $code_categorie = $_POST['code_categorie'] ?? '';
    $prix = $_POST['prix'] ?? '';
    $qte = $_POST['qte'] ?? '';

    $conn = new mysqli($server, $username, $password, $database);

    if ($conn->connect_error) {
        die("Échec de la connexion : " . $conn->connect_error);
    }

    $sql = "UPDATE produit SET designation = ?, code_categorie = ?, prix = ?, Qte = ? WHERE code = ?";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("sidii", $designation, $code_categorie, $prix, $qte, $code_produit);
        if ($stmt->execute()) {
            echo '<script>alert("Product updated successfully!");</script>';
            echo '<script>window.location.replace("CrudProduits.php");</script>';
            exit;
        } else {
            echo '<script>alert("Error updating product. Please try again.");</script>';
        }
    } else {
        echo '<script>alert("Error in the prepared statement.");</script>';
    }

    $conn->close();
}

if ($_SERVER["REQUEST_METHOD"] === "GET" && isset($_GET['code'])) {
    $code_produit = $_GET['code'];

    $conn = new mysqli($server, $username, $password, $database);

    if ($conn->connect_error) {
        die("Échec de la connexion : " . $conn->connect_error);
    }

    $sql = "SELECT * FROM produit WHERE code = ?";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("i", $code_produit);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $designation = $row['designation'];
            $code_categorie = $row['code_categorie'];
            $prix = $row['prix'];
            $qte = $row['Qte'];
        } else {
            echo "Product not found";
        }
    } else {
        echo "Error in the prepared statement: " . $conn->error;
    }

    $conn->close();
}

?>


<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<title>Bootstrap Order Details Table with Search Filter</title>
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto|Varela+Round">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
</head>
<body>
    <div class="container-xl">
        <form method="post" action="" enctype="multipart/form-data">
            <input type="hidden" name="code_produit" value="<?php echo isset($code_produit) ? htmlspecialchars($code_produit) : ''; ?>">

            <!-- Form fields for updating product details -->
            <div class="form-group">
                <label for="designation">Designation:</label>
                <input type="text" class="form-control" id="designation" name="designation" value="<?php echo isset($designation) ? htmlspecialchars($designation) : ''; ?>" required>
            </div>
            <div class="form-group">
                <label for="code_categorie">Catégorie:</label>
                <input type="text" class="form-control" id="code_categorie" name="code_categorie" value="<?php echo isset($code_categorie) ? htmlspecialchars($code_categorie) : ''; ?>" required>
            </div>
            <div class="form-group">
                <label for="prix">Stock:</label>
                <input type="number" class="form-control" id="prix" name="prix" value="<?php echo isset($prix) ? htmlspecialchars($prix) : ''; ?>" required>
            </div>
            <div class="form-group">
                <label for="qte">Price:</label>
                <input type="number" class="form-control" id="qte" name="qte" value="<?php echo isset($qte) ? htmlspecialchars($qte) : ''; ?>" required>
            </div>
            <!-- Other form fields can be added here -->

            <button type="submit" class="btn btn-primary">Update Product</button>
        </form>
    </div>
</body>
</html>
<?php
include("inc/footer.php");
?>