<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
        if ($_POST['action'] === 'login') {
            // Redirect ke halaman login dengan URL tujuan
            if (isset($_SESSION['redirect_url'])) {
                $redirect_url = urlencode($_SESSION['redirect_url']);
                unset($_SESSION['redirect_url']); // Hapus session untuk URL redirect setelah digunakan
                header("Location: login.php?redirect=$redirect_url");
                exit();
            } else {
                // Jika tidak ada URL redirect, arahkan ke halaman login default
                header("Location: login.php");
                exit();
            }
        } elseif ($_POST['action'] === 'cancel') {
            // Redirect ke halaman utama
            header("Location: index.php");
            exit();
        }
    }
}
?>
