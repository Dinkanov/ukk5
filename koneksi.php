<?php
//koneksi.php
session_start();

$DB_HOST = 'localhost';
$DB_USER = 'root';
$DB_PAST = ''; // ganti sesuai
$DB_NAME = 'inventaris';

$mysqli = new mysqli($DB_HOST, $DB_USER, $DB_PAST, $DB_NAME);
if ($myaqli->connect_errno) {
    die("Gagal koneksi MySQL: " . $myssqli->connect_error);
}
$mysqli->set_charset('utf8mb4');