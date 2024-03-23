<?php
session_start();
include 'db.php';

// Pastikan user telah login
if(!isset($_SESSION['status_login']) || $_SESSION['status_login'] != true){
    // Jika belum login, arahkan kembali ke halaman login
    header("Location: login.php");
    exit; // Berhenti eksekusi skrip
}

// Periksa apakah ada parameter id di URL
if(isset($_GET['id']) && is_numeric($_GET['id'])) {
    $imageId = $_GET['id'];
    
    // Periksa apakah user telah memberikan like sebelumnya
    $checkLike = mysqli_query($conn, "SELECT * FROM tb_likes WHERE image_id = $imageId AND user_id = {$_SESSION['id']}");
    if(mysqli_num_rows($checkLike) > 0) {
        // Jika sudah memberikan like, tidak lakukan apa-apa
        // echo "Anda telah memberikan like pada foto ini.";
        echo "Anda telah memberikan like pada foto ini.";
    } else {
        // Jika belum memberikan like, tambahkan data like ke dalam tabel
        $insertLike = mysqli_query($conn, "INSERT INTO tb_likes (image_id, user_id, status_like) VALUES ($imageId, {$_SESSION['id']}, 1)");
        if($insertLike) {
            echo "Like telah ditambahkan.";
        } else {
            echo "Gagal menambahkan like.";
        }
    }
} else {
    echo "ID gambar tidak valid.";
}

// Kembalikan pengguna ke halaman detail foto setelah proses selesai
header("Location: detail-image.php?id=$imageId");
exit;
?>
