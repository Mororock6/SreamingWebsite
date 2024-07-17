<?php
require_once("includes/classes/config.php");
require_once("includes/classes/FormSanitizer.php");
require_once("includes/classes/Account.php");
require_once("includes/classes/Constants.php");

$account= new Account($con);

    if(isset($_POST["submitButton"])){

        $email= FormSanitizer::sanitizeFormString($_POST["email"]);
        $password= FormSanitizer::sanitizeFormString($_POST["password"]);
        
        $success = $account->login($email, $password);

        if($success){
            $_SESSION["userLoggedIn"]= $email;
            header("Location: index.php");
        }
    }
function getInputValue($name){
    if(isset($_POST[$name])){
        echo $_POST[$name];
    }
}



?>
<!DOCTYPE html>

<html>
    <head>
        <title>72-LXXII</title>
        <link rel="stylesheet" type="text/css" href="assets/style/style.css"/>
    </head>
      <body> 
         <div class="signInContainer">

             <div class="column">

             <div class="header">
                <img src="assets/images/logo.png" title="Logo" alt="Site logo">
                <h3>Sign In</h3>
                <span>Welcome to 72-LXXII</span>
             </div>

              <form method="POST">
                  <?php echo $account-> getError(Constants::$loginFailed); ?>

                  <input type="email" name="email" placeholder="Email" value="<?php getInputValue("email"); ?>" required>

                  <input type="password" name="password" placeholder="Password" required>

                  <input type="submit" name="submitButton" value="Submit">

              </form>

              <a href="register.php" class="registerMessage">Sign Up here</a>

             </div>
         </div>
      </body>
     
</html>