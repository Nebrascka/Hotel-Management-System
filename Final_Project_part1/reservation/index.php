<?php
session_start();

if(!isset($_SESSION['id'])) {
    header('location: ./login.php');
}
?>

<?php require_once('../db/db.php') ?>
<?php
function addReq($creator, $checkin, $checkout, $adults, $children, $suite) {
    $pdo = establishCONN();

    $stmt = $pdo->prepare("INSERT INTO applications (created_by, checkin, checkout, adults, children, suite) VALUES (:creator, :checkin, :checkout, :adults, :children, :suite)" );
    $stmt->bindValue(':creator', $creator);
    $stmt->bindValue(':checkin', $checkin);
    $stmt->bindValue(':checkout', $checkout);
    $stmt->bindValue(':adults', $adults);
    $stmt->bindValue(':children', $children);
    $stmt->bindValue(':suite', $suite);

    $stmt->execute();
}

function getCategories(){
    $pdo = establishCONN();

    $stmt = $pdo->prepare("SELECT * FROM categories");
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

if($_SERVER['REQUEST_METHOD'] === 'POST') {
    $creator = $_SESSION['id'];
    $in = $_POST['in'];
    $out = $_POST['out'];
    $adults = $_POST['adults'];
    $children = $_POST['children'];
    $suite = $_POST['suite'];

    addReq($creator, $in, $out, $adults, $children, $suite);
    // header('Location: ./dashboard.php');
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

    <title>Reservation</title>
  </head>
  <body>
    <div class="container" style="padding: 1rem">
        <a href="./logout.php" style="text-align-center color: #000;">Logout</a>
    </div>
    <form class="add-form" method="POST" enctype="multipart/form-data">
        <h1 style="text-align: center">Book a room</h1>
        <hr>
        <div class="form-group">
            <label for="exampleInputEmail1">Category</label>
            <?php $catgs = getCategories() ?>
            <select class="form-control" name="suite" id="">
                <?php foreach ($catgs as $key => $catg) { ?>
                    <option value=<?php echo $catg["id"] ?> ><?php echo $catg["description"] . " " . "Kshs " . $catg['price'] ?></option>
                <?php } ?>
            </select>
        </div>
        <div class="row">
            <div class="col">
                <div class="form-group">
                    <label for="exampleInputEmail1">Checkin date</label>
                    <input type="date" class="form-control" name="in" aria-describedby="emailHelp">
                </div>
            </div>
            <div class="col">
                <div class="form-group">
                    <label for="exampleInputEmail1">Checkout date</label>
                    <input type="date" class="form-control" name="out" aria-describedby="emailHelp">
                </div>
            </div>
        </div>
        <div class="form-group">
            <label for="exampleInputEmail1">Adults</label>
            <input type="number" class="form-control" name="adults" aria-describedby="emailHelp" placeholder="number of adults">
        </div>
        <div class="form-group">
            <label for="exampleInputEmail1">Children</label>
            <input type="number" class="form-control" name="children" aria-describedby="emailHelp" placeholder="number of children">
        </div>
        <button type="submit" class="btn btn-secondary btn-block">Book room</button>
    </form>
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous"></script>
  </body>
</html>