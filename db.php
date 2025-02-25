<?php
    $host = 'localhost';
    $user = 'root';
    $pass = '';
    $db_name = 'user_management';
    $conn = new mysqli($host, $user, $pass, $db_name);

    if ($conn->connect_error) {
        die("Koneksi database gagal: " . $conn->connect_error);
    } 
    // else {
    //     echo "Koneksi database sukses!";
    // }
?>