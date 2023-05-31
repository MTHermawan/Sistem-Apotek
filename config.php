<?php
$host = 'localhost';
$username = 'root';
$password = '';
$database = 'apotek';

$connect = mysqli_connect($host, $username, $password, $database);

if (!$connect) {
	echo "Koneksi ke database gagal : " . mysqli_connect_error();
}
?>