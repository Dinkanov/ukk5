<?php

include 'db.php';

// Memulai sesi
session_start();

// Cek apakah user sudah login
function isLoggedIn()
{
    return isset($_SESSION['user_id']);
}

// Paksa user untuk login jika belum login
function requireLogin()
{
    if (!isLoggedIn()) {
        header("Location: login.php");
        exit();
    }
}

// Cek apakah user adalah superadmin
function isSuperAdmin()
{
    return isLoggedIn() && $_SESSION['user_role'] === 'superadmin';
}

// Fungsi logout
function logout()
{
    session_unset();
    session_destroy();
    header("Location: login.php");
    exit();
}