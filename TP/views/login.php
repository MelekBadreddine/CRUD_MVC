<?php
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

$server = "localhost";
$username = "";
$password = "";
$rememberMe = "";
$database = "magasin";

if (isset($_COOKIE["rememberMeUsername"]) && isset($_COOKIE["rememberMePassword"]) && isset($_COOKIE["rememberMeToken"])) {
    $username = $_COOKIE["rememberMeUsername"];
    $password = $_COOKIE["rememberMePassword"];
    $rememberMe = "checked";
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $conn = new mysqli($server, "root", "", $database);

    if ($conn->connect_error) {
        die("Échec de la connexion : " . $conn->connect_error);
    }

    $sql = "SELECT * FROM user";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $_users = array();

        while ($row = $result->fetch_assoc()) {
            $_users[] = $row;
        }

        $inputUsername = $_POST["uname"];
        $inputPassword = $_POST["psw"];

        $credentialsMatch = false;

        foreach ($_users as $user) {
            if ($user["username"] === $inputUsername && $user["password"] === $inputPassword) {
                $credentialsMatch = true;
                break;
            }
        }

        if ($credentialsMatch) {
            $_SESSION["uname"] = $inputUsername;
            $_SESSION["psw"] = $inputPassword;

            if (isset($_POST["remember"]) && $_POST["remember"] == "on") {
                $token = bin2hex(random_bytes(32));
                setcookie("rememberMeUsername", $inputUsername, time() + 3600 * 24 * 30);
                setcookie("rememberMePassword", $inputPassword, time() + 3600 * 24 * 30);
                setcookie("rememberMeToken", $token, time() + 3600 * 24 * 30);
            } else {
                if (isset($_COOKIE["rememberMeUsername"]) && isset($_COOKIE["rememberMeToken"])) {
                    setcookie("rememberMeUsername", "", time() - 3600);
                    setcookie("rememberMePassword", "", time() - 3600);
                    setcookie("rememberMeToken", "", time() - 3600);
                }
            }
            header("Location: crudProduits.php");
            exit;
        } else {
            echo '<div class="alert alert-danger" role="alert">Identifiants incorrects. Veuillez réessayer.</div>';
        }
    } else {
        echo "Aucun résultat trouvé.";
    }

    $conn->close();
}

include("inc/header.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login</title>
  <style>
    /* Bordered form */
form {
  border: 3px solid #f1f1f1;
}

/* Full-width inputs */
input[type=text], input[type=password] {
  width: 100%;
  padding: 12px 20px;
  margin: 8px 0;
  display: inline-block;
  border: 1px solid #ccc;
  box-sizing: border-box;
}

/* Set a style for all buttons */
button {
  background-color: #04AA6D;
  color: white;
  padding: 14px 20px;
  margin: 8px 0;
  border: none;
  cursor: pointer;
  width: 100%;
}

/* Add a hover effect for buttons */
button:hover {
  opacity: 0.8;
}

/* Extra style for the cancel button (red) */
.cancelbtn {
  width: auto;
  padding: 10px 18px;
  background-color: #f44336;
}

/* Center the avatar image inside this container */
.imgcontainer {
  text-align: center;
  margin: 24px 0 12px 0;
}

/* Avatar image */
img.avatar {
  width: 40%;
  border-radius: 50%;
}

/* Add padding to containers */
.container {
  padding: 16px;
}

/* The "Forgot password" text */
span.psw {
  float: right;
  padding-top: 16px;
}

/* Change styles for span and cancel button on extra small screens */
@media screen and (max-width: 300px) {
  span.psw {
    display: block;
    float: none;
  }
  .cancelbtn {
    width: 100%;
  }
}
</style>
<script>
  <!-- Button to open the modal login form -->
<button onclick="document.getElementById('id01').style.display='block'">Login</button>

<!-- The Modal -->
<div id="id01" class="modal">
  <span onclick="document.getElementById('id01').style.display='none'"
class="close" title="Close Modal">&times;</span>

  <!-- Modal Content -->
  <form class="modal-content animate" action="/action_page.php">
    <div class="imgcontainer">
      <img src="img_avatar2.png" alt="Avatar" class="avatar">
    </div>

    <div class="container">
      <label for="uname"><b>Username</b></label>
      <input type="text" class="form-control" id="uname" placeholder="Enter Username" name="uname" value="<?php echo $username; ?>" required>

      <label for="psw"><b>Password</b></label>
      <input type="password" id="uname" placeholder="Enter Password" name="psw" required>

      <button type="submit">Login</button>
      <label>
        <input type="checkbox" checked="checked" name="remember"> Remember me
      </label>
    </div>

    <div class="container" style="background-color:#f1f1f1">
      <button type="button" onclick="document.getElementById('id01').style.display='none'" class="cancelbtn">Cancel</button>
      <span class="psw">Forgot <a href="#">password?</a></span>
    </div>
  </form>
</div>
Step 2) Add CSS:
Example
/* The Modal (background) */
.modal {
  display: none; /* Hidden by default */
  position: fixed; /* Stay in place */
  z-index: 1; /* Sit on top */
  left: 0;
  top: 0;
  width: 100%; /* Full width */
  height: 100%; /* Full height */
  overflow: auto; /* Enable scroll if needed */
  background-color: rgb(0,0,0); /* Fallback color */
  background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
  padding-top: 60px;
}

/* Modal Content/Box */
.modal-content {
  background-color: #fefefe;
  margin: 5px auto; /* 15% from the top and centered */
  border: 1px solid #888;
  width: 80%; /* Could be more or less, depending on screen size */
}

/* The Close Button */
.close {
  /* Position it in the top right corner outside of the modal */
  position: absolute;
  right: 25px;
  top: 0;
  color: #000;
  font-size: 35px;
  font-weight: bold;
}

/* Close button on hover */
.close:hover,
.close:focus {
  color: red;
  cursor: pointer;
}

/* Add Zoom Animation */
.animate {
  -webkit-animation: animatezoom 0.6s;
  animation: animatezoom 0.6s
}

@-webkit-keyframes animatezoom {
  from {-webkit-transform: scale(0)}
  to {-webkit-transform: scale(1)}
}

@keyframes animatezoom {
  from {transform: scale(0)}
  to {transform: scale(1)}
}
</script>
</head>
<body>
<form action="login.php" method="post">
  <div class="imgcontainer">
    <img src="inc/images/avatar.png" style="width: 50px; height: 50px;" alt="Avatar" class="avatar">
  </div>

  <div class="container">
    <label for="uname"><b>Username</b></label>
    <input type="text" id="uname" placeholder="Enter Username" name="uname" value="<?php echo $username; ?>" required>

    <label for="psw"><b>Password</b></label>
    <input type="password" id="psw" placeholder="Enter Password" name="psw" value="<?php echo $password; ?>" required>
    <?php if (!empty($errorMsg)) : ?>
            <div class="alert alert-danger" role="alert">
                <?php echo $errorMsg; ?>
            </div>
        <?php endif; ?>
    <button type="submit">Login</button>
    <label>
      <input type="checkbox" name="remember" id="remember"> Remember me
    </label>
  </div>
  <div class="container" style="background-color:#f1f1f1">
    <button type="button" class="cancelbtn">Cancel</button>
    <span class="psw">Forgot <a href="#">password?</a></span>
  </div>
</form>
</body>
</html>