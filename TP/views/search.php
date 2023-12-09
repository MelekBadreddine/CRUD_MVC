<?php
// Establish your database connection (You should replace these variables with your actual database credentials)
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "magasin";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch the search term from the AJAX POST request
$searchTerm = $_POST['search'] ?? '';

// Prepare the SQL statement to search for designations in the 'produit' table
$sql = "SELECT code, designation FROM produit WHERE designation LIKE ?";

// Prepare and bind the parameter to avoid SQL injection
$stmt = $conn->prepare($sql);
if ($stmt) {
    $searchWildcard = '%' . $searchTerm . '%';
    $stmt->bind_param("s", $searchWildcard);
    $stmt->execute();

    $result = $stmt->get_result();
    $data = array();

    // Fetch results and store in an array
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }

    // Send JSON response
    header('Content-Type: application/json');
    echo json_encode($data);

    $stmt->close();
} else {
    echo "Error in the SQL query: " . $conn->error;
}

$conn->close();
?>
