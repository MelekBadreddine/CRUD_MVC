 <?php
  session_start();
  error_reporting(E_ALL);
ini_set('display_errors', 1);
ob_start();


  if (!isset($_SESSION['uname'])) {
      header("Location: login.php");
      exit();
  }
        include("inc/header.php"); ?>
<main style="width: 100%;">
<!DOCTYPE html>
<html lang="en">
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
<style>
body {
	color: #566787;
	background: #f5f5f5;
	font-family: 'Varela Round', sans-serif;
	font-size: 13px;
}
.table-responsive {
    margin: 0;
    overflow: hidden;
    width: 100%;
}
.table-wrapper {
  min-width: 1000px;
	background: #fff;
	padding: 20px 110px 20px 20px;
	border-radius: 3px;
	box-shadow: 0 1px 1px rgba(0,0,0,.05);
}
.table-wrapper .btn {
	float: right;
	color: #333;
	background-color: #fff;
	border-radius: 3px;
	border: none;
	outline: none !important;
	margin-left: 10px;
}
.table-wrapper .btn:hover {
	color: #333;
	background: #f2f2f2;
}
.table-wrapper .btn.btn-primary {
	color: #fff;
	background: #03A9F4;
}
.table-wrapper .btn.btn-primary:hover {
	background: #03a3e7;
}
.table-title .btn {		
	font-size: 13px;
	border: none;
}
.table-title .btn i {
	float: left;
	font-size: 21px;
	margin-right: 5px;
}
.table-title .btn span {
	float: left;
	margin-top: 2px;
}
.table-title {
	color: #fff;
	background: #4b5366;		
	padding: 16px 25px;
	margin: -20px -25px 10px;
	border-radius: 3px 3px 0 0;
}
.table-title h2 {
	margin: 5px 0 0;
	font-size: 24px;
}
.show-entries select.form-control {        
	width: 60px;
	margin: 0 5px;
}
.table-filter .filter-group {
	float: right;
	margin-left: 15px;
}
.table-filter input, .table-filter select {
	height: 34px;
	border-radius: 3px;
	border-color: #ddd;
	box-shadow: none;
}
.table-filter {
	padding: 5px 0 15px;
	border-bottom: 1px solid #e9e9e9;
	margin-bottom: 5px;
}
.table-filter .btn {
	height: 34px;
}
.table-filter label {
	font-weight: normal;
	margin-left: 10px;
}
.table-filter select, .table-filter input {
	display: inline-block;
	margin-left: 5px;
}
.table-filter input {
	width: 200px;
	display: inline-block;
}
.filter-group select.form-control {
	width: 110px;
}
.filter-icon {
	float: right;
	margin-top: 7px;
}
.filter-icon i {
	font-size: 18px;
	opacity: 0.7;
}	
table.table tr th, table.table tr td {
	border-color: #e9e9e9;
	padding: 12px 15px;
	vertical-align: middle;
}
table.table tr th:first-child {
	width: 60px;
}
table.table tr th:last-child {
	width: 80px;
}
table.table-striped tbody tr:nth-of-type(odd) {
	background-color: #fcfcfc;
}
table.table-striped.table-hover tbody tr:hover {
	background: #f5f5f5;
}
table.table th i {
	font-size: 13px;
	margin: 0 5px;
	cursor: pointer;
}	
table.table td a {
	font-weight: bold;
	color: #566787;
	display: inline-block;
	text-decoration: none;
}
table.table td a:hover {
	color: #2196F3;
}
table.table td a.view {        
	width: 30px;
	height: 30px;
	color: #2196F3;
	border: 2px solid;
	border-radius: 30px;
	text-align: center;
}
table.table td a.view i {
	font-size: 22px;
	margin: 2px 0 0 1px;
}   
table.table .avatar {
	border-radius: 50%;
	vertical-align: middle;
	margin-right: 10px;
}
.status {
	font-size: 30px;
	margin: 2px 2px 0 0;
	display: inline-block;
	vertical-align: middle;
	line-height: 10px;
}
.text-success {
	color: #10c469;
}
.text-info {
	color: #62c9e8;
}
.text-warning {
	color: #FFC107;
}
.text-danger {
	color: #ff5b5b;
}
.pagination {
	float: right;
	margin: 0 0 5px;
}
.pagination li a {
	border: none;
	font-size: 13px;
	min-width: 30px;
	min-height: 30px;
	color: #999;
	margin: 0 2px;
	line-height: 30px;
	border-radius: 2px !important;
	text-align: center;
	padding: 0 6px;
}
.pagination li a:hover {
	color: #666;
}	
.pagination li.active a {
	background: #03A9F4;
}
.pagination li.active a:hover {        
	background: #0397d6;
}
.pagination li.disabled i {
	color: #ccc;
}
.pagination li i {
	font-size: 16px;
	padding-top: 6px
}
.hint-text {
	float: left;
	margin-top: 10px;
	font-size: 13px;
}    
/* Adjust the position of the dropdown */
.search-container {
    position: relative;
    display: inline-block;
}

#dropdown {
    position: absolute;
    width: calc(100% - 2px); /* Adjust width as needed */
    top: 100%;
    left: 0;
    margin-top: 5px; /* Adjust margin as needed */
}

</style>
<script>
$(document).ready(function(){
	$('[data-toggle="tooltip"]').tooltip();
});
</script>
</head>
<body>
<div class="container-xl">
    <div class="table-responsive">
        <div class="table-wrapper">
            <div class="table-title">
                <div class="row">
                    <div class="col-sm-4">
                        <h2>Products <b>Details</b></h2>
                    </div>
                    <div class="col-sm-8">						
                        <a href="#" class="btn btn-primary"><i class="material-icons">&#xE863;</i> <span>Refresh List</span></a>
                        <a href="add.php" class="btn btn-secondary" style="background-color: #28a745; color: #fff;">
                          <i class="material-icons">&#xE145;</i> <span>Add a Product</span></a>
                    </div>
                </div>
            </div>
            <div class="table-filter">
        <div class="row">
            <div class="col-sm-3">
                <div class="show-entries">
                    <span>Show</span>
                    <select class="form-control">
                        <option>5</option>
                        <option>10</option>
                        <option>15</option>
                        <option>20</option>
                    </select>
                    <span>entries</span>
                </div>
            </div>
            <div class="col-sm-9">
                <button type="button" class="btn btn-primary"><i class="fa fa-search"></i></button>
                <div class="filter-group">
    <label for="search">Designation</label>
    <div class="search-container">
        <input type="text" class="form-control" id="search">
        <select id="dropdown" class="form-control" style="display: none;"></select>
    </div>
</div>

    <div class="col-sm-2">
        <span class="filter-icon"><i class="fa fa-filter"></i> Filter</span> 
    </div>
</div>
            </div>
        </div>
    </div>
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Designation</th>
                        <th>Category</th>
                        <th>Stock</th>
                        <th>Price</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                

                <?php
$server = "localhost";
$username = "root"; 
$password = ""; 
$database = "magasin"; 

$conn = new mysqli($server, $username, $password, $database);

if ($conn->connect_error) {
    die("Échec de la connexion : " . $conn->connect_error);
}

$sql = "SELECT p.*, c.nom AS categorie_nom FROM produit p
        INNER JOIN categorie c ON p.code_categorie = c.code";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $_produit = array();

    while ($row = $result->fetch_assoc()) {
        $_produit[] = $row; 
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
            <span style="display: flex; align-items: center;">
            <a href="update.php?code=<?php echo $row['code']; ?>" class="view" title="Edit" data-toggle="tooltip" style="color: #FFC107;">
            <i class="material-icons" style="color: #FFC107;">edit</i>
        </a>
                <a href="crudProduits.php?delete=<?php echo $row['code']; ?>" class="view" title="Delete" data-toggle="tooltip" style="margin-left: 10px; color:#DC3545">
                    <i class="material-icons" style="color: #DC3545;"></i>
                </a>
            </span>
        </td>
    </tr>
<?php
    }
} else {
    echo "Aucun résultat trouvé.";
}

if (isset($_GET['delete'])) {
  $codeProduitASupprimer = $_GET['delete'];

  $sql = "DELETE FROM produit WHERE code = ?"; 

  $stmt = $conn->prepare($sql);
  $stmt->bind_param("i", $codeProduitASupprimer);

  if ($stmt->execute()) {
      // Redirect back to the same page after deletion
      header("Location: ".$_SERVER['PHP_SELF']);
      exit;
  } else {
      echo "Erreur lors de la suppression du produit.";
  }
}

$conn->close();
?>


  </tbody>
            </table>
            <div class="clearfix">
                <div class="hint-text">Showing <b>5</b> out of <b>25</b> entries</div>
                <ul class="pagination">
                    <li class="page-item disabled"><a href="#">Previous</a></li>
                    <li class="page-item"><a href="#" class="page-link">1</a></li>
                    <li class="page-item"><a href="#" class="page-link">2</a></li>
                    <li class="page-item"><a href="#" class="page-link">3</a></li>
                    <li class="page-item active"><a href="#" class="page-link">4</a></li>
                    <li class="page-item"><a href="#" class="page-link">5</a></li>
                    <li class="page-item"><a href="#" class="page-link">6</a></li>
                    <li class="page-item"><a href="#" class="page-link">7</a></li>
                    <li class="page-item"><a href="#" class="page-link">Next</a></li>
                </ul>
            </div>
        </div>
    </div>  
    
</div>  
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script>
$(document).ready(function() {
    $('#search').on('input', function() {
        let searchTerm = $(this).val();
        if (searchTerm.length >= 2) {
            $.ajax({
                type: 'POST',
                url: 'search.php',
                data: { search: searchTerm },
                success: function(response) {
                    let dropdown = $('#dropdown');
                    dropdown.empty();
                    if (response.length > 0) {
                        let options = '';
                        response.forEach(function(item) {
                            options += `<option value="${item.code}">${item.designation}</option>`;
                        });
                        dropdown.append(options);
                        dropdown.show();
                    } else {
                        dropdown.hide();
                    }
                    // Filter and display products based on the search term
                    filterProducts(searchTerm);
                },
                error: function(xhr, status, error) {
                    console.error(status + ": " + error);
                }
            });
        } else {
            $('#dropdown').hide();
            // If the search term is too short or empty, display all products
            filterProducts('');
        }
    });

    // Function to filter and display products based on the search term
    function filterProducts(searchTerm) {
        $.ajax({
            type: 'POST',
            url: 'filter_products.php', // Replace with the PHP file to filter products
            data: { search: searchTerm },
            success: function(response) {
                // Update the table with the filtered products
                $('.table tbody').html(response);
            },
            error: function(xhr, status, error) {
                console.error(status + ": " + error);
            }
        });
    }
});

</script>
  
</body>
</html>
</main>
                
<?php
        include("inc/footer.php"); ?>
