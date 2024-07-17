<?php
require_once("includes/classes/config.php");
require_once("includes/classes/FormSanitizer.php");
require_once("includes/classes/Account.php");
require_once("includes/classes/Constants.php");

    $account= new Account($con);

    if(isset($_POST["submitButton"])){
       
        $firstName= FormSanitizer::sanitizeFormString($_POST["firstName"]);
        $lastName= FormSanitizer::sanitizeFormString($_POST["lastName"]);
        $email= FormSanitizer::sanitizeFormString($_POST["email"]);
        $password= FormSanitizer::sanitizeFormString($_POST["password"]);
        $password2= FormSanitizer::sanitizeFormString($_POST["password2"]);
        
        $success = $account->register($firstName, $lastName, $email, $password, $password2);

        if($success){
            $_SESSION["userLoggedIn"]= $username;
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
                        <h3>Sign Up</h3>
                        <span>Welcome to 72-LXXII</span>
                    </div>

                    <form method="POST">
                        <?php echo $account-> getError(Constants::$firstNameCharacters); ?>
                        <?php echo $account-> getError(Constants::$lastNameCharacters); ?>
                        <table>
                            <tr>
                                <td>
                                    <input type="text" name="firstName" placeholder="First Name" value=" <?php getInputValue("firstName"); ?>" required>
                                </td>

                                <td>
                                    <input type="text" name="lastName" placeholder="Last Name" value="<?php getInputValue("lastName"); ?>" required>
                                </td>
                            </tr>
                        </table>
                                    <?php echo $account-> getError(Constants::$emailInvalid); ?>
                                    <?php echo $account-> getError(Constants::$emailTaken); ?>

                                    <input type="email" name="email" placeholder="Email" value="<?php getInputValue("email"); ?>" required>

                                    <?php echo $account-> getError(Constants::$passwordsDontMatch); ?>
                                    <?php echo $account-> getError(Constants::$passwordLength); ?>

                                    <input type="password" name="password" placeholder="Password" required>

                                    <input type="password" name="password2" placeholder="Confirm Password" required>

                                    <input type="submit" name="submitButton" value="Submit">
                    </form>

                    <a href="login.php" class="signInMessage">Already have an account</a>

                </div>
            </div>
      </body>
</html>