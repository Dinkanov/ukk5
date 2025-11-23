<?php
// Ganti 'rahasia123' dengan password yang Anda inginkan
$password = 'superadmin';

// Generate hash
$hash = password_hash($password, PASSWORD_DEFAULT);

echo "Password: " . $password . "<br>";
echo "Hash: " . $hash;
?>