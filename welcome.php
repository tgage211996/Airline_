<?php
// Initialize the session
session_start();
 
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}
?>
 
 <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Pegasus</title>
    <link rel="stylesheet" href="pegasus.css" >
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
</head>
<body style="background-color: #343a40;">
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo03" aria-controls="navbarTogglerDemo03" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <img src="Images\stickers-pegasus-logo-vector.jpg.jpg" alt="" style="width: 70px; height: 70px; border-radius: 35%; margin-right: 10px;">
        <div class="dropdown">
            <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <?php echo htmlspecialchars($_SESSION["username"]); ?>
            </button>
            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
              <a class="dropdown-item" href="bookings.php">Bookings</a>
              <a class="dropdown-item" href="logout.php">Logout</a>
            </div>
        </div>
        <div class="collapse navbar-collapse" id="navbarTogglerDemo02">
            <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
            </ul>
        </div>
      </nav>
      <div class= "welcomeGraphic">
      </div>
      <div style="background-color: #343a40;">
        <h3 id="header_w" style="size: Large; text-align: center; padding-top: 10px; color: white;">Your Bookings</h3>
        <hr style=" border: 1px solid black;">
      </div>

      
      <div class="row2" style="padding-left: 0px; padding-right: 0px; background-color: #343a40; overflow:hidden;">
      <?php
                  $servername = "localhost";
                  $username = "root";
                  $password = "";
                  $dbname = "demotravel";

                  // Create connection
                  $conn = new mysqli($servername, $username, $password, $dbname);

                  $sql = "SELECT Booking_num, username, departurecity, destination, departuredate FROM bookings WHERE username = '{$_SESSION['username']}'";
                  $result = $conn->query($sql);
                  $number = $result->num_rows;

                  


                  if ($number > 0)
                  {
                  // output data of each row
                  while($row = $result->fetch_assoc())
                    {
                      
                      ?>
                      
                      <div class="column">
                          <div class="card" style="background-color:beige;">
                            <p style="color: black; text-align: left;"> <?= "Booking Number:  	&nbsp	&nbsp;   ". $row["Booking_num"]. "<br>" ."Departure City:  	&nbsp	&nbsp;   ". $row["departurecity"]. "<br>" . "Destination: &nbsp	&nbsp;" . $row["destination"] . "<br>" . "Departure Date: &nbsp	&nbsp; ". $row["departuredate"] . "<br>";?></p>
                          </div>
                          <br>
                      </div>
                     
                      <?php 
                    }
                    $number - 1;

                  }else {
                    ?>
                    <script type="text/JavaScript">
                    document.getElementById("header_w").innerHTML = "No Bookings"; 
                    </script> 
                    <?php
                  }
                  $conn->close();
                  ?>
      </div>


                
      

    <!--styling for bootstrap-->
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
</body>
</html>