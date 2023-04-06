<?php

session_start();
if(!isset($_SESSION['email'])) {
    header('location: ../login.php');
}

?>

<?php require_once('../../db/db.php') ?>


<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
    <link rel="stylesheet" href="../style.css">
    <!-- <script src="https://cdn.jsdelivr.net/npm/chart.js"></script> -->
    <title>Reservation</title>

    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script>
      function getKeysArray(objectsArray) {
         // Create an empty array to hold the keys
         var keys = [];

         // Loop through the objects in the array
         for (var i = 0; i < objectsArray.length; i++) {
            // Loop through the keys of each object
            for (var key in objectsArray[i]) {
               // If the key is not already in the keys array, add it
               if (!keys.includes(key)) {
               keys.push(key);
               }
            }
         }

         // Create a new array to hold the result
         var result = [];

         // Loop through the objects in the array
         for (var i = 0; i < objectsArray.length; i++) {
            // Create a new array to hold the values for this object
            var values = [];

            // Loop through the keys
            for (var j = 0; j < keys.length; j++) {
               // If the object has a value for this key, add it to the values array
               if (keys[j] in objectsArray[i]) {
               values.push(objectsArray[i][keys[j]]);
               } else {
               values.push(null);
               }
            }

            // Add the values array to the result array
            result.push(keys);
            result.push(values);
         }

         // Return the result array
         return result;
      }

      // Get the data from the PHP file using fetch
      const query_data = async () => {
         try {
            const res = await fetch('query_db.php')
            const data = await res.json()
            const data_arr = getKeysArray(data)
            console.log(data_arr, data)

            return data_arr
         } catch (error) {
            console.error(error)
         }
      }
      query_data()
      
    </script>
    <script type="text/javascript">
      google.charts.load('current', {'packages':['corechart', 'bar']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {
         var data = google.visualization.arrayToDataTable([
            ['Months', 'Earnings'],
            ['Jan', 800800],
            ['Feb',  1517000],
            ['Mar',  2896000],
            ['Apr',  1953000],
            ['Dec',  3694000]
         ]);

         var materialOptions = {
            chart: {
               title: 'MIRTH BOOKING Earning',
               subtitle: '2022 - 2023 Financial year earning'
            },
            hAxis: {
               title: 'Total Population'
            },
            vAxis: {
               title: 'City'
            },
            bars: 'horizontal',
            series: {
               0: {axis: '2010'},
               1: {axis: '2000'}
            },
            axes: {
               x: {
                  2010: {label: 'Total earning (in millions)', side: 'top'},
                  2000: {label: '2000 Population'}
               }
            }
         };
         var materialChart = new google.charts.Bar(document.getElementById('sales_chart'));
         materialChart.draw(data, materialOptions);
      }
    </script>
    <script type="text/javascript">
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Month', 'Luxury suite', 'Family suite', 'Premium suite'],
          ['Jan', 13, 5, 1],
          ['Feb', 9, 15, 3],
          ['Mar',  23, 20, 3],
          ['Apr', 18, 20, 5],
          ['Dec', 26, 28, 8]
        ]);

        var materialOptions = {
            chart: {
               title: 'MIRTH BOOKING Reservations',
               subtitle: 'Number of booking per suite'
            },
            hAxis: {
               title: 'Reservations'
            },
            vAxis: {
               title: 'Number of reservations'
            }
         };
         var materialChart = new google.charts.Bar(document.getElementById('curve_chart'));
         materialChart.draw(data, materialOptions);
      }
    </script> 
  </head>
  <body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="../dashboard.php">Dashboard</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
               <ul class="navbar-nav mr-auto">
                  <li class="nav-item active">
                     <a class="nav-link" href="../rooms/">Rooms <span class="sr-only">(current)</span></a>
                  </li>
                  <li class="nav-item">
                     <a class="nav-link" href="../bookings/" class="active">Check in guest</a>
                  </li>
                  <li class="nav-item">
                     <a class="nav-link" href="../reservations/" class="active">Reservations</a>
                  </li>
                  <li class="nav-item">
                     <a class="nav-link" href="./index.php" class="active">Business inteligence</a>
                  </li>
                  <li class="nav-item">
                     <a class="nav-link" href="../logout.php">Log out</a>
                  </li>
                </ul>
            </div>
        </div>
    </nav>
    <div class="container">
        <div class="my-5" onload="getDataset()" style="display: flex; gap: 1rem;" >
            <div id="curve_chart" style="width: 800px; border: #000 .7px solid; padding: 16px; height: 400px"></div>
            <div id="sales_chart" style="width: 800px; border: #000 .7px solid; padding: 16px; height: 400px"></div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous"></script>
  </body>
</html>