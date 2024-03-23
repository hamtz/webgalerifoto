<?php
    session_start();
	include 'db.php';
    if(isset($_SESSION['status_login']) && $_SESSION['status_login'] == true){
        echo 'berhasil login';
    } else {
        echo '<script>window.location="login.php"</script>';
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
</head>

<body>
    <!-- header -->
    <header>
        <div class="container">
        <h1><a href="dashboard.php">WEB GALERI FOTO</a></h1>
        <ul>
           <li><a href="dashboard.php">Dashboard</a></li>
           <li><a href="profil.php">Profil</a></li>
           <li><a href="data-image.php">Data Foto</a></li>
           <li><a href="Keluar.php">Keluar</a></li>
        </ul>
        </div>
    </header>
        
    <!-- content -->
    <div class="section">
        <div class="container">
            <h3>Tambah Komentar</h3>
            <div class="box">
                <h3><?php echo $p->image_name ?><br />Kategori : <?php echo $p->category_name  ?></h3>
                <!-- <p class="btn"  ><a href="tambah-image.php">Tambah Data</a></p> -->
                <br>
                <br>
                <div class="box">
             
               <form action="" method="POST" enctype="multipart/form-data">
                   
                   <input type="text" name="imageid" class="input-control" value="<?php echo $p->image_id?>" readonly="readonly">
                   <input type="text" name="userid" class="input-control" value="<?php echo $_SESSION['a_global']->admin_id ?>" readonly="readonly">
                   <input type="text" name="namaadmin" class="input-control" value="<?php echo $_SESSION['a_global']->admin_name ?>" readonly="readonly">
                   <textarea class="input-control" name="deskripsi" placeholder="Tulis Komentar Ramah"></textarea><br />
                   <input type="submit" name="submit" value="Submit" class="btn">
               </form>

                <?php
                   if(isset($_POST['submit'])){
					   
					   // print_r($_FILES[gambar']);
					   // menampung inputan dari form
					  
					   $id_image   = $_POST['imageid'];
					   $id_user   = $_POST['userid'];
					   $nama_user   = $_POST['namaadmin'];
					   $deskripsi = $_POST['deskripsi'];
					  
                       $insert = mysqli_query($conn, "INSERT INTO tb_comments VALUES (
                                        null,
						                '".$id_image."',
									   '".$id_user."',
									   '".$nama_user."',
									   '".$deskripsi."'
						                   ) ");
										   
				           if($insert){
							   echo '<script>alert("Berhasil menambah komentar")</script>';
							   echo '<script>window.location="dashboard.php"</script>';
						   }else{
							   echo 'gagal'.mysqli_error($conn);
							   
						   }
					   }
			   ?>
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