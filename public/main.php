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

/*
--CREATE TABLE--
$res = $conn->query("create table employee (
    ID int not null auto_increment primary key,
    first_name varchar(255) not null, 
    last_name varchar(255) not null, 
    department_id int not null, 

    foreign key(department_id) references Department(ID)
)");
if (!$res) {
    die("SQL ERROR: " . $conn->error);
}
echo "table created succesfuly.";


--ADD VALUES TO TABLE--
$res = $conn->query("insert into employee(first_name, last_name, department_id) values('john', 'smith', 1)");
if (!$res) {
    die("SQL ERROR: " . $conn->error);
}
echo "Insertion was succesfull.";
*/


# select all first names of all employees.
$res = $conn->query("select first_name from employee");
if (!$res) {
    die("SQL Error " . $conn->error);
}
foreach ($res as $names) {
    foreach ($names as $n) {
        echo $n . "<br>";
    }
}

?>