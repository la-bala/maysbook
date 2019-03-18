<?php
$server = "localhost";
$user = "root";
$pass = "usbw";
$db = "maysbook";
$conn = new mysqli($server, $user, $pass, $db);
if($conn->connect_error){
  die("Connection Failed: " . $conn->connect_error);
}
session_start();
if(isset($_POST["attemptRegister"])){
  $MAX_LENGTH = 20;
  $MIN_LENGTH = 3;
  $error = "Registration failed.";
  $BASE_ERROR_LENGTH = strlen($error);
  $username = htmlentities($_POST["username"]);
  $password = htmlentities($_POST["password"]);
  if(strlen($username)>$MAX_LENGTH||strlen($password)>$MAX_LENGTH) $error = $error." Username and password cannot be longer than ".$MAX_LENGTH." characters.";
  if(strlen($username)<$MIN_LENGTH||strlen($password)<$MIN_LENGTH) $error = $error." Username and password cannot be shorter than ".$MIN_LENGTH." characters.";
  if(!preg_match("/^[a-zA-Z0-9_\-]+$/", $username) || !preg_match("/^[a-zA-Z0-9_\-]+$/", $password)) $error = $error." Only alphanumeric characters, hyphens, and underscores are permitted.";
  $checkDuplicateSQL = $conn->prepare("SELECT count(username) FROM users WHERE username = ?");
  $checkDuplicateSQL->bind_param("s", $username);
  $checkDuplicateSQL->execute();
  $checkDuplicateSQL->bind_result($duplicates);
  $checkDuplicateSQL->fetch();
  if($duplicates>0) $error = $error." Username is already taken!";
  $checkDuplicateSQL->close();
  $conn->close();
  $conn = new mysqli($server, $user, $pass, $db);
  if($conn->connect_error){die("Connection Failed: " . $conn->connect_error);}

  if(strlen($error)>$BASE_ERROR_LENGTH){ //fail, kick and display error on the landing page
    $_SESSION["registerError"] = $error;
    header('Location: landing.php');
  }
  else{ //success, store registration information in database
    $registerSQL = $conn->prepare("INSERT INTO users (username, password) VALUES (?,?)");
    $registerSQL->bind_param("ss", $username, $password);
    $registerSQL->execute();
    $registerSQL->close();
    $conn->close();
    $_SESSION["username"]=$username;
    header('Location: home.php');
  }
}
else if(isset($_POST["attemptLogin"])){
  $username = htmlentities($_POST["username"]);
  $password = htmlentities($_POST["password"]);
  $loginSQL = $conn->prepare("SELECT username,password FROM users WHERE username = ? AND password = ?");
  $loginSQL->bind_param("ss", $username, $password);
  $loginSQL->execute();
  $loginSQL->bind_result($selectedUsername,$selectedPassword);
  $loginSQL->fetch();
  $loginSQL->close();
  $conn->close();
  if($selectedUsername === $username && $selectedPassword === $password){ //login successful
    $_SESSION["username"] = $username;
    header('Location: home.php');
  }
  else{ //login unsuccessful
    $_SESSION["loginError"] = "Incorrect username or password.";
    header('Location: landing.php');
  }
}
else if(isset($_POST["postThought"])){
  $thought = htmlentities($_POST["thought"]);
  $username = $_SESSION["username"];
  $getAuthorIdSQL = $conn->prepare("SELECT id FROM users WHERE username = ?");
  $getAuthorIdSQL->bind_param("s",$username);
  $getAuthorIdSQL->execute();
  $getAuthorIdSQL->bind_result($authorId);
  $getAuthorIdSQL->fetch();
  $getAuthorIdSQL->close();
  $conn->close();
  $conn = new mysqli($server, $user, $pass, $db);
  if($conn->connect_error){die("Connection Failed: " . $conn->connect_error);}
  $postThoughtSQL = $conn->prepare("INSERT INTO tweet (authorId,content) VALUES (?,?)");
  $postThoughtSQL->bind_param("is",$authorId,$thought);
  $postThoughtSQL->execute();
  $postThoughtSQL->close();
  $conn->close();
  header('Location: home.php');
}
else if(isset($_POST["logOut"])){
  unset($_SESSION["username"]);
  header('Location: landing.php');
}
else{ //kicks user if they try to access landing.php from url
  header('Location: landing.php');
}
?>
