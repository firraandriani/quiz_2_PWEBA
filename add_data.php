<?php 
session_start();

if(!isset($_SESSION["validasiLogin"])) {
    header("Location: index.php");
    exit;
}

include('db.php');
$lib = new Library();

if(isset($_POST['tombol_tambah'])){
    $nama_lengkap = $_POST['namaLengkap'];
    $nim = $_POST['nim'];
    $kelas = $_POST['kelas'];
    $username_mahasiswa = $_POST['username_mahasiswa'];
    $password_mahasiswa = $_POST['password_mahasiswa'];

    $add_status = $lib -> add_data($nama_lengkap, $nim, $kelas, $username_mahasiswa, $password_mahasiswa);
    if(is_numeric($add_status)){
        header('Location: tabel.php');
    }
    else {
        echo "<script type='text/javascript'>alert('$add_status');</script>";
    }
}
?>
<html>
    <head>
        <title>Tambah Data Mahasiswa</title>
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

            .tambah {
                background-color: lightblue;
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
        </style>
    </head>
    <body>
    <div>
        <div>
            <div>
                <h1>Tambah Data Mahasiswa</h1>
            </div>
            <div class = "tengah">
            <form method="post" action="">
                <div>
                    <label for="namaLengkap">Nama Lengkap</label>
                    <div>
                    <input type="text" name="namaLengkap" id="namaLengkap" class = "form" placeholder = "Masukkan Nama Lengkap" value="<?php echo $_POST['namaLengkap'] ?? null; ?>">
                    </div>
                </div>
                <br>
                <div>
                    <label for="nim">NIM</label>
                    <div>
                    <input type="text" name="nim" id="nim" class = "form" placeholder = "Masukkan NIM" value="<?php echo $_POST['nim'] ?? null; ?>">
                    </div>
                </div>
                <br>
                <div>
                    <label for="kelas">Kelas</label>
                    <div>
                    <input type="text" name="kelas" id="kelas" class = "form" placeholder = "Masukkan Kelas" value="<?php echo $_POST['kelas'] ?? null; ?>">
                    </div>
                </div>
                <br>
                <div>
                    <label for="username_mahasiswa">Username</label>
                    <div>
                    <input type="text" name="username_mahasiswa" id="username_mahasiswa" class = "form" placeholder = "Masukkan Username" value="<?php echo $_POST['username_mahasiswa'] ?? null; ?>">
                    </div>
                </div>
                <br>
                <div>
                    <label for="password_mahasiswa">Password</label>
                    <div>
                    <input type="password" name="password_mahasiswa" id="password_mahasiswa" class = "form" placeholder = "Masukkan Password" value="<?php echo $_POST['password_mahasiswa'] ?? null; ?>">
                    </div>
                </div>
                <br>
                <div>
                    <label for="kelas"></label>
                    <div>
                    <input type="submit" name="tombol_tambah" value="Tambah" class = "tambah">
                    </div>
                </div>
            </form>
            </div>
        </div>
    </div>
    </body>
</html>