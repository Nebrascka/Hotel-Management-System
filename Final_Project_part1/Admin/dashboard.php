<?php

session_start();
if(!isset($_SESSION['email'])) {
    header('location: ./login.php');
}

?>

<?php require_once('../db/db.php') ?>


<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js" defer></script>
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
                    <a class="nav-link" href="#">Rooms <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="./reservations.php">Reservations</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="./logout.php">Log out</a>
                </li>
            </div>
        </div>
    </nav>
    <div class="container" style="display: flex; gap: 1rem;">
        <div class="jumbotron my-5">
            <h1 class="display-4">Dashboard</h1>
            <hr class="my-4">
            <p>It uses utility classes for typography and spacing to space content out within the larger container.</p>
            <a class="btn btn-primary btn-lg" href="./addroom.php" role="button">Add room</a>
        </div>
        <div class="my-5">
            <canvas id="myChart" height="480px"></canvas>
        </div>

        <script>
            async function getDataset(){
                const res = await fetch('/Hotel-Management-System/Final_Project_part1/Admin/getData.php')
                const dataset = await res.json()

                const ctx = document.getElementById('myChart');
                const months = dataset.months.map(month => {
                    const date = new Date()
                    date.setMonth(Number(month) - 1)

                    return date.toLocaleString('en-US', {
                        month: 'long',
                    })
                })

                new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: months,
                        datasets: [{
                            label: 'monthly bookings',
                            data: dataset.map,
                            borderWidth: 1
                        }]
                    },
                    options: {
                        scales: {
                            y: {
                                title: {
                                    display: true,
                                    text: '# of bookings'
                                },
                                grace: '20%',
                                beginAtZero: true
                            },
                            x: {
                                title: {
                                    display: true,
                                    text: 'months'
                                },
                                beginAtZero: true
                            }
                        }
                    }
                });
            }
            
        </script>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous"></script>
  </body>
</html>