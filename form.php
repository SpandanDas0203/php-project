<?php
include "config.php"
?>

<!doctype html>
<html lang="en">
  <head>
  <?php
$errorMessage="";
$successMessage="";

if(isset($_POST['btnsignup'])){
  if(isset($_POST['confirmPass'])){
    $fname=trim($_POST['fname']);
    $lname=trim($_POST['lname']);
    $email=trim($_POST['email']);
    $password=trim($_POST['password']);
    $confirmPass=trim($_POST['confirmPass']);

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
        $stmt -> bind_param("s",$email);
        $stmt -> execute();
        $result = $stmt -> get_result();
        $stmt -> close();
        if($result ->numRows>0){
            $isvalid=false;
            $errorMessage="Email.Id is already existed.";
        }
    }
    }

    //database -> insert records

    if($isValid){
        $insertSQL= "INSERT INTO users(fname, lname, email, password,confirmPass) values(?,?,?,?,?)";
        $stmt = $con->prepare($insertSQL);
        $stmt-> bind_param("sssss",$fname,$lname,$email,$password,$confirmPass);
        $stmt -> execute();
        $stmt -> close();

        $successMessage="Account created succesfully";
    }
}

?>
    <title>Contact Us</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  </head>
  <body>
    <div class="d-flex justify-content-center">
      <div class="container">
        <div class="row">
            <div class="col-md-6">
                <form action="" method="post">
                    <h1>Sign Up</h1>
                    <?php
                    if(!empty($errorMessage)){
                    ?>
                    <div class="alert alert-danger">
                        <strong>Error!</strong><?=$errorMessage?>
                    </div>
                    <?php
                    }
                    ?>
                    <?php
                    if(!empty($successMessage)){
                        ?>
                        <div class="alert alert-success">
                            <strong>Success!</strong><?= $successMessage ?>
                        </div>
                        <?php
                    }
                    ?>
                    <div class="form-group">
                        <label for="fname">First Name:</label>
                        <input type="text" class="form-control" name="fname" id="fname" required="required" maxlength="80">
                    </div>
                    <div class="form-group">
                        <label for="lname">Last Name:</label>
                        <input type="text" class="form-control" name="lname" id="lname" required="required" maxlength="80">
                    </div>
                    <div class="form-group">
                        <label for="email">Email Address:</label>
                        <input type="email" class="form-control" name="email" id="email" required="required" maxlength="80">
                    </div>
                    <table><tr><td>
                    <div class="form-group">
                        <label for="password">Enter your password:</label></td>
                       <td><input type="password" class="form-cotrol" name="password" id="password" required="required" maxlength="80"></td>
                    </div></tr>
                    <tr><td>
                        <div class="form-group">
                        <label for="pwd">Confirm your password:</label></td>
                        <td><input type="password" class="password" name="password" id="password" required="required" maxlength="80"></td>
                    </div></tr></table>
                    <button type="submit" name="btnsignup" class="btn btn-primary">Submit</button>
                </form>
            
            </div>
            
        </div>
      </div>
      </div>
  </body>
</html>
