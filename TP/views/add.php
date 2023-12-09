<?php
session_start();

error_reporting(E_ERROR | E_PARSE);

if (!isset($_SESSION['uname'])) {
    header("Location: login.php");
    exit();
}

include("inc/header.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $designation = $_POST['designation'] ?? '';
    $code_categorie = $_POST['code_categorie'] ?? '';
    $prix = $_POST['prix'] ?? '';
    $qte = $_POST['qte'] ?? '';

    // Database connection
    $server = "localhost";
    $username = "root";
    $password = "";
    $database = "magasin";

    $conn = new mysqli($server, $username, $password, $database);

    if ($conn->connect_error) {
        die("Échec de la connexion : " . $conn->connect_error);
    }

    // Handle Image Upload
    $targetDir = "inc/images/";
    $targetFile = $targetDir . basename($_FILES["image"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

    // Check if image file is a actual image or fake image
    $check = getimagesize($_FILES["image"]["tmp_name"]);
    if ($check !== false) {
        $uploadOk = 1;
    } else {
        $uploadOk = 0;
    }

    // Check file size
    if ($_FILES["image"]["size"] > 500000) {
        $uploadOk = 0;
    }

    // Allow certain file formats
    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
        $uploadOk = 0;
    }

    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        echo '<script>alert("File could not be uploaded.");</script>';
    } else {
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetFile)) {
            $imagePath = basename($_FILES["image"]["name"]);

            // Insert product into database
            $sql = "INSERT INTO produit (designation, code_categorie, prix, Qte, image) VALUES (?, ?, ?, ?, ?)";

            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sidis", $designation, $code_categorie, $prix, $qte, $imagePath);

            if ($stmt->execute()) {
                echo '<script>alert("Product added successfully!");</script>';
                // Redirect immediately after processing the form
                echo '<script>window.location.replace("CrudProduits.php");</script>';
                exit;
            } else {
                echo '<script>alert("Error adding product. Please try again.");</script>';
            }
        } else {
            echo '<script>alert("There was an error uploading your file.");</script>';
        }
    }

    $conn->close();
}

// Fetch categories from database
$server = "localhost";
$username = "root";
$password = "";
$database = "magasin";

$conn = new mysqli($server, $username, $password, $database);

if ($conn->connect_error) {
    die("Échec de la connexion : " . $conn->connect_error);
}

$sql = "SELECT * FROM categorie";
$result = $conn->query($sql);
$categories = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $categories[] = $row;
    }
}

$conn->close();
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
            <div class="form-group">
                <label for="designation">Designation:</label>
                <input type="text" class="form-control" id="designation" name="designation" required>
            </div>
            <div class="form-group">
                <label for="code_categorie">Catégorie:</label>
                <select class="form-control" name="code_categorie" required>
                    <?php foreach ($categories as $category) { ?>
                        <option value="<?= $category['code']; ?>"><?= $category['nom']; ?></option>
                    <?php } ?>
                </select>
            </div>
            <div class="form-group">
                <label for="prix">Stock:</label>
                <input type="number" class="form-control" id="prix" name="prix" required>
            </div>
            <div class="form-group">
                <label for="qte">Price:</label>
                <input type="number" class="form-control" id="qte" name="qte" required>
            </div>
            <div class="form-group">
                <label for="image" class="form-label">Image</label>
                <input type="file" class="form-control" id="image" name="image" accept="image/*" required>
            </div>
            <button type="submit" class="btn btn-primary">Add Product</button>
        </form>
    </div>
</body>
</html>
<?php
include("inc/footer.php");
?>
