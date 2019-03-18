<?php
  session_start();
  if(!isset($_SESSION["username"])) header('Location: landing.php'); //kicks user if they access home page without logging in
?>
<html>
  <head>
    <title>Maysbook</title>
    <link rel="icon" href="assets/maysbookFace.png">
    <link rel="stylesheet" href="master.css" type="text/css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
  </head>
  <body id="homePage">
    <nav>
      <img style="height:104%;" src="assets/maysbookLogo.png">
      <form style = "float:right; width:4.5%; height: 50%; margin: 1% 1%;" action="handler.php" method="post"><button type="submit" name="logOut" class="logOutButton">Logout</button></form>
    </nav>
    <section class = "sidebar">
    </section>
    <section class = "thoughtDeck">
      <form class = "thoughtPostForm" action="handler.php" method="post">
        <input class = "thoughtPostInput" type = "text" name = "thought" placeholder="Compose a thought...">
        <button class = "thoughtPostSubmit" type = "submit" name = "postThought">Post</button>
      </form>
    </section>
  </body>
</html>
