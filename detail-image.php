
<?php
    error_reporting(0);
    session_start();
	include 'db.php';
	if(isset($_SESSION['status_login']) && $_SESSION['status_login'] == true){
        echo 'berhasil login';
    } else {
        // echo '<script>window.location="login.php"</script>';
        echo 'belum login';
    }
    include 'db.php';
    $userid = $_SESSION['id'];
	$kontak = mysqli_query($conn, "SELECT admin_telp, admin_email, admin_address FROM tb_admin WHERE admin_id = $userid");
	$a = mysqli_fetch_object($kontak);
	
	$produk = mysqli_query($conn, "SELECT * FROM tb_image WHERE image_id = '".$_GET['id']."' ");
	$p = mysqli_fetch_object($produk);


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>WEB Galeri Foto</title>
<link rel="stylesheet" type="text/css" href="css/style.css">
<!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"> -->
</head>

<body>
    <!-- header -->
    <header>
        <div class="container">
        <h1><a href="index.php">WEB GALERI FOTO</a></h1>
        <ul>
            <li><a href="galeri.php">Galeri</a></li>
           <li><a href="registrasi.php">Registrasi</a></li>
          <?php
             if(isset($_SESSION['status_login']) && $_SESSION['status_login'] == true){
                 echo '<li><a href="keluar.php">Keluar</a></li>';
            } else {
                echo '<li><a href="login.php">Login</a></li>';
                }
            ?>
        </ul>
        </div>
    </header>
    
    <!-- search -->
    <div class="search">
        <div class="container">
            <form action="galeri.php">
                <input type="text" name="search" placeholder="Cari Foto" value="<?php echo $_GET['search'] ?>" />
                <input type="hidden" name="kat" value="<?php echo $_GET['kat'] ?>" />
                <input type="submit" name="cari" value="Cari Foto" />
            </form>
        </div>
    </div>
    
    <!-- product detail -->
    <div class="section">
        <div class="container">
             <h3>Detail Foto</h3>
            <div class="box">
                <div class="col-2">
                   <img src="foto/<?php echo $p->image ?>" width="100%" /> 
                </div>
                <div class="col-2">
                   <h3><?php echo $p->image_name ?><br />Kategori : <?php echo $p->category_name  ?></h3>
                   <h4>Nama User : <?php echo $p->admin_name ?><br />
                   Upload Pada Tanggal : <?php echo $p->date_created  ?></h4>
                   <p>Deskripsi :<br />
                        <?php echo $p->image_description ?>
                   </p>
                   
                </div>
            </div>
        </div>
    </div>
    <!-- commets -->
    <div class="section">
        <div class="container">
             <h3>Komentar </h3> 
            
            <?php
            $imageid = $_GET['id'];

             if(isset($_SESSION['status_login']) && $_SESSION['status_login'] == true){
                 echo( '<br><a href="add-comment.php?id='.$imageid.'" class="btn"><i class="fa-solid fa-plus">+ Tambah</i></a>');
            } else {
                echo '';
                }
            ?>
                                
            <div class="box">
                <div class="col-2">
            <?php
                $comments = mysqli_query($conn, "SELECT * FROM tb_comments WHERE image_id = '".$_GET['id']."' LIMIT 5");

                // Menggunakan while loop untuk menampilkan semua komentar
                while($komen = mysqli_fetch_object($comments)) {
                ?>
                            <h4><?php echo $komen->nama ?></h4>
                            
                            <h5>
                                <?php echo $komen->description ?>
                            </h5>
                            <hr>
                            <br>
                            <?php
                }
                ?>
                </div>
            </div>
        </div>
    </div>
    
    <!-- footer -->
    <footer>
        <div class="container">
            <small>Copyright &copy; 2024 - Web Galeri Foto.</small>
        </div>
    </footer>
</body>
</html>