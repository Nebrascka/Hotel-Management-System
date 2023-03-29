<?php
// Step 1: Connect to the database
$servername = "localhost";
$username = "your_username";
$password = "your_password";
$dbname = "your_database";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// Step 2: Retrieve the data
$sql = "SELECT column1, column2, column3 FROM your_table";
$result = $conn->query($sql);

// Step 3: Format the data into an HTML table
if ($result->num_rows > 0) {
  echo "<table><tr><th>Column 1</th><th>Column 2</th><th>Column 3</th></tr>";
  // output data of each row
  while($row = $result->fetch_assoc()) {
    echo "<tr><td>".$row["column1"]."</td><td>".$row["column2"]."</td><td>".$row["column3"]."</td></tr>";
  }
  echo "</table>";
} else {
  echo "0 results";
}

// Step 4: Output the report
$conn->close();
?>
