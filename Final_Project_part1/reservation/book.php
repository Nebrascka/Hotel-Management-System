<?php require_once('../db/db.php') ?>
<?php

  function getRoom($id) {
      $pdo = establishCONN();

      $stmt = $pdo->prepare("SELECT rooms.id, rooms.name, rooms.image, categories.description AS category, categories.price FROM rooms LEFT JOIN categories ON rooms.category = categories.id WHERE rooms.id = :id");
      $stmt->bindValue(":id", $id);
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
    <?php //var_dump(getRoom($_GET["rid"])) ?>
    <section class="booking">
        <?php $room = getRoom($_GET["rid"])[0]; ?>
        <div class="booking-cont">
          <div class="booking-ill">
            <img src="..<?php echo $room["image"]; ?>" alt="">
          </div>
          <div class="booking-details">
            <div class="booking-meta">
              <h3><?php echo $room["name"]; ?></h3>
              <p id="suite-price"><?php echo $room["price"] ?> per night</p>
              <hr>
            </div>
            <form action="handleBooking.php" class="book-form" method="POST">
            <p><small><b>Reservation details:</b></small></p>
              <div class="row">
                  <div class="col">
                      <div class="form-group">
                          <label for="adults">Checkin Date</label>
                          <input type="date" class="form-control dates" name="checkin" id="checkindate">
                      </div>
                  </div>
                  <div class="col">
                      <div class="form-group">
                          <label for="children">Checkout date</label>
                          <input type="date" class="form-control dates" name="checkout" id="checkoutdate">
                      </div>
                  </div>
              </div>
              <div class="row">
                <div class="col">
                  <div class="form-group">
                    <label for="exampleInputEmail1">Adults</label>
                    <input type="number" class="form-control" name="adults">
                  </div>
                </div>
                <div class="col">
                  <div class="form-group">
                    <label for="exampleInputEmail1">Children</label>
                    <input type="number" class="form-control" name="children">
                  </div>
                </div>
              </div>
              <div class="form-group">
                <label for="exampleInputEmail1"><strong>Total Price</strong></label>
                <input disabled type="text" class="form-control total-price" name="price" value="Kshs <?php echo $room["price"]; ?>">
              </div>
              <p><small><b>Personal details:</b></small></p>
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
                <label for="exampleInputEmail1">Email</label>
                <input type="email" class="form-control" name="email" aria-describedby="emailHelp" placeholder="email@domain.com">
              </div>
              <div class="form-group">
                <input class="btn btn-primary btn-block" type="submit" value="Reserve">
              </div>
            </form>
          </div>
        </div>

        <script>
          const dateTags = document.querySelectorAll(".dates")
          const checkin = document.querySelector("#checkindate")
          const checkout = document.querySelector("#checkoutdate")
          const price = document.querySelector(".total-price")
          const suitePrice = document.querySelector("#suite-price")
          
          dateTags.forEach(dateTag => {
            dateTag.addEventListener('change', e => {
              console.log(e.target.value)

              let date1 = new Date(checkin.value);
              let date2 = new Date(checkout.value);

              let timeDiff = Math.abs(date2.getTime() - date1.getTime())
              let numberOfNights = Math.ceil(timeDiff / (1000 * 3600 * 24))

              price.value = `Ksh ${parseInt(suitePrice.innerText) * numberOfNights}`
            })
          })
        </script>
    </section>
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous"></script>
  </body>
</html>