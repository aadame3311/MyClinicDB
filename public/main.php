<?php
require '../vendor/autoload.php';
require '../generated-conf/config.php';



# DATABASE VALUES.
$DB_NAME = 'heroku_9a70b6832dee0c8';
$DB_HOST = 'us-cdbr-iron-east-01.cleardb.net';
$DB_USR = 'badb5626072670';
$DB_PWD = '978e7637';

# DATABASE CONNECTION.
$conn = new mysqli($DB_HOST, $DB_USR, $DB_PWD, $DB_NAME);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
echo "<h1>Connected successfully</h1>";

# QUERYING SQL THROUGH BASIC PHP.
# select all first names of all employees.
$res = $conn->query("select first_name from employee");
if (!$res) {
    die("SQL Error" . $conn->error);
}
foreach ($res as $names) {
    foreach ($names as $n) {
        echo $n . "<br>";
    }
}


#QUERYING SQL THROUGH PROPEL(PHP).
$res = EmployeeQuery::create()->findPK(11);
echo $res->getFirstName();

?>