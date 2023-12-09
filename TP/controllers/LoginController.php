<?php
session_start();

require_once '../models/UserModel.php';

$errorMsg = '';
$username = '';
$password = '';
$rememberMe = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $userModel = new UserModel();
    $users = $userModel->getAllUsers(); 

    $inputUsername = $_POST["uname"];
    $inputPassword = $_POST["psw"];

    $credentialsMatch = false;

    foreach ($users as $user) {
        if ($user["username"] === $inputUsername && $user["password"] === $inputPassword) {
            $credentialsMatch = true;
            break;
        }
    }

    if ($credentialsMatch) {
        $_SESSION["uname"] = $inputUsername;
        $_SESSION["psw"] = $inputPassword;

        if (isset($_POST["remember"]) && $_POST["remember"] == "on") {
          $username = $inputUsername;
          $password = $inputPassword;
  
          // Set cookies to remember user credentials for 30 days
          setcookie("rememberMeUsername", $username, time() + 3600 * 24 * 30, "/");
          setcookie("rememberMePassword", $password, time() + 3600 * 24 * 30, "/");
          } else {
              // Clear cookies if "Remember me" was unchecked
              setcookie("rememberMeUsername", "", time() - 3600, "/");
              setcookie("rememberMePassword", "", time() - 3600, "/");
          }
        header("Location: crudProduits.php");
        exit;
    } else {
        $errorMsg = 'Identifiants incorrects. Veuillez réessayer.';
    }
}

include '../views/login.php';
?>
