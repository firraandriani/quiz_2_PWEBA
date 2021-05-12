<?php 
session_start();

if(!isset($_SESSION["validasiLogin"])) {
    header("Location: index.php");
    exit;
}

include('db.php');
$lib = new Library();
if(isset($_GET['id_mahasiswa'])){
    $id_mahasiswa = $_GET['id_mahasiswa']; 
    $data_mahasiswa = $lib->get_by_id($id_mahasiswa);
}
else
{
    header('Location: tabel.php');
}

if(isset($_POST['tombol_update'])){
    $nama_lengkap = $_POST['namaLengkap'];
    $nim = $_POST['nim'];
    $kelas = $_POST['kelas'];
    $username_mahasiswa = $_POST['username_mahasiswa'];
    $password_mahasiswa = $_POST['password_mahasiswa'];

    $status_update = $lib -> update($id_mahasiswa, $nama_lengkap, $nim, $kelas, $username_mahasiswa, $password_mahasiswa);
    if(is_numeric($status_update)){
        echo '<script type="text/javascript">window.location.href = "tabel.php"</script>';
    }
    else {
        echo "<script type='text/javascript'>alert('$status_update');</script>";;
    }
}
?>
<html>
    <head>
    <title>Edit Data Mahasiswa</title>
        <style>
            h1 {
                text-align: center;
                font-family: Forte;
            }

            label {
                font-family: Arial;
                font-weight: bold;
                font-size: 1.2em;

            }

            * {
                margin: 0; 
                padding: 0;
            }

            .tengah {
                margin: 20px;
                text-align: center;
            }

            .form {
                background-color: rgba(235, 235, 235, 0.6);
                border:none;
                outline: none;
                border-radius: 20px;
                width: 400px;
                height: 40px;
                font-family: Franklin Gothic Book;
                font-size: 1.2em;
                text-align: center;
                font-weight: bold;
            }

            .update {
                background-color: #3FC380;
                border: none;
                outline: none;
                border-radius: 20px;
                width: 400px;
                height: 40px;
                font-family: Franklin Gothic Book;
                font-size: 1.2em;
                text-align: center;
                font-weight: bold;
            }
        </style>
    </head>
<body>
    <div>
        <div>
            <div>
                <h1>Edit Data Mahasiswa</h1>
            </div>
            <div class = "tengah">
            <form method="post" action="">
                <div>
                <input type="hidden" name="id_mahasiswa" value="<?php echo $data_mahasiswa['id_mahasiswa']; ?>"/>
                <div>
                    <label for="namaLengkap">Nama Lengkap</label>
                    <div>
                    <input class = "form" type="text" name="namaLengkap" placeholder = "Masukkan Nama Lengkap" class="form-control" id="namaLengkap" value="<?php echo $data_mahasiswa['namaLengkap']; ?>">
                    </div>
                </div>
                <br>
                <div>
                    <label for="nim">NIM</label>
                    <div>
                    <input class = "form" type="text" name="nim" placeholder = "Masukkan NIM" class="form-control" id="nim" value="<?php echo $data_mahasiswa['nim']; ?>">
                    </div>
                </div>
                <br>
                <div>
                    <label for="kelas">Kelas</label>
                    <div>
                    <input class = "form" type="text" name="kelas" placeholder = "Masukkan Kelas" class="form-control" id="kelas" value="<?php echo $data_mahasiswa['kelas']; ?>">
                    </div>
                </div>
                <br>
                <div>
                    <label for="username_mahasiswa">Username</label>
                    <div>
                    <input class = "form" type="text" placeholder = "Masukkan Username" class="form-control" name="username_mahasiswa" id="username_mahasiswa" value="<?php echo $data_mahasiswa['username']; ?>">
                    </div>
                </div>
                <br>
                <div>
                    <label for="password_mahasiswa">Password</label>
                    <div>
                    <input class = "form" type="password" placeholder = "Masukkan Password" class="form-control" name="password_mahasiswa" id="password_mahasiswa" value="<?php echo $data_mahasiswa['password']; ?>">
                    </div>
                </div>
                <br>
                <div>
                    <label for="kelas"></label>
                    <div>
                    <input type="submit" name="tombol_update" class="update" value="Update">
                    </div>
                </div>
            </form>
            </div>
        </div>
    </div>
    </body>
</html>