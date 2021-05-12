<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "quiz_2";

try {
    $db_connect = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $db_connect -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "SELECT * FROM tabel_mahasiswa";
    $result = $db_connect -> query($sql);
} catch(PDOException $e) {
    echo $sql . "<br>" . $e->getMessage();
}

$db_connect = null;

class Library
{
    public function __construct()
    {
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "quiz_2";
        $this -> db_connect = new PDO("mysql:host={$servername};dbname={$dbname}", $username, $password);
    }
    
    public function login($username, $password)
    {
        $sql = "SELECT * FROM tabel_mahasiswa WHERE username = ? AND password = ?";
        $login = $this-> db_connect ->prepare($sql); 
        $login->bindParam(1, $username);
        $login->bindParam(2, $password);
        $login->execute();

        $count = $login->rowCount();
        if ($count == 0) { 
            return "Username atau Password salah ";
        }
        
        $temp = $login-> fetch();
        $data = [
            'id_mahasiswa' => $temp['id_mahasiswa'],
            'username' => $temp['username']
        ];

        return $data;
    }

    public function add_data($nama_lengkap, $nim, $kelas, $username_mahasiswa, $password_mahasiswa)
    {
        $pesan_error = NULL;
        $kelas = strtoupper($kelas);
        if (empty($password_mahasiswa)) {
            $pesan_error = "Password tidak boleh kosong";
        }
        if (empty($username_mahasiswa)) {
            $pesan_error = "Username tidak boleh kosong";
        }
        if (empty($kelas)) {
            $pesan_error = "Kelas tidak boleh kosong";
        }
        if (strlen($nim) != 12) {
            $pesan_error = "NIM harus berjumlah 12";
        }
        $cekNIM = $this-> db_connect -> prepare("SELECT * FROM tabel_mahasiswa where nim = $nim");
        $cekNIM -> execute();
        if ($cekNIM -> rowCount() != 0) {
            $pesan_error = "NIM tidak boleh sama";
        }
        if (!is_numeric($nim)) {
            $pesan_error = "NIM harus berupa angka";
        }
        if (empty($nim)) {
            $pesan_error = "NIM tidak boleh kosong";
        }
        if (empty($nama_lengkap)) {
            $pesan_error = "Nama lengkap tidak boleh kosong";
        }
        
        if (empty($pesan_error)) {
            $data = $this -> db_connect ->prepare('INSERT INTO tabel_mahasiswa (namaLengkap, nim, kelas, username, password) VALUES (?, ?, ?, ?, ?)');

            $data -> bindParam(1, $nama_lengkap);
            $data -> bindParam(2, $nim);
            $data -> bindParam(3, $kelas);
            $data -> bindParam(4, $username_mahasiswa);
            $data -> bindParam(5, $password_mahasiswa);
    
            $data -> execute();
            return $data -> rowCount();
        }

        return $pesan_error;
    }
    public function show()
    {
        $data = [];

        $jumlahDataSetiapPage = 50;
        $jumlahData = $this -> db_connect -> prepare("SELECT * FROM tabel_mahasiswa");
        $jumlahData -> execute();
        $jumlahData = $jumlahData -> fetchAll();
        $jumlahData = count($jumlahData);

        $jumlahPage = ceil($jumlahData / $jumlahDataSetiapPage);
        $halamanSaatIni = ( isset($_GET["Page"]) ) ? $_GET["Page"] : 1;
        $dataPertama = ($jumlahDataSetiapPage * $halamanSaatIni) - $jumlahDataSetiapPage;

        $query = $this -> db_connect -> prepare("SELECT * FROM tabel_mahasiswa LIMIT $dataPertama, $jumlahDataSetiapPage");
        $query -> execute();
        $daftarData = $query -> fetchAll();

        $data['list_data'] = $daftarData;
        $data['halaman_saat_ini'] = $halamanSaatIni;
        $data['jumlah_halaman'] = $jumlahPage;

        return $data;
    }
 
    public function get_by_id($id_mahasiswa){
        $query = $this-> db_connect -> prepare("SELECT * FROM tabel_mahasiswa where id_mahasiswa = ?");
        $query -> bindParam(1, $id_mahasiswa);
        $query -> execute();
        return $query -> fetch();
    }
 
    public function update($id_mahasiswa, $nama_lengkap, $nim, $kelas, $username_mahasiswa, $password_mahasiswa){
        $pesan_error = NULL;
        $kelas = strtoupper($kelas);
        if (empty($password_mahasiswa)) {
            $pesan_error = "Password tidak boleh kosong";
        }
        if (empty($username_mahasiswa)) {
            $pesan_error = "Username tidak boleh kosong";
        }
        if (empty($kelas)) {
            $pesan_error = "Kelas tidak boleh kosong";
        }
        if (strlen($nim) != 12) {
            $pesan_error = "NIM harus berjumlah 12";
        }
        if (!is_numeric($nim)) {
            $pesan_error = "NIM harus berupa angka";
        }
        if (empty($nim)) {
            $pesan_error = "NIM tidak boleh kosong";
        }
        if (empty($nama_lengkap)) {
            $pesan_error = "Nama lengkap tidak boleh kosong";
        }
        
        if (empty($pesan_error)) {
            $query = $this -> db_connect -> prepare('UPDATE tabel_mahasiswa set namaLengkap = ?, nim = ?, kelas = ?, username = ?, password = ? where id_mahasiswa = ?');
            
            $query -> bindParam(1, $nama_lengkap);
            $query -> bindParam(2, $nim);
            $query -> bindParam(3, $kelas);
            $query -> bindParam(4, $username_mahasiswa);
            $query -> bindParam(5, $password_mahasiswa);
            $query -> bindParam(6, $id_mahasiswa);

            $query -> execute();
            return $query -> rowCount();
        }
        return $pesan_error;
    }
 
    public function delete($id_mahasiswa)
    {
        $query = $this -> db_connect -> prepare ("DELETE FROM tabel_mahasiswa where id_mahasiswa = ?");
 
        $query -> bindParam(1, $id_mahasiswa);
 
        $query -> execute();
        return $query -> rowCount();
    }
 
}
?>