

<?php 
require_once 'database_io.php';

// Define variables and initialize with empty values
$username = $password = $confirm_password = "";
$username_err = $password_err = $confirm_password_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Validate username
    if(empty(trim($_POST["username"]))){
        $username_err = "Please enter a username.";
    } else{
        // Prepare a select statement
        $sql = "SELECT id FROM users WHERE username = :username";
        
        if($stmt = $pdo->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            $stmt->bindParam(":username", $param_username, PDO::PARAM_STR);
            
            // Set parameters
            $param_username = trim($_POST["username"]);
            
            // Attempt to execute the prepared statement
            if($stmt->execute()){
                if($stmt->rowCount() == 1){
                    $username_err = "This username is already taken.";
                } else{
                    $username = trim($_POST["username"]);
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            unset($stmt);
        }
    }
    
    // Validate password
    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter a password.";     
    } elseif(strlen(trim($_POST["password"])) < 1){
        $password_err = "Password must have atleast 1 characters.";
    } else{
        $password = trim($_POST["password"]);
    }
    
    // Validate confirm password
    if(empty(trim($_POST["password_again"]))){
        $confirm_password_err = "Please confirm password.";     
    } else{
        $confirm_password = trim($_POST["password_again"]);
        if(empty($password_err) && ($password != $confirm_password)){
            $confirm_password_err = "Password did not match.";
        }
    }

    // Check input errors before inserting in database
    if(empty($username_err) && empty($password_err) && empty($confirm_password_err)){
        
        // Prepare an insert statement
        $sql = "INSERT INTO users (username, password, saldo) VALUES (:username, :password, 0)";
         
        if($stmt = $pdo->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            $stmt->bindParam(":username", $param_username, PDO::PARAM_STR);
            $stmt->bindParam(":password", $param_password, PDO::PARAM_STR);
            
            // Set parameters
            $param_username = $username;
            $param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash
            
            // Attempt to execute the prepared statement
            if($stmt->execute()){
                // Redirect to login page
                header("location: login.php");
            } else{
                echo "Something went wrong. Please try again later.";
            }

            // Close statement
            unset($stmt);
        }
    }
    
    else echo $username_err . $password_err . $confirm_password_err;
    
    // Close connection
    unset($pdo);
}

include 'common/html_head.php';
?>

</head>
<body>
    <?include 'common/navbar.php'?>
    <div class="container">
        <p style="margin-top: 4em;" class="center-align"><?=$register_page_decorative_text_1?></p>
        
        <div class="card white" style="margin: auto; margin-top: 4em; max-width: 400px; border-radius: 6px">
        <div class="card-content grey-text text-darken-4">
          <div class="my_inner_container">
                <form method="POST" action="register.php">
                    <div class="input-field">
                        <input id="username_input_field" name="username" type="text" class="validate">
                        <label for="username_input_field">Username</label>
                    </div>
                    <div class="input-field">
                        <input id="password_input_field" name="password" type="password" class="validate">
                        <label for="password_input_field">Password</label>
                    </div>
                    
                    <div class="input-field">
                        <input id="password_again_input_field" name="password_again" type="password" class="validate">
                        <label for="password_again_input_field">Confirm Password</label>
                    </div>
                    
                    <button class="btn waves-effect waves-light" type="submit" name="action"><?=$register_link_text?>
                        <i class="material-icons right">send</i>
                    </button>
                </form><br><br>
                <p><?=$register_agreement_text?></p><br>
                <p><?=$have_account_text?> <a href="login.php"><?=$login_link_text?></a></p>
            </div>
      </div>
    </div>
    </div>
    <?php include 'common/footer.php'?>
</body>
</html>