<?php
    function clean($string){
        return htmlentities($string);
    }
    function redirect($location){
        return header("Location:{$location}");
    }
    function set_message($message) {
        if(!empty($message)){
            $_SESSION['message'] = $message;
        }else{
            $message = "";
        }
    }
    function display_message(){
        if(isset($_SESSION['message'])){
            echo $_SESSION['message'];
            unset($_SESSION['message']);
        }
    }
    //token generator
    function token_generator(){
        $token = $_SESSION['token'] = md5(uniqid(mt_rand(), true));
        return $token;
    }

    /*****Validation Functions *********/
    function validation_errors($error_message){
        $error_message = <<<DELIMITER
                <div class="alert alert-danger alert-dismissable" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times</span></button>
                    <strong>Warning!</strong> $error_message
                </div>
                DELIMITER;
                return $error_message;
    }

    // determining if email address is already registered
    function email_exists($email){
        $sql = "SELECT id FROM users WHERE email = '$email'";
        $result = query($sql);
        if(row_count($result) == 1){
            return true;
        }else{
            return false;
        }
    }

    // determining if username already exists
    function username_exists($username){
        $sql = "SELECT id FROM users WHERE username = '$username'";
        $result = query($sql);
        if(row_count($result) == 1){
            return true;
        }else{
            return false;
        }
    }

    function validate_user_registration(){
        $first_name = clean($_POST['first_name']);
        $last_name = clean($_POST['last_name']);
        $username = clean($_POST['username']);
        $email = clean($_POST['email']);
        $password = clean($_POST['password']);
        $confirm_password = clean($_POST['confirm_password']);

        $min = 3;
        $max = 20;
        if(strlen($first_name)<$min && strlen($first_name) != 0){
            $errors[]= "Your first name cannot be less than {$min} characters";
        }
        if(strlen($last_name)<$min && strlen($last_name) != 0){
            $errors[] = "Your last name cannot be less than {$min} characters";
        }
        if(strlen($username)<$min && strlen($username) != 0){
            $errors[] = "Your username cannot be less than {$min} characters";
        }
        if(strlen($first_name)>$max){
            $errors[] = "Your first name cannot be more than {$max} characters";
        }
        if(strlen($last_name)>$max){
            $errors[] = "Your last name cannot be more than {$max} characters";
        }
        if(strlen($username)>$max){
            $errors[] = "Your user name cannot be more than {$max} characters";
        }
        if(email_exists($email)){
            $errors[] = "Sorry, that email is already registered";
        }
        if(username_exists($username)){
            $errors[] = "Sorry, that username already exists";
        }
        if($password !== $confirm_password){
            $errors[] = "Your passwords do not match";
        }
        // In this section I did not feel it was necessary to validate the length of the email 
        // to not be more than $max characters as shown in the lecture. In my opinion the 
        // average user would never take a restriction like this into consideration when they
        // create an email account, and this restriction would place an undue burden on the customer 
        // to create a new email account to register.


        if(!empty($errors)){
            foreach($errors as $error){
                echo validation_errors($error);
            }
        }
    }
?>