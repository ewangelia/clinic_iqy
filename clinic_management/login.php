<?php
 // Konfigurasi database
 $host = "localhost"; // Ganti dengan nama host yang digunakan
 $username = "root"; // Ganti dengan username untuk akses ke database
 $password = ""; // Ganti dengan password untuk akses ke database
 $database = "klinik"; // Ganti dengan nama database yang digunakan

 // Membuat koneksi ke database
 $conn = mysqli_connect($host, $username, $password, $database);

 // Mengecek koneksi
 if (!$conn) {
     die("Koneksi gagal: " . mysqli_connect_error());
 }

 if (isset($_POST['submit'])){
     
     // Mendapatkan nilai username dan password dari form
     $nik = $_POST["nik"];
     $pwd = $_POST["pwd"];
    
     // Query untuk memeriksa keberadaan user dengan username dan password yang sesuai
     $sql = "SELECT * FROM users WHERE nik = '$nik' AND pwd = '$pwd'";
     $result = mysqli_query($conn, $sql);
    
     // Mengecek apakah user dengan username dan password yang sesuai ditemukan
     if (mysqli_num_rows($result) > 0) {
         // Mendapatkan data user dari hasil query
         $users = mysqli_fetch_assoc($result);
         
         // Mengecek level user
         if ($users["level_user"] == "1") {
             // Jika user adalah admin, maka simpan level user pada session dan redirect ke halaman utama admin
             session_start();
             $_SESSION["level"] = "admin";
             header("Location: backend\admin");
         } else if ($users["level_user"] == "2") {
             // Jika user adalah dokter, maka simpan level user pada session dan redirect ke halaman utama dokter
             session_start();
             $_SESSION["level"] = "dokter";
             header("Location: backend\doc");
         } else if ($users["level_user"] == "3") {
             // Jika user adalah dokter, maka simpan level user pada session dan redirect ke halaman utama dokter
             session_start();
             $_SESSION["level"] = "customer";
             header("Location: pasien_dashboard.php");
         } else {
             // Jika user tidak memiliki level yang sesuai, maka tampilkan pesan error
             echo "Level user tidak ditemukan.";
         }
     } else {
         // Jika user tidak ditemukan, maka tampilkan pesan error
         echo "Username atau password salah.";
     }
 }

 // Menutup koneksi ke database
 mysqli_close($conn);
//    session_start();
//    include('backend/config.php'); //get configuration file
   
//    if (isset($_POST['user_login'])) {
//        $nik = $_POST['nik'];
//        $pwd = sha1(md5($_POST['pwd']));
   
//        $stmt = $mysqli->prepare("SELECT id_user, nik, pwd, level_user FROM users WHERE nik=? AND pwd=?");
//        $stmt->bind_param('ss', $nik, $pwd);
//        $stmt->execute();
//        $stmt->bind_result($id_user, $nik, $pwd, $level_user);
//        $stmt->store_result();
   
//        if ($stmt->num_rows == 1) {
//            while ($stmt->fetch()) {
//                $_SESSION['id_user'] = $id_user;
//                $_SESSION['nik'] = $nik;
//                $_SESSION['level_user'] = $level_user;
   
//                if ($level_user == "1") {
//                    header("location: backend/admin/admin_dashboard.php");
//                } elseif ($level_user == "2") {
//                    header("location: backend/doc/dokter_dashboard.php");
//                } elseif ($level_user == "3") {
//                    header("location: backend/pasien/pasien_dashboard.php");
//                } else {
//                    $err = "Invalid login credentials.";
//                }
//            }
//        } else {
//            $err = "Invalid login credentials.";
//        }
//    }
    
?>
<!--End Login-->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ASRI MEDICAL</title>

    <!-- font awesome cdn link  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <!-- custom css file link  -->
    <link rel="stylesheet" href="css/style.css">

        <!--Load Sweet Alert Javascript-->
        
        <script src="assets/js/swal.js"></script>
        <!--Inject SWAL-->
        <?php if(isset($success)) {?>
        <!--This code for injecting an alert-->
                <script>
                            setTimeout(function () 
                            { 
                                swal("Success","<?php echo $success;?>","success");
                            },
                                100);
                </script>

        <?php } ?>

        <?php if(isset($err)) {?>
        <!--This code for injecting an alert-->
                <script>
                            setTimeout(function () 
                            { 
                                swal("Failed","<?php echo $err;?>","error");
                            },
                                100);
                </script>

        <?php } ?>



    </head>

    <body>
        <section class="login" id="login">
        <h1>ASRI Medical</h1>
            <div class="row">
                <div class="image">
                <img src="image/appointment-img.jpg" alt="">
                </div>
                <form method='post' >
                    <h3>Login</h3>
                    <input type="text"name="nik" required="" id="nik"placeholder="Masukkan Nomor Induk Kependudukan" class="box">
                    <input class="box" name="pwd" type="password" required="" id="pwd" placeholder="Masukkan Password">  
                    <input type="submit" name="submit" value="Masuk" class="btn">
                </form>
            </div>
                        </section>

        <!-- <?php include ("assets/inc/footer.php");?> -->

        <!-- Vendor js -->
        <script src="assets/js/vendor.min.js"></script>

        <!-- App js -->
        <script src="assets/js/app.min.js"></script>
        <script src="assets/js/script.js"></script>
    </body>

</html>