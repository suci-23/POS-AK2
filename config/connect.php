<?php
$hostname = 'localhost';
$username = 'root';
$password = '';
$database = 'lms_ak2';

$config = mysqli_connect($hostname, $username, $password, $database);

if (!$config) {
  echo 'koneksi gagal.';
}
