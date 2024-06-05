<?php
    session_start();

    include("function.php");

    $username = $_POST['username'];
    $password = $_POST['password'];

    if ($username != '' && $password != '') {
        $sql = "SELECT * FROM akun WHERE username='$username' AND password='$password'";
        $query = mysqli_query($conn, $sql);
        $data = mysqli_fetch_assoc($query);
        
        if (mysqli_num_rows($query) < 1) {
            setcookie("message", "Maaf, username atau password salah", time()+60);
            header("location: login.php"); // redirect ke halaman index.php
        } else {
            echo $data['username'] . $data['password'];
            $_SESSION['username'] = $data['username']; // set session username
            setcookie("message", "", time()-60); // delete cookie message
            header("location: index.php"); // redirect ke halaman welcome.php
        }
    } else {
        setcookie("message", "Username atau Password kosong", time()+60);
        header("location: login.php"); // redirect ke halaman index.php
    }

?>