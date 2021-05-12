<?php
session_start();

if(!isset($_SESSION["validasiLogin"])) {
    header("Location: index.php");
    exit;
}

include('db.php');
$lib = new Library();
$data = $lib -> show();

if (isset($_GET['hapus_siswa']))
{
    $id_mahasiswa = $_GET['hapus_siswa'];
    $status_hapus = $lib -> delete($id_mahasiswa);
    if ($status_hapus)
    {
        header('Location: tabel.php');
    }
}

?>
<html>
    <head>
        <title>Daftar Mahasiswa Fasilkom</title>
        <style>
            .tabelMahasiswa {
                font-family: Arial;
                border-collapse: collapse;
                width: 100%;
                margin-top: 20px;
            }

            h1 {
                text-align: center;
                font-family: Forte;
                font-size: 60px;           }

            .tambah {
                cursor: crosshair;
                text-decoration: none;
                background-color: lightblue;
                padding: 10px 10px;
                text-align: center;
                border-radius: 10px;
                font-family: Arial;
                font-weight: bold;
                color: black;
            }

            .logout {
                text-decoration: none;
                background-color: red;
                padding: 10px 10px;
                text-align: center;
                border-radius: 10px;
                font-family: Arial;
                color: white;
                font-weight: bold;
                float: right;
            }

            .edit {
                text-decoration: none;
                background-color: #3FC380;
                padding: 10px 10px;
                text-align: center;
                border-radius: 10px;
                font-family: Arial;
                font-weight: bold;
                color: black;
            }
            .pageLebih {
                text-decoration: none;
                background-color: #AFEEEE;
                padding: 10px 10px;
                text-align: center;
                font-family: Arial;
                weight: bold;
                color: black;
            }
            .page {
                text-decoration: none;
                background-color: rgba(235, 235, 235, 0.6);
                padding: 10px 10px;
                text-align: center;
                font-family: Arial;
                weight: bold;
                color: black;
            }
            .page_aktif {
                text-decoration: none;
                background-color: #1D79F2;
                padding: 10px 10px;
                text-align: center;
                font-family: Arial;
                weight: bold;
                color: white;
                font-weight: bold;
            }
            .hapus {
                text-decoration: none;
                background-color: #FFABAB;
                padding: 10px 10px;
                text-align: center;
                border-radius: 10px;
                font-family: Arial;
                font-weight: bold;
                color: black;
            }

            td, th {
                border: 1px solid #CFFAF8;
                padding: 15px;
            }

            tr:nth-child(even) {
                background-color: #85E3FF;
            }

            tr:hover {
                background-color: #CFFAF8;
            }

            th {
                padding-top: 12px;
                padding-bottom: 12px;
                text-align: left;
                background-color: #6EB5FF;
                color: white;
            }
        </style>
    </head>
    <body>
    <div>
        <div>
            <div>
                <h1>Data Mahasiswa Fasilkom</h1>
            </div>
            <div>
                <a href="add_data.php" class="tambah"><img src="tambah.png" width="20" height="20">Tambah</a>
                <a href="logout.php" class="logout">Logout</a>
                <table class="tabelMahasiswa" width="60%">
                    <tr>
                        <th>No.</th>
                        <th>Nama Lengkap</th>
                        <th>NIM</th>
                        <th>Kelas</th>
                        <th>Username</th>
                        <th>Password</th>
                        <th>Action</th>
                    </tr>
                    <?php 
                    $no = 1;
                    foreach($data['list_data'] as $row)
                    {
                        echo "<tr>";
                        echo "<td>".$no."</td>";
                        echo "<td>".$row['namaLengkap']."</td>";
                        echo "<td>".$row['nim']."</td>";
                        echo "<td>".$row['kelas']."</td>";
                        echo "<td>".$row['username']."</td>";
                        echo "<td>".$row['password']."</td>";
                        echo "<td><a class = 'edit' href = 'edit_data.php?id_mahasiswa=".$row['id_mahasiswa']."'><img src='edit.png' width='20' height='20'>Edit</a>
                        <a class = 'hapus' href = 'tabel.php?hapus_siswa=".$row['id_mahasiswa']."'><img src='hapus.png' width='20' height='20'>Hapus</a></td>";
                        echo "</tr>";
                        $no++;
                    }
                    ?>
                </table>
                <br>

                <?php if($data['halaman_saat_ini'] > 1): ?>
                    <a href = "?Page=<?= $data['halaman_saat_ini'] - 1; ?>"  class = 'pageLebih'>&laquo;</a>
                <?php endif; ?>

                <?php for($p = 1; $p <= $data['jumlah_halaman']; $p++): ?>
                    <?php if($p == $data['halaman_saat_ini']): ?>
                        <a href= "?Page=<?= $p; ?>" class = 'page_aktif'><?= $p; ?></a>
                    <?php else: ?>
                        <a href= "?Page=<?= $p; ?>"  class = 'page'><?= $p; ?></a>
                    <?php endif; ?>
                <?php endfor; ?>
                
                <?php if($data['halaman_saat_ini'] < $data['jumlah_halaman']): ?>
                    <a href = "?Page=<?= $data['halaman_saat_ini'] + 1; ?>"  class = 'pageLebih'>&raquo;</a>
                <?php endif; ?>

                <br>
            </div>
        </div>
    </div>
    </body>
</html>