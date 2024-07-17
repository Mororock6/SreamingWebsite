<?php
class Account {
    
    private $con;
    private $errorArray = array();

    public function __construct($con) {
        $this->con= $con;
    }

    public function register($fn,$ln,$em,$pw,$pw2){
        $this->validateFirstName($fn);
        $this->validateLastName($ln);
        $this->validateEmail($em);
        $this->validatePassword($pw, $pw2);

        if(empty($this->errorArray)){
            return $this->insertUserDetails($fn,$ln,$em,$pw);
        }

        return false;
    }

    public function login($em, $pw){
        $pw = hash("sha512", $pw);

        $query = $this->con->prepare("SELECT * FROM users WHERE email=:em AND password=:pw");
        $query->bindValue(":em", $em);
        $query->bindValue(":pw", $pw);

        $query->execute();

        if($query->rowCount() == 1){
            return true;
        }

        array_push($this->errorArray, Constants::$loginFailed);
        return false;
    }

    private function insertUserDetails($fn,$ln,$em,$pw){
        $pw = hash("sha512", $pw);

        $query = $this->con->prepare("INSERT INTO users (firstName, lastName, email, password)
                                      Values (:fn, :ln, :em, :pw)");
        $query->bindValue(":fn", $fn);
        $query->bindValue(":ln", $ln);
        $query->bindValue(":em", $em);
        $query->bindValue(":pw", $pw);

        return $query->execute();
    }

    private function validateFirstName($fn) {
        if(strlen($fn)< 2 || strlen($fn)> 25){
            array_push($this->errorArray, Constants::$firstNameCharacters);
        }
    }

    private function validateLastName($ln) {
        if(strlen($ln)< 2 || strlen($ln)> 25){
            array_push($this->errorArray, Constants::$lastNameCharacters);
        }
    }

    private function validateEmail($em) {
        if(!filter_var($em, FILTER_VALIDATE_EMAIL)){
            array_push($this->errorArray, Constants::$emailInvalid);
            return;
        }

        $query = $this->con->prepare("SELECT * FROM users WHERE email=:em");
        $query->bindValue(":em", $em);

        $query->execute();

        if($query->rowCount() != 0){
            array_push($this->errorArray, Constants::$emailTaken);
        }
    }

    private function validatePassword($pw, $pw2){
        if($pw != $pw2){
            array_push($this->errorArray, Constants::$passwordsDontMatch);
            return;
        }
        if(strlen($pw)< 8 || strlen($pw)> 100){
            array_push($this->errorArray, Constants::$passwordLength);
        }
    }

    public function getError($error) {
        if(in_array($error, $this->errorArray)){
            return "<span class='errorMessage'>$error</span>";
        }
    }
}

?>