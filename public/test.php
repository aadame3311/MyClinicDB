<?php

    # DATABASE VALUES.
    $DB_HOST = 'us-cdbr-iron-east-01.cleardb.net';
    $DB_USR = 'badb5626072670';
    $DB_PWD = '978e7637';

    # DATABASE CONNECTION.
    $conn = new mysqli($DB_HOST, $DB_USR, $DB_PWD);
    if ($conn->connect_error) {
        die("Connection gailed: " . $conn->connect_error);
    }
    echo "<h1>Connected successfully</h1>";


?>