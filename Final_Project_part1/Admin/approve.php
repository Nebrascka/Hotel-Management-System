<?php require_once('../db/db.php') ?>

<?php

   function updateApplication($id) {

      $pdo = establishCONN(); 
      $stmt = $pdo->prepare("UPDATE applications SET isApproved = :state WHERE id = :id");
      $stmt->bindValue(':state', true);
      $stmt->bindValue(':id', $id);
      $stmt->execute();
   }
   function updateRoom($id) {

      $pdo = establishCONN(); 
      $stmt = $pdo->prepare("UPDATE rooms SET isBooked = :state WHERE id = :id");
      $stmt->bindValue(':state', true);
      $stmt->bindValue(':id', $id);
      $stmt->execute();
   }
   function createBooking($apl_id, $room_id) {

      $pdo = establishCONN(); 
      $stmt = $pdo->prepare("INSERT INTO bookings(application_id, room_id) VALUES (:apl_id, :room_id)");
      $stmt->bindValue(':apl_id', $apl_id);
      $stmt->bindValue(':room_id', $room_id);
      $stmt->execute();
   }

   $application_id = $_GET['apl_id'];
   $room_id = $_POST['room_id'];

   createBooking($application_id, $room_id);
   updateApplication($application_id);
   updateRoom($room_id);

   header('Location: ./reservations.php');
?>