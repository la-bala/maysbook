<html id = landingPage>
  <head>
    <title>Maysbook</title>
    <link rel="stylesheet" href="master.css" type="text/css">
    <link rel="icon" href="assets/maysbookFace.png">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">
    <script>
      function switchToRegister(x){
        if(x===true){ //user wants to register
          document.getElementById("logInCard").style.display = "none";
          document.getElementById("logInButton").style.backgroundColor = "#cee3ff";
          document.getElementById("registerCard").style.display = "block";
          document.getElementById("registerButton").style.backgroundColor = "#afceff";
        }else{ //user wants to log in
          document.getElementById("logInCard").style.display = "block";
          document.getElementById("logInButton").style.backgroundColor = "#afceff";
          document.getElementById("registerCard").style.display = "none";
          document.getElementById("registerButton").style.backgroundColor = "#cee3ff";
        }
      }
    </script>
  </head>
  <body>
    <img id="landingLogo" src="assets/maysbookLogo.png">
    <h1 id = "slogan">The leading global social network.</h1>
    <img id="worldMap" src="assets/worldmap.png">
    <div id="landingCard">
      <div id="buttonPanel">
        <button id="logInButton" class="logInRegisterButtons" onclick="switchToRegister(false)">Log In</button>
        <button id="registerButton" class="logInRegisterButtons" onclick="switchToRegister(true)">Register</button>
      </div>
      <div id="logInCard" class="logInRegisterCard">
        <p>Already use Maysbook? Log in here.</p>
        <form action="handler.php" method="post">
          <input class = "landingForm" type="text" name="username" placeholder="Username">
          <input class = "landingForm" type="password" name="password" placeholder="Password">
          <button style = "margin-top:5%; font-family: 'Open Sans', sans-serif;" type="submit" name = "attemptLogin">Log In</button>
        </form>
        <?php
          session_start();
          if(isset($_SESSION["loginError"])){
            echo "<div id='landingError'>
                    <p>".$_SESSION["loginError"]."</p>
                  </div>";
            unset($_SESSION["loginError"]);
          }
        ?>
      </div>
      <div id="registerCard" class="logInRegisterCard">
        <p>Don't have an account? Join Maysbook.</p>
        <form action="handler.php" method="post">
          <input class = "landingForm" type="text" name="username" placeholder="Create Username">
          <input class = "landingForm" type="password" name="password" placeholder="Create Password">
          <button style = "margin-top:5%; font-family: 'Open Sans', sans-serif;" type="submit" name = "attemptRegister">Register</button>
        </form>
        <?php
          if(isset($_SESSION["registerError"])){
            echo "<script>switchToRegister(true);</script>";
            echo "<div id='landingError'>
                    <p>".$_SESSION["registerError"]."</p>
                  </div>";
            unset($_SESSION["registerError"]);
          }
        ?>
      </div>
    </div>
  </body>
</html>
