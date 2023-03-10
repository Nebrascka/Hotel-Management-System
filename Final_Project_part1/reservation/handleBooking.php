<?php
session_start();

if(!isset($_SESSION['id'])) {
    header('location: ./login.php');
}
?>

<?php require_once('../db/db.php') ?>

<?php 
    $cp = 0;
    if(isset($_GET['cp'])) { 
        $cp = $_GET["cp"];
    } 
?>

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

function getRoom($capacity) {
    $pdo = establishCONN();

    $stmt = $pdo->prepare("SELECT rooms.id, rooms.name, rooms.image, categories.description AS category, categories.price FROM rooms LEFT JOIN categories ON rooms.category = categories.id WHERE rooms.isBooked = :state AND rooms.capacity >= :cp");
    $stmt->bindValue(":state", false);
    $stmt->bindValue(":cp", $capacity);
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getRoomVar($category, $capacity) {
    $pdo = establishCONN();

    $stmt = $pdo->prepare("SELECT rooms.id, rooms.name, rooms.image, categories.description AS category, categories.price FROM rooms LEFT JOIN categories ON rooms.category = categories.id WHERE rooms.isBooked = :state AND rooms.category = :ct AND rooms.capacity >= :cp");
    $stmt->bindValue(":state", false);
    $stmt->bindValue(":ct", $category);
    $stmt->bindValue(":cp", $capacity);
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

if($_SERVER['REQUEST_METHOD'] === 'POST') {

    $adults = $_POST['adults'];
    $children = $_POST['children'];
    $suite = $_POST['suite'];

    $rooms = getRoomVar($suite, (int)$adults + (int)$children);
} else {
    $rooms = getRooms($cp);
}

?>
