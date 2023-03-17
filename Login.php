<?php
session_start();
require_once('config.php');

if (isset($_POST['login'])) {
  $email = $_POST['email'];
  $password = $_POST['password'];
  $stmt = $conn->prepare("SELECT * FROM users WHERE email=?");
  $stmt->bind_param("s", $email);
  $stmt->execute();
  $result = $stmt->get_result();
  if ($result->num_rows == 1) {
    $row = $result->fetch_assoc();
    if (password_verify($password, $row['password'])) {
      $_SESSION['loggedin'] = true;
      $_SESSION['username'] = $row['username'];
      header('Location: index.php');
    } else {
      echo '<script>alert("Mot de passe incorrect");window.location.href="login.html";</script>';
    }
  } else {
    echo '<script>alert("Email incorrect ou compte inexistant");window.location.href="login.html";</script>';
  }
}
?>

