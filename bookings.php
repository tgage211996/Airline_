<?php
session_start();

// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}

// Include config file
require_once "config.php";
 
// Define variables and initialize with empty values
$userid = $username = $DepartureCity = $Destination = $DepatureDate = "";
$userid_err = $username_err = $DepartureCity_err = $Destination_err = $DepatureDate_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){

    //validate userid
        $userid = $_SESSION["id"];

    // Validate username
        $username = $_SESSION["username"];
    
    // Validate Departure City
    if(empty(trim($_POST["departurecity"]))){
        $DepartureCity_err = "Please enter a departure city.";     
    } else{
        $DepartureCity = trim($_POST["departurecity"]);
    }

      // Validate destination
      if(empty(trim($_POST["destination"]))){
        $Destination_err = "Please enter a destination.";     
    }else{
        $Destination = trim($_POST["destination"]);
    }

    // Validate departure date
    if(empty(trim($_POST["departuredate"]))){
        $DepatureDate_err = "Please choose a departure date.";     
    }else{
        $DepatureDate = trim($_POST["departuredate"]);
    }
    

    // Check input errors before inserting in database
    if(empty($username_err) && empty($DepartureCity_err) && empty($Destination_err) && empty($DepatureDate_err)){
        
        // Prepare an insert statement
        $sql = "INSERT INTO bookings (userid, username, departurecity, destination, departuredate) VALUES (?, ?, ?, ?, ?)";
         
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "sssss", $param_userid, $param_username, $param_departurecity, $param_destination, $param_departuredate);
            
            // Set parameters
            $param_userid = $userid;
            $param_username = $username;
            $param_departurecity = $DepartureCity;
            $param_destination = $Destination;
            $param_departuredate = $DepatureDate;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Redirect to login page
                header("location: login.php");
            } else{
                echo "Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }
    
    // Close connection
    mysqli_close($link);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Booking</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <style type="text/css">
        body {
             font: 14px sans-serif;
             background-image: url("Images/david-marcu-78A265wPiO4-unsplash.jpg");
             background-size: cover; 
        }
        .wrapper{ width: 350px; padding: 20px; }
    </style>
</head>
<body>
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
              <li class="nav-item active">
                <a class="nav-link" href="welcome.php">Home <span class="sr-only">(current)</span></a>
              </li>
            </ul>
          </div>
      </nav>

    <div class="wrapper" style="background-color: grey; position: relative; left: 50px; top: 100px; border-radius: 25px;">
        <h2>Book A Flight</h2>
        <p>Please fill this form to book a flight.</p>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">

            <div class="form-group <?php echo (!empty($DepartureCity_err)) ? 'has-error' : ''; ?>">
                <label>Departure City</label>
                <input type="text" name="departurecity" class="form-control" value="<?php echo $DepartureCity; ?>">
                <span class="help-block"><?php echo $DepartureCity_err; ?></span>
            </div>

            <div class="form-group <?php echo (!empty($Destination_err)) ? 'has-error' : ''; ?>">
                <label>Destination City</label>
                <input type="text" name="destination" class="form-control" value="<?php echo $Destination; ?>">
                <span class="help-block"><?php echo $Destination_err; ?></span>
            </div>

            <div class="form-group <?php echo (!empty($DepatureDate_err)) ? 'has-error' : ''; ?>">
                <label>Departure Date</label>
                <input type="date" name="departuredate" class="form-control" value="<?php echo $DepatureDate; ?>">
                <span class="help-block"><?php echo $DepatureDate_err; ?></span>
            </div>

            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Submit">
                <input type="reset" class="btn btn-default" value="Reset">
            </div>
            <p>Do you want to cancel one of your flights? <a href="cancel.php" style="color: blue;"> Click Here</a>.</p>
        </form>
    </div>    

    <!--styling for bootstrap-->
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
</body>
</html>