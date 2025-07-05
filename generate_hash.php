<?php

// Password yang ingin di-hash
$password = "password123";

// Hasilkan hash password menggunakan algoritma default (saat ini Bcrypt)
// PASSWORD_DEFAULT akan menggunakan algoritma hashing terbaik yang tersedia dan direkomendasikan.
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

// Tampilkan hash yang dihasilkan
echo "Hash untuk 'password123' adalah: " . $hashed_password . PHP_EOL;

?>
