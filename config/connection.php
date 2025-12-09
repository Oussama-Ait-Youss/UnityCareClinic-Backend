<?php

    // connection variables
    $HOST = 'db';
    $USER = 'root';
    $PASS = 'root';
    $DB = 'hospital_db';

    // connection

    $conn = mysqli_connect($HOST,$USER,$PASS,$DB);

    if ($conn) {
        # code...
    }else{
        echo "connection echou!!!";

    }
