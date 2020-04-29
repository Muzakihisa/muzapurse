<?php
// Initialize the session
session_start();
 
// Check if the user is already logged in, if yes then redirect him to welcome page
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    header("location: account.php");
    exit;
}
 
// Include config file
require_once "database_io.php";

// Define variables and initialize with empty values
$username = $password = "";
$username_err = $password_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Check if username is empty
    if(empty(trim($_POST["username"]))){
        $username_err = "Please enter username.";
    } else{
        $username = trim($_POST["username"]);
    }
    
    // Check if password is empty
    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter your password.";
    } else{
        $password = trim($_POST["password"]);
    }
    
    echo $username_err . $password_err;
    
    // Validate credentials
    if(empty($username_err) && empty($password_err)){
        // Prepare a select statement
        $sql = "SELECT id, username, password FROM users WHERE username = :username";
        
        if($stmt = $pdo->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            $stmt->bindParam(":username", $param_username, PDO::PARAM_STR);
            
            // Set parameters
            $param_username = trim($_POST["username"]);
            
            // Attempt to execute the prepared statement
            if($stmt->execute()){
                // Check if username exists, if yes then verify password
                if($stmt->rowCount() == 1){
                    if($row = $stmt->fetch()){
                        $id = $row["id"];
                        $username = $row["username"];
                        $hashed_password = $row["password"];
                        if(password_verify($password, $hashed_password)){
                            // Password is correct, so start a new session
                            session_start();
                            
                            // Store data in session variables
                            $_SESSION["loggedin"] = true;
                            $_SESSION["id"] = $id;
                            $_SESSION["username"] = $username;                            
                            
                            // Redirect user to welcome page
                            header("location: account.php");
                        } else{
                            // Display an error message if password is not valid
                            $password_err = "The password you entered was not valid.";
                            echo $password_err;
                        }
                    }
                } else{
                    // Display an error message if username doesn't exist
                    $username_err = "No account found with that username.";
                    echo $username_err;
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            unset($stmt);
        }
    }
    
    // Close connection
    unset($pdo);
}
?>
<?include 'common/html_head.php'?>
</head>
<body>
    <?include 'common/navbar.php'?>
    <div class="container">
        <p style="margin-top: 4em;" class="center-align"><?=$login_page_decorative_text_1?></p>
        <!--<div class="my_sheet" style="margin: auto; margin-top: 4em; max-width: 400px">
            <div class="my_inner_container">
                <form method="POST" action="login_processor.php">
                    <div class="input-field">
                        <input id="username_input_field" name="username" type="text" class="validate">
                        <label for="username_input_field">Username</label>
                    </div>
                    <div class="input-field">
                        <input id="password_input_field" name="password" type="password" class="validate">
                        <label for="password_input_field">Password</label>
                    </div>
                    
                    <button class="btn waves-effect waves-light" type="submit" name="action"><?=$login_link_text?>
                        <i class="material-icons right">send</i>
                    </button><br><br>
                    <p><?=$no_account_text?> <a href="register.php"><?=$register_link_text?></a></p>
                </form>
            </div>
        </div>-->
        
        <div class="card white" style="margin: auto; margin-top: 4em; max-width: 400px; border-radius: 6px">
        <div class="card-content grey-text text-darken-4">
          <div class="my_inner_container">
                <form method="POST" action="login.php">
                    <div class="input-field">
                        <input id="username_input_field" name="username" type="text" class="validate">
                        <label for="username_input_field">Username</label>
                    </div>
                    <div class="input-field">
                        <input id="password_input_field" name="password" type="password" class="validate">
                        <label for="password_input_field">Password</label>
                    </div>
                    
                    <button class="btn waves-effect waves-light" type="submit" name="action"><?=$login_link_text?>
                        <i class="material-icons right">send</i>
                    </button><br><br>
                    <p><?=$no_account_text?> <a href="register.php"><?=$register_link_text?></a></p>
                </form>
            </div>
      </div>
    </div>
    <?php include 'common/footer.php'?>
</body>
</html>