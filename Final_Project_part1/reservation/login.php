<?php require_once('../db/db.php') ?>
<?php
function login($email, $password) {
    $pdo = establishCONN();

    $stmt = $pdo->prepare("SELECT * FROM users  WHERE email LIKE :email");
    $stmt->bindValue(':email', $email);
    $stmt->execute();

    $res = $stmt->fetch(PDO::FETCH_ASSOC);

    $h_pwd = $res['password'];

    return [
        'isLogged' => password_verify($password, $h_pwd),
        'userObject' => $res
    ];
}

if($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $pwd = $_POST['pwd'];

    $loged = login($email, $pwd);
    if($loged['isLogged']) {
        session_start();
        $_SESSION['id'] = $loged['userObject']['id'];
        $_SESSION['email'] = $loged['userObject']['email'];
    }
    header('Location: ./index.php');
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

    <title>login</title>
  </head>
  <body>
        <form class="add-form" method="POST" enctype="multipart/form-data">
            <h1 style="text-align: center">Login</h1>
            <hr>
            <div class="form-group">
                <label for="exampleInputEmail1">Email</label>
                <input type="email" class="form-control" name="email" aria-describedby="emailHelp" placeholder="email@domain.com">
            </div>
            <div class="form-group">
                <label for="exampleInputEmail1">Password</label>
                <input type="password" class="form-control" name="pwd" aria-describedby="emailHelp">
            </div>                
            <button type="submit" class="btn btn-primary btn-block">Login</button>
            <small>Dont have an account? <a href="./register.php">Sign up</a></small>
        </form>
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous"></script>
  </body>
</html>