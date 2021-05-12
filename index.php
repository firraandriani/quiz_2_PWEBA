<html>
<head>
    <title>Silahkan login dulu!!!</title>
    <style>
        .background {
            width: 38%;
            height: auto;
        }

        * {
            margin: 0; 
            padding: 0;
        }

        .content {
            margin-top: -670px;
            margin-left: 500px;
            text-align: center;
        }

        .textLogin {
            font-size: 3.5em;
            font-family: Forte;
        }

        b {
            font-family: Franklin Gothic Book;
            font-size: 1.2em;
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

        .validasi {
            width: 400px;
            height: 40px;
            border: none;
            outline: none;
            cursor: pointer;
            border-radius: 20px;
            font-family: Open Sans;
            font-size: 1.2em;
            text-align: center;
            font-weight: bold;
            color: black;
            background-color: lightgray;
            margin-left: 60px;
        }
    </style>
</head>
<body>
    <?php
    session_start();
    require 'db.php';
    $lib = new Library();

    if(isset($_COOKIE['id']) && isset($_COOKIE['key'])) {
        $id = $_COOKIE['id'];
        $key = $_COOKIE['key'];
        
        $cookies = $lib -> get_by_id($id);
        if($key == hash('sha256', $cookies['username'])) {
            $_SESSION["validasiLogin"] = true;
            $_SESSION['username'] = $cookies['username'];
            header('Location: tabel.php');
        }
    }

    if(isset($_POST['validasiLogin'])) { 
        $username = $_POST['username'];
        $password = $_POST['password'];

        $login = $lib -> login($username, $password);
        if(is_array($login)){
            $_SESSION["validasiLogin"] = true;
            $_SESSION['username'] = $username;
            if(isset($_POST['remember'])){
                setcookie('id', $login['id_mahasiswa'], time()+3600);
                setcookie('key', hash('sha256', $login['username']), time()+3600);
            }
            header('Location: tabel.php');
        }
        else {
            echo "<script type='text/javascript'>alert('$login');</script>";
        }
    }
    ?>
	<div><img src = "Login.jpeg"class ="background"></div>
        <div class = "boxLogin">
            <div class = "content">
                <b class = "textLogin">Login Now</b>
                <br>
                <form method = "post" action = "">
                    <br>
                    <div>
                        <b>Username : </b><input class = "form" type = "text" placeholder = "Masukkan Username" name = "username">
                    </div>
                    <br>
                    <div>
                        <b>Password : </b><input class = "form" type = "password" placeholder = "Masukkan Password" name = "password">
                    </div>
                    <br>
                    <div>
                        <input type = "checkbox" name = "remember" style = "margin-left: 60px;"><b style = "margin-left: 15px;">Remember me</b>
                    </div>
                    <br>
                    <button name = "validasiLogin" type = "submit" class = "validasi">Login</button>
                    <br><br>
                </form>
            </div>
        </div>
    </div>
</body>
</html>