<?php require_once('../db/db.php') ?>

<?php

session_start();
if(!isset($_SESSION['email'])) {
    header('location: ./login.php');
}

?>



<?php

    function getRooms($category, $capacity) {
        $pdo = establishCONN();

        $stmt = $pdo->prepare("SELECT id, number from rooms WHERE isBooked = :state AND category = :ct AND capacity >= :cpt");
        $stmt->bindValue(':state', false);
        $stmt->bindValue(':ct', $category);
        $stmt->bindValue(':cpt', $capacity);

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);

    }

    function getRes(){
        $pdo = establishCONN();

        $stmt = $pdo->prepare("SELECT applications.id, applications.created_by, applications.suite, applications.checkin, applications.checkout, applications.adults, applications.children, categories.description, categories.price, users.fname, users.lname FROM applications LEFT JOIN categories ON applications.suite = categories.id LEFT JOIN users ON applications.created_by = users.id WHERE applications.isApproved = :state");
        $stmt->bindValue(':state', false);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
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
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="#">Dashboard</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mr-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="./addroom.php">Rooms <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="./reservations.php" class="active">Reservations</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="./logout.php">Log out</a>
                </li>
            </div>
        </div>
    </nav>
    <div class="container">
        <table class="table my-5">
            <thead class="thead-dark">
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">First name</th>
                    <th scope="col">Last name</th>
                    <th scope="col">Checkin date</th>
                    <th scope="col">Checkout date</th>
                    <th scope="col">Room type</th>
                    <th scope="col">Adults</th>
                    <th scope="col">Children</th>
                    <th scope="col">Price</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php $res = getRes();?>
                <?php foreach ($res as $key => $r) { ?>
                    <tr>
                        <td scope="col"><?php echo $key ?></td>
                        <td scope="col"><?php echo $r['fname'] ?></td>
                        <td scope="col"><?php echo $r['lname'] ?></td>
                        <td scope="col"><?php echo $r['checkin'] ?></td>
                        <td scope="col"><?php echo $r['checkout'] ?></td>
                        <td scope="col"><?php echo $r['description'] ?></td>
                        <td scope="col"><?php echo $r['adults'] ?></td>
                        <td scope="col"><?php echo $r['children'] ?></td>
                        <td scope="col"><?php echo $r['price'] ?></td>
                        <td scope="col" style="width: 16rem;">
                        <details>
                            <?php $category = $r['suite']; $capacity = $r['adults'] + $r['children']; ?>
                            <?php $rooms = getRooms($category, $capacity) ?>
                            <summary style="list-style: none;" >Approve</summary>
                            <form action="./approve.php?apl_id=<?php echo $r['id'] ?>" method="post">
                                <select name="room_id" id="">
                                    <?php foreach($rooms as $room) { ?>
                                        <option value="<?php echo $room['id'] ?>">Room <?php echo $room['number'] ?></option>
                                    <?php }?>
                                </select>
                                <input type="submit" value="Approve">
                            </form>
                        </details>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous"></script>
  </body>
</html>