<?php
session_start();
include 'db.php';

// cek login
if(!isset($_SESSION['status_login']) || $_SESSION['status_login'] != true){
    header("Location: login.php");
    exit; 
}

if(isset($_GET['id']) && is_numeric($_GET['id'])) {
    $imageId = $_GET['id'];
    
    $checkLike = mysqli_query($conn, "SELECT * FROM tb_likes WHERE image_id = $imageId AND user_id = {$_SESSION['id']}");
    if(mysqli_num_rows($checkLike) > 0) {
        echo "Anda telah memberikan like pada foto ini.";
    } else {
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
