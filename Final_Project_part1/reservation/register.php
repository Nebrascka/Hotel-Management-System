<?php require_once('../db/db.php') ?>
<?php

function addUser($fname, $lname, $id, $email, $mobile, $pwd) {
    $pdo = establishCONN();

    $stmt = $pdo->prepare("INSERT INTO users (fname, lname, idNumber, email, mobile, password) VALUES (:fname, :lname, :id, :email, :mobile, :pwd)" );
    $stmt->bindValue(':fname', $fname);
    $stmt->bindValue(':lname', $lname);
    $stmt->bindValue(':id', $id);
    $stmt->bindValue(':email', $email);
    $stmt->bindValue(':mobile', $mobile);
    $stmt->bindValue(':pwd', $pwd);

    $stmt->execute();
}

if($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $dnum = $_POST['dnum'];
    $email = $_POST['email'];
    $mobile = $_POST['mobile'];
    $pwd = password_hash($_POST['pwd'], PASSWORD_DEFAULT);

    addUser($fname, $lname, $dnum, $email, $mobile, $pwd);
    header('location: ./login.php');
}


?>

<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">

    <title>register</title>
  </head>
  <body>
        <form class="add-form" method="POST" enctype="multipart/form-data">
            <h1 style="text-align: center">Register with us</h1>
            <hr>
            <div class="row">
                <div class="col">
                    <div class="form-group">
                        <label for="exampleInputEmail1">First name</label>
                        <input type="text" class="form-control" name="fname" aria-describedby="emailHelp" placeholder="John">
                    </div>
                </div>
                <div class="col">
                    <div class="form-group">
                        <label for="exampleInputEmail1">Last name</label>
                        <input type="text" class="form-control" name="lname" aria-describedby="emailHelp" placeholder="Doe">
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label for="exampleInputEmail1">ID/Passport number</label>
                <input type="text" class="form-control" name="dnum" aria-describedby="emailHelp" placeholder="document number">
            </div>
            <div class="form-group">
                <label for="exampleInputEmail1">Email</label>
                <input type="email" class="form-control" name="email" aria-describedby="emailHelp" placeholder="email@domain.com">
            </div>
            <div class="form-group">
                <label for="exampleInputEmail1">Mobile no.</label>
                <input type="tel" class="form-control" name="mobile" aria-describedby="emailHelp" placeholder="07xxxxxxxx">
            </div>
            <div class="row">
                <div class="col">
                    <div class="form-group">
                        <label for="exampleInputEmail1">Password</label>
                        <input type="password" class="form-control" name="pwd" aria-describedby="emailHelp">
                    </div>
                </div>
                <div class="col">
                    <div class="form-group">
                        <label for="exampleInputEmail1">Confirm password</label>
                        <input type="password" class="form-control" name="cpwd" aria-describedby="emailHelp">
                    </div>
                </div>
            </div>
            <button type="submit" class="btn btn-primary btn-block">Sign up</button>
            <small>Already have an account? <a href="./login.php">Login</a></small>
        </form>
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous"></script>
  </body>
</html>