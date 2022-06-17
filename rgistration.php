<?php
$errorMessage="";
$successMessage="";

if(isset($_POST['btnsignup'])){
    $fname=trim($_POST['fname']);
    $lname=trim($_POST['lname']);
    $email=trim($POST['email']);
    $password=trim($_POST['password']);
    $confirmPass=trim($_POST['confirmpassword']);

    $isValid=true;

    //checking if fields are empty or not
    if($fname==''|| $lname==''|| $email=''||$password==''||$confirmPass==''){
        $isValid=false;
        $errorMessage="Please fill all fields";
    }

    // checking if pasword is matching wit confirm password
    if($isValid && ($password != $confirmPass)){
        $isValid =false;
        $errorMessage="Confirm Password is not matching";
    }

    //checking valid email id
    if($isValid && !filter_var($email,FILTER_VALIDATE_EMAIL)){
        $isValid= false;
        $errorMessage="Invalid Email-id";
    }
    //checking if already email exists
    if($isValid){
        $stmt =$con -> prepare("SELECT* FROM users WHERE email=?");
        $stmt -> bindParam("s",$email);
        $stmt -> execute();
        $result = $stmt -> getRsult();
        $stmt -> close();
        if($result ->numRows>0){
            $isvalid=false;
            $errorMessage="Email.Id is already existed.";
        }
    }

    //database -> insert records

    if($isValid){
        $insertSQL= "INSERT INTO users(fname, lname, email, password) values(?,?,?,?)";
        $stmt = $con->prepare($insertSQL);
        $stmt-> bindParam("ssss",$fname,$lname,$email,$password);
        $stmt -> execute();
        $stmt -> close();

        $successMessage="Account creted succesfully";
    }
}

?>