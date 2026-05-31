<?php
// Database connection
$conn = mysqli_connect("localhost", "root", "", "transport_db");

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// SQL query
$sql = "SELECT bus_company, destination FROM buses";

// Execute query
$result = mysqli_query($conn, $sql);

// Store records in an array
$buses = array();

while ($row = mysqli_fetch_assoc($result)) {
    $buses[] = $row;
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title>Dar es Salaam Bus Terminal</title>
</head>

<body>

<h2>Dar es Salaam Bus Terminal Display</h2>

<ul>
<?php
// foreach loop to display records
foreach ($buses as $bus) {
    echo "<li>";
    echo $bus['bus_company'] . " - " . $bus['destination'];
    echo "</li>";
}
?>
</ul>

</body>
</html>

<?php
// Close connection
mysqli_close($conn);
?>